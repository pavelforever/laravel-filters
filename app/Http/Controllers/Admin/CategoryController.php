<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoriesRequest;

class CategoryController extends Controller
{
    public function index()
    {   
        $categories = Category::withCount('posts')->get();
        
        return view('admin.category.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.category.create');
    }
    public function store(StoreCategoriesRequest $request)
    {
        $category = $request->validated();
        Category::create($category);

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {   
        $category = Category::with('posts')->find($id);

        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoriesRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->update($data);

        return redirect()->route('admin.categories.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index');
    }

    public function deletes(){
        $categories = Category::onlyTrashed()->get();
        return view('admin.category.restore',compact('categories'));
    }
    public function restore($id){
        $category = Category::onlyTrashed()->find($id);
        $category->restore();
        return redirect()->route('admin.categories.restore');
    }
}
