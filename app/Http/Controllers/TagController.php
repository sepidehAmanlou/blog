<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index()
    {
        $tag = Tag::get();
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.this_tag_list'),
            'data' => [
                $tag
            ]
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|min:5',
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
        $tag = Tag::create($validatedData);
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.tag_created_successfully'),
            'data' => [
                $tag
            ]
        ],201);
    }

    public function show($id)
    {
        $tag = Tag::with('blogs')->find($id);
         if (!$tag) {
            return response()->json([
                'status'  => __('errors.error'),
                'message' => __('errors.tag_not_found')
            ], 404);
        }
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.data_processed_successfully'),
            'data' => [
                $tag
            ]
        ]);
    }

    public function update(Request $request, Tag $tag)
    {
        $rules = [
            'title' => 'required|string|min:5',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => __('errors.error'),
                'message' => __('errors.validation_failed'),
                'data' => $validator->errors()
            ], 422);

        }

        $validatedData = $validator->validated();

        $tag->update($validatedData);
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.tag_updated_successfully'),
            'data' =>
                [
                    $tag
                ]
        ]);
    }

    public function destroy($id)
    {
        $tag = Tag::find($id);
          if (!$tag) {
            return response()->json([
                'status'  => __('errors.error'),
                'message' => __('errors.tag_not_found')
            ], 404);
        }
        $tag->blogs()->detach();
        $tag->delete();
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.tag_deleted_successfully')
        ]);
    }
}
