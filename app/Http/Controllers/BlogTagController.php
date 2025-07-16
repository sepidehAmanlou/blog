<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogTagController extends Controller
{
    public function attachTag(Request $request)
    {

        $rules = [
            'blog_id' => 'required|exists:blogs,id',
            'tag_id' => 'required|array|min:1',
            'tag_id.*' => 'exists:tags,id'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([

                'status' => __('errors.error'),
                'message' => __('errors.validation_failed'),
                'data' => $validator->errors()
            ],422);
        }
        $validatedData = $validator->validated();
        $blog = Blog::find($validatedData['blog_id']);
        $blog->tags()->attach($validatedData['tag_id']);
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.tag_attached_successfully')
        ],200);


    }

    public function detachTag(Request $request)
    {
        $rules = [
            'blog_id' => 'required|exists:blogs,id',
            'tag_id' => 'required|array|min:1',
            'tag_id.*' => 'exists:tags,id'

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([

                'status' => __('errors.error'),
                'message' => __('errors.validation_failed'),
                'data' => $validator->errors()
            ],422);
        }

        $validatedData = $validator->validated();
        $blog = Blog::find($validatedData['blog_id']);
        $blog->tags()->detach($validatedData['tag_id']);
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.tag_detached_successfully')
        ]);
    }
}
