<?php

namespace App\Http\Controllers;

use App\Models\Blog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{

    public function index()
    {
        $list = Blog::with('category', 'tags')->get();

        return response([
            'status' => __('errors.success'),
            'message' => __('errors.this_blog_list'),
            'dat' => [
                $list
            ]

        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|min:5',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'description' => 'required|string|min:5',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:enable,disable',
            'views' => 'required|integer|min:0'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => __('errors.error'),
                'message' => __('errors.validation_failed'),
                'errors' => $validator->errors(),
            ], 422);
        }
        $validatedData = $validator->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('blog', 'public');
            $validatedData['image'] = $path;
        }

        $blog = Blog::create($validatedData);

        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        }
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.Blog_created_successfully'),
            'data' => [
                $blog
            ]
        ], 201);
    }

    public function show($id)
    {
        $blog = Blog::with('category', 'tags')->find($id);
        $blog->increment('views');
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.data_processed_successfully'),
            'data' => [
                $blog
            ]
        ]);

    }

    public function update(Request $request, Blog $blog)
    {
        $rules = [
            'title' => 'required|string|min:5',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
            'description' => 'required|string|min:5',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:enable,disable',
            'views' => 'required|integer|min:0',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => __('errors.error'),
                'message' => __('errors.validation_failed'),
                'errors' => $validator->errors(),
            ], 422);
        }
        $validatedData = $validator->validated();

        if ($request->hasFile('image')) {
            Storage::delete('public/' . $blog->image);
            $path = $request->file('image')->store('blog', 'public');
            $validatedData['image'] = $path;
        }
        $blog->update($validatedData);

        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        }
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.blog_updated_successfully'),
            'data' => [
                $blog
            ]
        ]);
    }

    public function softDelete($id)
    {
        $blog = Blog::find($id);
        $blog->tags()->detach();
        Storage::delete('public/' . $blog->image);
        $blog->delete();
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.blog_soft-deleted_successfully')
        ]);
    }

}
