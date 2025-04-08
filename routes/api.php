<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API routes ở đây

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});