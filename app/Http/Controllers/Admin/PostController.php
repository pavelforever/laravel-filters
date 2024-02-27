<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Post;
use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdatePostsRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
      $posts =  Post::all();
      
      return view('admin.post.index', compact('posts'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     $category = Category::all();
     $tags = Tag::all();

     return view('admin.post.create', compact('category','tags'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriesRequest $request)
    {
        $tags = [];
        try{
            DB::beginTransaction();
            $data = $request->validated();
            dd(gettype($data));
            if(array_key_exists('tag_ids',$data['tag_ids'])){
                $tags = $data['tag_ids'];
                unset($data['tag_ids']);
            }

            $data['image'] = Storage::disk('public')->put('images',$data['image']);
            $previewImagePath = Storage::disk('public')->put('images', $data['preview_image']);
            $imagePreview = Image::make(storage_path('app/public/'.$previewImagePath));
            $imagePreview->fit(600,360);
            $imagePreview->save();

            $data['imagePreview'] = $previewImagePath;

            $post = Post::create($data);

            $post->tags->attach($tags);
            
            DB::commit();

        } catch(\Exception $exception){
            DB::rollBack();
            dd($exception);
            abort(500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
       return view('admin.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
       $category = Category::all();
       $tags = Tag::all();

       return view('admin.post.edit', compact('post','category','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostsRequest $request, Post $post)
    {
        $tagIds = [];
        try{
            DB::beginTransaction();

            $data = $request->validated();

            if(array_key_exists('tag_ids',$data['tag_ids'])){
                $tagIds = $data['tag_ids'];
                unset($data['tag_ids']);
                $post->tags()->sync($tagIds);
            }else {
                $post->tags()->detach();
            }

            if($request->hasFile('image')){
                Storage::disk('public')->delete($post->image);
                $data['image'] = Storage::disk('public')->put('images',$data['image']);
            }
            if($request->hasFile('previewImage')){
                Storage::disk('public')->delete($post->imagePreview);
                $previewImagePath = Storage::disk('public')->put('images',$data['previewImage']);

                $previewImage = Image::make(storage_path('app/public'.$previewImagePath));
                $previewImage->fit(600,360);

                $previewImage->save();

                $data['imagePreview'] = $previewImagePath;
            }

            $post->update($data);
            
            DB::commit();
            
        }catch(\Exception $ex){
            DB::rollBack();
            dd($ex);
            abort(500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
      $post->delete();

      return redirect()->route('admin.posts.index');
    }
}
