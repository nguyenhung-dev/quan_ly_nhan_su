<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SalaryController;
use App\Models\Position;
use App\Http\Controllers\RewardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatisticController;

// === LOGIN SYSTEM ===
Route::get('/', function () {
    return view('form.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// === ADMIN Route ===
Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/', [StatisticController::class, 'index'])->name('index');

    Route::resource('users', UserController::class);
    Route::resource('position', PositionController::class);

    Route::get('/attendances', [AttendanceController::class, 'indexForAdmin'])->name('attendances.index');
    Route::get('/attendances/{attendance}', [AttendanceController::class, 'showForAdmin'])->name('attendances.show');
    Route::put('/attendances/{attendance}', [AttendanceController::class, 'updateForAdmin'])->name('attendances.update');
    Route::delete('/attendances/{attendance}', [AttendanceController::class, 'destroyForAdmin'])->name('attendances.destroy');
    Route::get('/attendances/{id}', [AttendanceController::class, 'showDetailForAdmin'])->name('attendances.showDetail');
    Route::get('/attendances/{id}/edit', [AttendanceController::class, 'editForAdmin'])->name('attendances.edit');
    Route::resource('/salary', SalaryController::class);
    Route::resource('/reward', RewardController::class);

});

// === EMPLOYEE Route ===
Route::prefix('employee')->as('employee.')->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('index');
    Route::resource('attendances', AttendanceController::class);
    Route::get('my-info', [AttendanceController::class, 'myInfo'])->name('my-info');
    Route::put('/my-info/update', [AttendanceController::class, 'updateInfo'])->name('my-info.update');
    Route::post('/attendances/checkin', [AttendanceController::class, 'checkIn'])->name('attendances.checkin');
    Route::post('/attendances/checkout', [AttendanceController::class, 'checkOut'])->name('attendances.checkout');
    Route::post('/attendances/absent', [AttendanceController::class, 'markAbsent'])->name('attendances.absent');


});

// === LOGOUT SYSTEM ===
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');