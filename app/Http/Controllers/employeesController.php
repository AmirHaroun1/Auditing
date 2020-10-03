<?php

namespace App\Http\Controllers;

use App\employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class employeesController extends Controller
{
    //
    public function index()
    {
         $employees = employee::latest()->paginate(50);
        return view('SuperAdmin.employees.index',compact('employees'));
    }
    public function create()
    {
        return view('SuperAdmin.employees.create');
    }
    public function store(StoreEmployeeRequest $request)
    {
        $request['password'] = Hash::make($request->password);
        employee::create(
            $request->except('password_confirmation')
        );

        return redirect()->route('employees.index')->with('success', 'قد تم اضافة موظف بنجاح');
    }
    public function edit(employee $employee)
    {
        return view('SuperAdmin.employees.edit',compact('employee'));
    }
    public function update(UpdateEmployeeRequest $request,employee $employee)
    {
        $employee->update($request->all());
        return redirect()->route('employees.index')->with('success', 'قد تم تعديل بيانات الموظف بنجاح');
    }
    public function destroy(employee $employee)
    {
         $employee->delete();
        return redirect()->route('employees.index')->with('success', 'قد تم حذف الموظف بنجاح');
    }
}
