<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //----------ОБЩИЕ СТРАНИЦЫ
    public function AuthorizationPage() {
        return view('guest.authorization');
    }
    public function MainPage() {
        $employees = Employee::query()
            ->limit(4)
            ->get();

        return view('welcome', ['employees' => $employees]);
    }
    public function ServicesList() {
        return view('services');
    }
    public function ServiceMorePage(Service $service) {
        $employees = Employee::query()
            ->where('category_id', $service->category_id)
            ->get();

        return view('detail.service', ['service' => $service, 'employees' => $employees]);
    }
    public function EmployeeList() {
        return view('employees');
    }
    public function EmployeeMorePage(Employee $employee) {
        return view('detail.employee', ['employee' => $employee]);
    }
    public function ContactsPage() {
        $branches = Branch::all();
        return view('contacts', ['branches'=>$branches]);
    }
    //----------СТРАНИЦЫ АДМИНИСТРАТОРА
    public function CategoryPage() {
        return view('admin.categories');
    }
    public function ServicePage() {
        return view('admin.services');
    }
    public function BranchPage() {
        return view('admin.branches');
    }
    public function EmployeePage() {
        return view('admin.employees');
    }
    public function ApplicationPage() {
        return view('admin.applications');
    }
}
