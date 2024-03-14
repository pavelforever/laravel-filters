<?php

namespace App\Http\Controllers\Payments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Auth;
use App\Http\Controllers\Controller;
use App\Services\FondyPayment;
use Illuminate\Http\Request;
use App\Services\Payment;
use App\Models\Product;
use Exception;
class PaymentController extends Controller
{   

    public function payProcessing(FondyPayment $fondy){

        if(auth()->guest()){
            return redirect()->route('login')->with('error','You need to be registered to purchase products');
        }
        $cart = session('cart') ?? [];

        if (empty($cart)) {
            throw new Exception('Cart is empty');
        }
        $total = 0;
        foreach ($cart as $productId => $details) {
            $product = Product::find($productId);
            if ($product) {
                $total += $product->price * $details['quantity'];
            }
        }
        $data = [
            'total' => $total,
            'product_ids' => array_keys($cart),
        ];

        $payment = new Payment($fondy);
        $redirect = $payment->pay($data);
        session()->forget('cart');
        return redirect()->to($redirect, 307); 
    }
    
    public function callback(Request $request, FondyPayment $fondy){
        try{
            DB::beginTransaction();

            $payment = new Payment($fondy);
            $response = $payment->callback($request);
            $responseData = json_decode($response->getContent(), true);
            if($responseData['status'] ===  'successful'){
                DB::commit();
                return redirect()->route('main');
            }else {
                DB::rollBack();
                return redirect()->route('main')->with('error', $responseData['message']);
            }
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Transaction failed: '.$e], 500);
        }
       
    }
}
