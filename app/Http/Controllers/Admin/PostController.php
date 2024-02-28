<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Post;
use App\Http\Requests\StorePostsRequest;
use App\Http\Requests\UpdatePostsRequest;
use App\Services\PostService;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

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
    public function store(StorePostsRequest $request)
    {
        $data = $request->validated();
        try{

            $post = $this->postService->createPost($data);

            return redirect()->route('admin.posts.index');
        } catch(\Exception $exception){
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
        $data =  $request->validated();

        try {
            $post = $this->postService->updatePost($post,$data);

            redirect()->route('admin.posts.index');
        }catch(\Exception $ex){
            dd($ex);
            abort(500);
        }
        
    }
    public function destroy(Post $post)
    {
      $post->delete();

      return redirect()->route('admin.posts.index');
    }
    public function deletes(){
        $posts = Post::onlyTrashed()->get();
        return view('admin.post.restore', compact('posts'));
    }
    public function restore($id){
        $post = Post::onlyTrashed()->find($id);

        $post->restore();
        
        return redirect()->route('admin.posts.restore');
    }
}
