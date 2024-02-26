<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Requests\StoreTagsRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $tags = Tag::withCount('posts')->get();
        
        return view('admin.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagsRequest $request)
    {
        $tag = $request->validated();

        Tag::create($tag);

        return redirect()->route('admin.tags.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return view('admin.tag.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tag.edit',compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTagsRequest $request, Tag $tag)
    {
        $data = $request->validated();
        $tag->update($data);

        return redirect()->route('admin.tags.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index');
    }

    public function deletes(){
        $tags = Tag::onlyTrashed()->get();

        return view('admin.tag.restore', compact('tags'));
    }
    public function restore($id){
        $tag = Tag::onlyTrashed()->find($id);

        $tag->restore();
        
        return redirect()->route('admin.tags.restore');
    }

}
