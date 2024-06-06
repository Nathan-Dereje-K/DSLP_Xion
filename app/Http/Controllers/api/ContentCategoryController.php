<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContentCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ContentCategory::all();

        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:content_categories,name',
            'description' => 'nullable|string',
            'parent_category_id' => 'nullable|integer|exists:content_categories,id',
        ]);

        $category = ContentCategory::create($validatedData);

        return response()->json($category, 201); // Created status code
    }

    /**
     * Display the specified resource.
     *
     * @param  ContentCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(ContentCategory $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ContentCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContentCategory $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:content_categories,name,' . $category->id, // Exclude self from unique validation
            'description' => 'nullable|string',
            'parent_category_id' => 'nullable|integer|exists:content_categories,id',
        ]);

        $category->update($validatedData);

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ContentCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContentCategory $category)
    {
        if ($category->content->count() > 0) {
            throw ValidationException::withMessages(['message' => 'Cannot delete category with associated content.']);
        }

        $category->delete();

        return response()->json(['message' => 'Content category deleted successfully!']);
    }
}
