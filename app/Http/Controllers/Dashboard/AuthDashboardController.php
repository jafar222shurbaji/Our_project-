<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardLoginRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthDashboardController extends Controller
{
    //
     public function showLogin()
    {
        return view('auth.login');
    }
    public function login(DashboardLoginRequest $request)
    {
        $employee = Employee::where('email', $request->email)->first();

        if ($employee && Hash::check($request->password, $employee->password)) {
            Auth::guard('employee')->login($employee);
            return $this->redirectBasedOnRole($employee->role_id);
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
     private function redirectBasedOnRole($roleId)
    {
        $roleRoutes = [
            1 => 'employees.index',
            2 => 'products.index',
            3 => 'orders.index',
        ];

        $defaultRoute = 'login';

        return redirect()->route($roleRoutes[$roleId] ?? $defaultRoute);
    }
    // private function redirectBasedOnRole($roleId)
    // {
    //     switch ($roleId) {
    //         case 1: // Employee Manager
    //             return redirect()->route('employees.index');
    //         case 2: // Product Manager
    //             return redirect()->route('products.index');
    //         case 3: // Order Manager
    //             return redirect()->route('orders.index');
    //         default:
    //             return redirect()->route('lo');
    //     }
    // }

}







