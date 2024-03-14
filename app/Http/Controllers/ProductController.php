<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;


class ProductController extends Controller
{
    public function products(User $user){
    
        $products = $user->purchases;
        return view('profile.products',compact(['products','user']));
    }
    public function index()
    {
        $products =  Product::paginate(10);
        
        return view('main',compact(['products']));
    }

    public function admin_index()
    {
        $products =  Product::paginate(10);
        
        return view('admin.product.index',compact(['products']));
    }

    public function create()
    {   
        $category = Category::all();
        return view('admin.product.create', compact('category'));
    }
    public function store(StoreProductRequest $request, ProductService $service)
    {
        $data = $request->validated();

        $result = $service->createProduct($data);
        $response = json_decode($result->getContent(), true);

        if($response['status'] ===  'successful'){
            return redirect()->route('admin.products.index');
        }else{
            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }
    public function show(Product $product)
    {   
        return view('product.show',compact(['product']));
    }
    public function admin_show(Product $product)
    {   
        return view('admin.product.show',compact(['product']));
    }
    public function edit(Product $product)
    {
        $category = Category::all();

        return view('admin.product.edit',compact(['product','category']));
    }

    public function update(UpdateProductRequest $request, Product $product , ProductService $service)
    {
        $data = $request->validated();

        $result = $service->updateProduct($product,$data);
        $response = json_decode($result->getContent(), true);

        if($response['status'] ===  'successful'){
            return redirect()->route('admin.products.index');
        }else{

            return redirect()->back()->with('error', 'An error occurred. Please try again.');
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }

    public function generateDownloadLink(User $user,Product $product)
    {   
        if (Gate::denies('download-product',$product)) {
            return abort(403, 'Unauthorized action');
        }
        $token = sha1($product->id.$product->fileName . microtime());
        Cache::put('download_tkn_'.$product->id, $token, now()->addMinutes(5));
        $url =  URL::signedRoute('product.download',['product' => $product, 'download_tkn' => $token]);

        return response()->json(['download_link' => $url]);
    }

    
    public function download(Product $product,ProductService $service)  {
        
        return $service->downloadProduct($product);
    
    }
}
