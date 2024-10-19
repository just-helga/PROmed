<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Employee::query()
            ->with('category', 'branch')
            ->get();

        return response()->json([
            'all' => $all
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name' => ['required', 'regex:/[A-Za-zА-Яа-яЁё0-9-]/u'],
            'img' => ['required', 'mimes:png,jpg,jpeg,bmb'],
            'description' => ['required'],
            'category_id' => ['required'],
            'branch_id' => ['required']
        ],[
            'name.required' => 'Обязательное поле',
            'name.regex' => 'Поле может содержать кириллицу, латиницу, цифры, пробез и тире',
            'img.required' => 'Обязательное поле',
            'img.mimes' => 'Разрешенные форматы: png,jpg,jpeg,bmb',
            'description.required' => 'Обязательное поле',
            'category_id.required' => 'Обязательное поле',
            'branch_id.required' => 'Обязательное поле'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $path_img = '';
        if ($request->file()) {
            $request->file('img')->store('/public/img/employees');
            $path_img = $request->file('img')->store('/img/employees');
        }

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->description = $request->description;
        $employee->category_id = $request->category_id;
        $employee->branch_id = $request->branch_id;
        $employee->img = '/public/storage/' . $path_img;
        $employee->save();

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
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee, Request $request)
    {
        $employee = Employee::query()
            ->where('id', $request->id)
            ->first();

        $validate = Validator::make($request->all(),[
            'name' => ['required', 'regex:/[A-Za-zА-Яа-яЁё0-9-]/u'],
            'img' => ['mimes:png,jpg,jpeg,bmb'],
            'description' => ['required'],
            'category_id' => ['required'],
            'branch_id' => ['required']
        ],[
            'name.required' => 'Обязательное поле',
            'name.regex' => 'Поле может содержать кириллицу, латиницу, цифры, пробез и тире',
            'img.mimes' => 'Разрешенные форматы: png,jpg,jpeg,bmb',
            'description.required' => 'Обязательное поле',
            'category_id.required' => 'Обязательное поле',
            'branch_id.required' => 'Обязательное поле'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $path_img = '';
        if ($request->file()) {
            $request->file('img')->store('/public/img/employees');
            $path_img = $request->file('img')->store('/img/employees');
            $employee->img = '/public/storage/' . $path_img;
        }

        $employee->name = $request->name;
        $employee->description = $request->description;
        $employee->category_id = $request->category_id;
        $employee->branch_id = $request->branch_id;

        $employee->save();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee, Request $request)
    {
        $employee = Employee::query()
            ->where('id', $request->id)
            ->delete();

        return redirect()->back();
    }
}
