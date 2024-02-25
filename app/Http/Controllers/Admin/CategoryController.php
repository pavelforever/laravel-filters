<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoriesRequest;

class CategoryController extends Controller
{
    public function index()
    {   
        $categories = Category::all();
        
        return view('admin.categories.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.category.create');
    }
    public function store(StoreCategoriesRequest $request)
    {
        $category = $request->validated();

        $request->user()->Category()->create($category);

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $categories)
    {
        return view('admin.category.edit',compact('categories'));
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
}
