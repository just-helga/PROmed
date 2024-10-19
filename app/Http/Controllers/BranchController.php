<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Branch::all();

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
            'address' => ['required'],
            'time_start' => ['required'],
            'time_end' => ['required'],
            'days' => ['required'],
        ],[
            'address.required' => 'Обязательное поле',
            'time_start.required' => 'Обязательное поле',
            'time_end.required' => 'Обязательное поле',
            'days.required' => 'Обязательное поле',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $branch = new Branch();
        $branch->address = $request->address;
        $branch->time_start = date('H:i', strtotime($request->time_start));
        $branch->time_end = date('H:i', strtotime($request->time_end));
        $branch->days = implode(", ", $request->days);
        $branch->save();

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
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch, Request $request)
    {
        $branch = Branch::query()
            ->where('id', $request->id)
            ->first();

        $validate = Validator::make($request->all(), [
            'address' => ['required'],
            'time_start' => ['required'],
            'time_end' => ['required'],
            'days' => ['required', 'regex:/[А-Яа-яЁё]/u'],
        ],[
            'address.required' => 'Обязательное поле',
            'time_start.required' => 'Обязательное поле',
            'time_end.required' => 'Обязательное поле',
            'days.required' => 'Обязательное поле',
            'days.regex' => 'Поле может содержать только кириллицу'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $branch->address = $request->address;
        $branch->time_start = date('H:i', strtotime($request->time_start));
        $branch->time_end = date('H:i', strtotime($request->time_end));
        $branch->days = $request->days;
        $branch->update();

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch, Request $request)
    {
        $branch = Branch::query()
            ->where('id', $request->id)
            ->delete();

        return redirect()->back();
    }
}
