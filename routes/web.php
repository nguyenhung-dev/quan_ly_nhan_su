<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AuthController;
use App\Models\Position;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// === LOGIN SYSTEM ===
Route::get('/', function () {
    return view('form.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');


// === ADMIN Route ===
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('index');
    Route::resource('users', UserController::class);
    Route::resource('position', PositionController::class);

    Route::get('attendances', [AttendanceController::class, 'indexForAdmin'])->name('admin.attendances.index');
    Route::get('attendances/{attendance}', [AttendanceController::class, 'showForAdmin'])->name('admin.attendances.show');
    Route::put('attendances/{attendance}', [AttendanceController::class, 'updateForAdmin'])->name('admin.attendances.update');
    Route::delete('attendances/{attendance}', [AttendanceController::class, 'destroyForAdmin'])->name('admin.attendances.destroy');
});

// === EMPLOYEE Route ===
Route::group(['prefix' => 'employee', 'as' => 'employee.', 'middleware' => ['auth', 'role:staff']], function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('index');
    Route::resource('attendances', AttendanceController::class);
    Route::get('my-info', function () {
        $user = Auth::user();
        $positions = Position::all();
        return view('employee.my-info', compact('user', 'positions'));
    })->name('my-info');
    Route::put('/my-info/update', [AttendanceController::class, 'updateInfo'])->name('my-info.update');
});


// === LOGOUT SYSTEM ===
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');