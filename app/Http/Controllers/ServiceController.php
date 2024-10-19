<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Service::query()
            ->with('category')
            ->get();

        return response()->json([
            'all' => $all
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'title' => ['required'],
            'img' => ['required', 'mimes:png,jpg,jpeg,bmb'],
            'category_id' => ['required'],
            'description' => ['required'],
            'price' => ['required', 'numeric', 'between:1,999999'],
        ],[
            'title.required' => 'Обязательное поле',
            'img.required' => 'Обязательное поле',
            'img.mimes' => 'Разрешенные форматы: png,jpg,jpeg,bmb',
            'category_id.required' => 'Обязательное поле',
            'description.required' => 'Обязательное поле',
            'price.required' => 'Обязательное поле',
            'price.numeric' => 'Тип данных - числовой',
            'price.between' => 'Разрешенный диапазон цены от 1 до 999999',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $path_img = '';
        if ($request->file()) {
            $request->file('img')->store('/public/img/services');
            $path_img = $request->file('img')->store('/img/services');
        }

        $service = new Service();
        $service->title = $request->title;
        $service->price = $request->price;
        $service->category_id = $request->category_id;
        $service->description = $request->description;
        $service->img = '/public/storage/' . $path_img;

        $service->save();
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
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service, Request $request)
    {
        $service = Service::query()
            ->where('id', $request->id)
            ->first();

        $validate = Validator::make($request->all(),[
            'title' => ['required'],
            'img' => ['mimes:png,jpg,jpeg,bmb'],
            'category_id' => ['required'],
            'description' => ['required'],
            'price' => ['required', 'numeric', 'between:1,999999'],
        ],[
            'title.required' => 'Обязательное поле',
            'img.mimes' => 'Разрешенные форматы: png,jpg,jpeg,bmb',
            'category_id.required' => 'Обязательное поле',
            'description.required' => 'Обязательное поле',
            'price.required' => 'Обязательное поле',
            'price.numeric' => 'Тип данных - числовой',
            'price.between' => 'Разрешенный диапазон цены от 1 до 999999',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $path_img = '';
        if ($request->file()) {
            $path_img = $request->file('img')->store('/public/img/services');
            $service->img = '/public/storage/' . $path_img;
        }

        $service->title = $request->title;
        $service->price = $request->price;
        $service->category_id = $request->category_id;
        $service->description = $request->description;

        $service->update();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service, Request $request)
    {
        $service = Service::query()
            ->where('id', $request->id)
            ->delete();

        return redirect()->back();
    }
}
