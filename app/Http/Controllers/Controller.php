<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    protected function authorizeRole($role)
    {
        $user = Auth::user();

        if (!$user || $user->role !== $role) {
            abort(403, 'Không có quyền truy cập');
        }
    }

}