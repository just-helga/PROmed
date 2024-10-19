<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Application::query()
            ->with('service')
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
            'name' => ['required', 'regex:/[A-Za-zА-Яа-яЁё-]/u'],
            'phone' => ['required', 'regex:/(\+7|7|8)+([0-9]){10}/u'],
            'description' => ['required'],
            'service' => ['required'],
        ],[
            'name.required' => 'Обязательное поле',
            'name.regex' => 'Поле может содержать кириллицу, латиницу, пробел и тире',
            'phone.required' => 'Обязательное поле',
            'phone.regex' => 'Допустимый формат записи: +79999999999, 79999999999, 89999999999',
            'description.required' => 'Обязательное поле',
            'service.required' => 'Обязательное поле',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $application = new Application();
        $application->name = $request->name;
        $application->phone = $request->phone;
        $application->description = $request->description;
        $application->service_id = $request->service;
        $application->save();
        return response()->json('Ваша заявка отправлена, администратор свяжется с вами в ближайшее время', 200);
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
    public function show(Application $application)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        $validate = Validator::make($request->all(),[
            'employee_id' => ['required'],
            'date' => ['required'],
            'time' => ['required'],
        ],[
            'comment.required' => 'Обязательное поле',
            'date.required' => 'Обязательное поле',
            'time.required' => 'Обязательное поле',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $application = Application::query()
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->first();

        if ($application) {
            return response()->json('На данную дату и время уже есть запись', 403);
        } else {
            $application = Application::query()
                ->where('id', $request->id)
                ->first();
            $application->status = 'Подтвержденная';
            $application->employee_id = $request->employee_id;
            $application->date = $request->date;
            $application->time = $request->time;
            $application->update();
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application, Request $request)
    {
        $validate = Validator::make($request->all(),[
            'comment' => ['required']
        ],[
            'comment.required' => 'Обязательное поле'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $application = Application::query()
            ->where('id', $request->id)
            ->first();

        $application->status = 'Отмененная';
        $application->comment = $request->comment;
        $application->update();

        return redirect()->back();
    }
}
