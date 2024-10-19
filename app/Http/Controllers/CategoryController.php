<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Category::all();
        return response()->json([
            'all' => $all
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => ['required', 'regex:/[A-Za-zА-Яа-яЁё0-9-]/u', 'unique:categories'],
        ],[
            'title.required' => 'Обязательное поле',
            'title.unique' => 'Специализация уже существует',
            'title.regex' => 'Поле может содержать кириллицу, латиницу, цифры, пробез и тире'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $category = new Category();
        $category->title = $request->title;
        $category->save();

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category, Request $request)
    {
        $category = Category::query()
            ->where('id', $request->id)
            ->first();

        if (mb_strtolower($category->title) !== mb_strtolower($request->title)) {
            $validate_1 = Validator::make($request->all(), [
                'title' => ['unique:categories'],
            ],[
                'title.unique' => 'Специализация уже существует',
            ]);

            if ($validate_1->fails()) {
                return response()->json($validate_1->errors(), 400);
            }
        }

        $validate_2 = Validator::make($request->all(), [
            'title' => ['required', 'regex:/[A-Za-zА-Яа-яЁё0-9-]/u'],
        ],[
            'title.required' => 'Обязательное поле',
            'title.regex' => 'Поле может содержать кириллицу, латиницу, цифры, пробез и тире'
        ]);

        if ($validate_2->fails()) {
            return response()->json($validate_2->errors(), 400);
        }

        $category->title = $request->title;
        $category->update();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, Request $request)
    {
        $category = Category::query()
            ->where('id', $request->id)
            ->delete();

        return redirect()->back();
    }
}
