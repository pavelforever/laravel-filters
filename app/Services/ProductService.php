<?php 

namespace App\Services;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\DB;

class ProductService {
    public function createProduct($data){
        try{
            DB::beginTransaction();

            $categories = [];
            if(array_key_exists('category_ids',$data)){
                $categories = $data['category_ids'];
                unset($data['category_ids']);
            }
            $product = new Product([
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'slug' => Str::slug($data['name']),
                'published' => $data['published'] ?? false,
            ]);
            $product->save();
            $file = $data['fileName'];
            $fileName = $file->hashName();
            $file->storeAs("products/{$product->slug}-{$product->id}", $fileName, 'private');

            $imagePath = Storage::disk('public')->put('products/images/', $data['imagePreview']);
            $image = Image::make(storage_path('app/public/'.$imagePath));
            $image->fit(600, 360);
            $image->save();

            $product->update(['fileName' => $fileName,'image' => $imagePath]);
            $product->categories()->sync($categories);

            DB::commit();
            return response()->json(['status' => 'succesful']);
        }catch(\Exception $x){
            // dd($x);
            DB::rollBack();
            return response()->json(['status' => 'failed']);
        }
    }
    public function updateProduct(Product $product, $data){
        try {
            DB::beginTransaction();

            $categories = [];
            if(array_key_exists('category_ids',$data)){
                $categories = $data['category_ids'];
                unset($data['category_ids']);
                $product->categories()->sync($categories);
            }else {
                $product->categories()->detach();
            }
            if(isset($data['fileName'])){
                Storage::disk('private')->delete("products/{$product->slug}-{$product->id}/{$product->fileName}");
                $file = $data['fileName'];
                $fileName = $file->hashName();
                $data['slug'] = Str::slug($data['name']);
                $file->storeAs("products/{$data['slug']}-{$product->id}", $fileName, 'private');
                $data['fileName'] = $fileName;
            }
            if(isset($data['image'])){
                Storage::disk('public')->delete($product['image']);

                $imagePath = Storage::disk('public')->put('products/images/', $data['image']);
                $image = Image::make(storage_path('app/public/'.$imagePath));
                $image->fit(600, 360);
                $image->save();

                $data['image'] = $imagePath;
            }
            $product->update($data);
            DB::commit();
            return response()->json(['status' => 'succesful']);
        }catch(\Exception $ex){
            // dd($ex);
            DB::rollBack();
            return response()->json(['status' => 'failed']);
        }
    }

    public function downloadProduct(Product $product) : StreamedResponse {
        try{
            if (Gate::denies('download-product',$product)) {
                return abort(403, 'Unauthorized action');
            }
            if(Cache::get('download_tkn_'.$product->id) === null){
                return abort(403, 'Link has expired');
            }
    
            $filePath = "products/{$product->slug}-{$product->id}/{$product->fileName}";
            
            if (Storage::disk('private')->exists($filePath)) {
    
                $mimeType = Storage::disk('private')->mimeType($filePath);
    
                Cache::forget('download_tkn_'.$product->id);
    
                return response()->stream(function () use ($filePath) {
                    echo Storage::disk('private')->get($filePath);
                }, 200, [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
                ]);
            }
        }catch(\Exception $ex){
            // dd($ex);
            return abort(403, 'Link has Expired');
        }
        
    }
}