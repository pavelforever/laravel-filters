<?php 

namespace App\Services;
use App\Models\Order;
use App\Interfaces\PaymentGateway;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use GuzzleHttp\Client;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
class FondyPayment implements PaymentGateway {

    public function pay($request){

        $client = new Client();
        $order_id = Uuid::uuid4()->toString();

        $params = [
            'order_id' => $order_id,
            'currency' => Config::get('services.fondy.currency'),
            'amount' => intval($request['total'] * 100),
            'order_desc' => 'Payment for Order #' . $order_id,
            'merchant_id' => intval(Config::get('services.fondy.merchant_id')),
            'response_url' => route('fondy.callback'),
            'server_callback_url' => route('fondy.callback'),

        ];
        $params['version'] = '1.0.1';
        $params['signature'] =  self::getSignature(Config::get('services.fondy.merchant_id'),Config::get('services.fondy.merchant_password'),$params);


        // Use Guzzle for the HTTP request
        $responseGuzzle = $client->post('https://pay.fondy.eu/api/checkout/url', [
            'form_params' => $params,
        ]);
        parse_str($responseGuzzle->getBody()->getContents(), $response);

        if($response['response_status'] == 'success'){
            $payment = Order::make([
                '_token' => csrf_field(),
                'user_id' => auth()->id(),
                'transaction_id' => $response['payment_id'],
                'total' => $request['total'],
                'status' => 'pending',
            ]);
            $payment->save();

            $payment->products()->attach($request['product_ids']);
            
            $redirect = $response['checkout_url'];
            
            return $redirect;
        }   
    }

    public function callback($request) {   

        $status = $request->input('order_status');
        $amount = intval($request->input('amount'));
        $payment_id = $request->input('payment_id');
        self::check($request->all());
        $order = Order::where('transaction_id', $payment_id)->first();
        if(!$order){
            return response()->json(['status' => 'error', 'message' => 'Invalid order ID'], 400);
        }
        if(intval($amount) != $order->total*100){
            return response()->json(['status' => 'error', 'message' => 'Invalid amount'], 400);
        }
        if($status == 'approved'){
            $user = (new User())->find($order->user_id);
            auth()->login($user);  // Workaround with session expired when redirecting from third-party page
            $order->update(['status' => 'paid']);
            foreach($order->products as $product){
                $quantity = $product->pivot->quantity;
                $existingPurchase = $user->purchases()->where('product_id', $product->id)->first();
                if ($existingPurchase) {
                    $existingPurchase->update(['quantity' => $quantity + 1]);
                } else {
                    $user->purchases()->attach($product, ['quantity' => $quantity]);
                }
            }
            DB::commit();
            return response()->json(['status' => 'successful']);
        }else {
            $order->update(['status' => 'failed']);
            return response()->json(['status' => 'failed', 'message-' => 'Payment processing is failed', 400]);
        }
       
    }

    public static function clean(Array $data){
        if( array_key_exists('response_signature_string',$data) )
            unset( $data['response_signature_string'] );
        unset( $data['signature'] );
        return $data;
    }

    public static function check(Array $response){
        if(!array_key_exists('signature',$response)) return FALSE;
        $signature = $response['signature'];
        $response  = self::clean($response);
        return $signature == self::getSignature(Config::get('services.fondy.merchant_id'),Config::get('services.fondy.merchant_password'),$response);
    }

    public static function getSignature( $merchant_id , $password , $params = array() ){
        $params['merchant_id'] = $merchant_id;
        $params = array_filter($params,'strlen');
        ksort($params);
        $params = array_values($params);
        array_unshift( $params , $password );
        $params = join('|',$params);
        return(sha1($params));
       }
}