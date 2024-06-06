<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\ContentCategory; // Assuming ContentCategory model exists
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $content = Content::with('category', 'instructor')->paginate(10); // Paginate results

        return response()->json($content);
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer|exists:content_categories,id',
            'content_type' => 'required|in:text,video,audio,quiz',
            'content_data' => 'required|string',
            'is_premium' => 'boolean',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|integer|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
            'instructor_id' => 'required|integer|exists:users,id',
        ]);

        $content = Content::create($validatedData);

        return response()->json($content, 201); // Created status code
    }

    /**
     * Display the specified resource.
     *
     * @param  Content  $content
     * @return \Illuminate\Http\Response
     */
    public function show(Content $content)
    {
        $content->load('category', 'instructor');

        return response()->json($content);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Content  $content
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Content $content)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer|exists:content_categories,id',
            'content_type' => 'required|in:text,video,audio,quiz',
            'content_data' => 'required|string',
            'is_premium' => 'boolean',
            'price' => 'nullable|numeric|min:0',
            'duration' => 'nullable|integer|min:0',
            'level' => 'required|in:beginner,intermediate,advanced',
            'instructor_id' => 'required|integer|exists:users,id',
        ]);

        $content->update($validatedData);

        return response()->json($content);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Content  $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Content $content)
    {
        $content->delete();

        return response()->json(['message' => 'Content deleted successfully!']);
    }
}
