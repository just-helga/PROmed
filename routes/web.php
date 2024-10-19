<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//--------------------------------------------------СТРАНИЦЫ--------------------------------------------------
Route::get('/', [PageController::class, 'MainPage'])->name('MainPage');
Route::get('/services', [PageController::class, 'ServicesList'])->name('ServicesList');
Route::get('/employee', [PageController::class, 'EmployeeList'])->name('EmployeeList');
Route::get('/contacts', [PageController::class, 'ContactsPage'])->name('ContactsPage');
Route::get('/service/more/{service?}', [PageController::class, 'ServiceMorePage'])->name('ServiceMorePage');
Route::get('/employee/more/{employee?}', [PageController::class, 'EmployeeMorePage'])->name('EmployeeMorePage');
Route::get('/authorization', [PageController::class, 'AuthorizationPage'])->name('login');




//--------------------------------------------------ФУНКЦИИ---------------------------------------------------
Route::post('/authorization/entry', [UserController::class, 'Authorization'])->name('Authorization');
Route::get('/exit', [UserController::class, 'Exit'])->name('Exit');

Route::get('/categories/get', [CategoryController::class, 'index'])->name('CategoryGet');
Route::get('/services/get', [ServiceController::class, 'index'])->name('ServiceGet');
Route::get('/branches/get', [BranchController::class, 'index'])->name('BranchGet');
Route::get('/employees/get', [EmployeeController::class, 'index'])->name('EmployeeGet');
Route::post('/application/make', [ApplicationController::class, 'create'])->name('MakeAnApplication');



//--------------------------------------------------АДМИНКА---------------------------------------------------
Route::group(['middleware'=>['auth', 'admin'], 'prefix'=>'xxxxxx/admin'], function () {
    //----------Специализация
    Route::get('/categories', [PageController::class, 'CategoryPage'])->name('CategoryPage');
    Route::post('/category/add', [CategoryController::class, 'create'])->name('CategoryAdd');
    Route::post('/category/edit', [CategoryController::class, 'edit'])->name('CategoryEdit');
    Route::post('/category/delete', [CategoryController::class, 'destroy'])->name('CategoryDelete');
    //----------Услуги
    Route::get('/services', [PageController::class, 'ServicePage'])->name('ServicePage');
    Route::post('/service/add', [ServiceController::class, 'create'])->name('ServiceAdd');
    Route::post('/service/edit', [ServiceController::class, 'edit'])->name('ServiceEdit');
    Route::post('/service/delete', [ServiceController::class, 'destroy'])->name('ServiceDelete');
    //----------Филиалы
    Route::get('/branches', [PageController::class, 'BranchPage'])->name('BranchPage');
    Route::post('/branch/add', [BranchController::class, 'create'])->name('BranchAdd');
    Route::post('/branch/edit', [BranchController::class, 'edit'])->name('BranchEdit');
    Route::post('/branch/delete', [BranchController::class, 'destroy'])->name('BranchDelete');
    //----------Сотрудники
    Route::get('/employees', [PageController::class, 'EmployeePage'])->name('EmployeePage');
    Route::post('/employee/add', [EmployeeController::class, 'create'])->name('EmployeeAdd');
    Route::post('/employee/edit', [EmployeeController::class, 'edit'])->name('EmployeeEdit');
    Route::post('/employee/delete', [EmployeeController::class, 'destroy'])->name('EmployeeDelete');
    //----------Заявки
    Route::get('/applications', [PageController::class, 'ApplicationPage'])->name('ApplicationPage');
    Route::get('/applications/get', [ApplicationController::class, 'index'])->name('ApplicationGet');
    Route::post('/applications/refuse', [ApplicationController::class, 'destroy'])->name('ApplicationRefuse');
    Route::post('/applications/confirm', [ApplicationController::class, 'update'])->name('ApplicationСonfirm');
});
