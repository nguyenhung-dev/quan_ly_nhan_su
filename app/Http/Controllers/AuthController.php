<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $type = $request->input('type'); // admin hoặc staff

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($type === 'admin' && $user->role === 'admin') {
                return redirect()->route('admin.index');
            } elseif ($type === 'staff' && $user->role === 'staff') {
                return redirect()->route('employee.index');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập vào hệ thống này');
            }
        }

        return back()->with('error', 'Thông tin đăng nhập không chính xác');
    }

    // Handle Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất thành công!');
    }
}