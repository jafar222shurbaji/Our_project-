<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardEmployeeRequest;
use App\Services\DashboardEmployeeService;
use App\Models\Employee;
use App\Models\Role;


class DashboardEmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(DashboardEmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        $employees = $this->employeeService->getAll();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.employees.create', compact('roles'));
    }

    public function store(DashboardEmployeeRequest $request)
    {
        $this->employeeService->create($request->validated());

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        $roles = Role::all();
        return view('admin.employees.edit', compact('employee', 'roles'));
    }

    public function update(DashboardEmployeeRequest $request, Employee $employee)
    {
        $this->employeeService->update($request->validated(), $employee);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $this->employeeService->delete($employee);

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function delete(Employee $employee)
    {
        return view('admin.employees.delete', compact('employee'));
    }
}






