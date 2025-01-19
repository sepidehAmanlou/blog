<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::get();
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.this_category_list'),
            'data' => [
                $category
            ]
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|min:5'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => __('errors.error'),
                'message' => __('errors.validation_failed'),
                'errors' => $validator->errors()
            ], 422);
        }

        $validatedData = $validator->validated();

        $category = Category::create($validatedData);
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.category_created_successfully'),
            'data' => [
                $category
            ]
        ]);
    }

    public function show($id)
    {
        $category = Category::with('blogs')->find($id);
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.data_processed_successfully'),
            'data' => [
                $category
            ]
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $rules = [
            'title' => 'required|string|min:5',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => __('errors.error'),
                'message' => __('errors.validation_failed'),
                'dat' => $validator->errors()
            ], 422);
        }
        $validatedData = $validator->validated();

        $category->update($validatedData);

        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.category_updated_successfully'),
            'data' => [
                $category
            ]
        ]);

    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json([
            'status' => __('errors.success'),
            'message' => __('errors.category_deleted_successfully'),
        ]);

    }

}
