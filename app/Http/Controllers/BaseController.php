<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
  protected function ensureAdmin()
  {
    if (!Auth::check() || Auth::user()->role !== 'admin') {
      abort(403, 'Không có quyền truy cập trang Admin');
    }
  }

  protected function ensureStaff()
  {
    if (!Auth::check() || Auth::user()->role !== 'staff') {
      abort(403, 'Không có quyền truy cập trang Nhân viên');
    }
  }
}