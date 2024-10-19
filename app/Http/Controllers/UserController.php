<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function Authorization(Request $request) {
        $validate = Validator::make($request->all(), [
           'login' => ['required'],
            'password' => ['required']
        ],[
            'login.required' => 'Обязательное поле',
            'password.required' => 'Обязательное поле'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $user = User::query()
            ->where('login', $request->login)
            ->where('password', md5($request->password))
            ->first();

        if ($user) {
            Auth::login($user);
            return redirect()->route('MainPage');
        } else {
            return response()->json('Неверный логин или пароль', 403);
        }
    }

    public function Exit() {
        Auth::logout();
        return redirect()->route('MainPage');
    }
}
