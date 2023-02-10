<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get Categories
        $categories = Category::when(request()->q, function ($categories) {
            $categories = $categories->where('name', 'like', '%' . request()->q . '%');
        })->latest()->paginate(10);

        // Return Inertia
        return Inertia::render('Apps/Categories/Index', [
            'categories' => $categories,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return Inertia
        return Inertia::render('Apps/Categories/Create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validate Request
        $this->validate($request, [
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2000',
            'name' => 'required|unique:categories',
            'description' => 'required',
        ]);

        // Upload Image
        $image = $request->file('image');
        $image->storeAs('public/categories', $image->hashName());

        // Create Category
        Category::create([
            'image' => $image->hashName(),
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Redirect
        return redirect()->route('apps.categories.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {

        return Inertia::render('Apps/Categories/Edit', [
            'category' => $category,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        /**
         * Validate Request
         */
        $this->validate($request, [
            'name' => 'required|unique:categories,name,' . $category->id,
            'description' => 'required',
        ]);

        /**
         * Check Image Update
         */
        if ($request->file('image')) {
            // Remove Old Storage
            Storage::disk('local')->delete('public/categories/' . basename($category->image));

            // Upload New Image
            $image = $request->file('image');
            $image->storeAs('public/categories', $image->hashName());

            // Update Category With Image
            $category->update([
                'image' => $image->hashName(),
                'name' => $request->name,
                'description' => $request->description,
            ]);
        }

        // Update Category Without Image
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Redirect
        return redirect()->route('apps.categories.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // Find by ID
        $category = Category::findOrFail($id);

        // Remove
        $category->delete();

        // Redirect
        return redirect()->route('apps.categories.index');
    }
}
