<?php
namespace App\Http\Controllers;

use App\Models\User;

class StatisticController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $month = now()->month;
    $year = now()->year;

    $users = User::with([
      'position',
      'salary' => function ($query) use ($month, $year) {
        $query->where('month', $month)->where('year', $year);
      },
      'rewards' => function ($query) use ($month, $year) {
        $query->whereMonth('date', $month)->whereYear('date', $year);
      }
    ])->get();

    return view('admin.index', compact('users', 'month', 'year'));
  }

}