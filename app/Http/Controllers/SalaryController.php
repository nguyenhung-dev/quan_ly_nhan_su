<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorizeRole('admin');

        $month = now()->month;
        $year = now()->year;
        $daysInMonth = now()->daysInMonth;

        $users = User::with('position')->get();
        $salaries = [];

        foreach ($users as $user) {
            $attendances = $user->attendances()
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->get();

            $checkedInDays = $attendances->count();
            $absentDays = $daysInMonth - $checkedInDays;
            $penalty = ($absentDays / $daysInMonth >= 0.2) ? 200000 : 0;

            $baseSalary = $user->position->base_salary;
            $dailySalary = $baseSalary / $daysInMonth;
            $finalSalary = ($dailySalary * $checkedInDays) - $penalty;

            // Tạo hoặc cập nhật lương
            $salary = Salary::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'month' => $month,
                    'year' => $year,
                ],
                [
                    'total_working_days' => $checkedInDays,
                    'late_or_absent_days' => $absentDays,
                    'bonus' => 0,
                    'penalty' => $penalty,
                    'final_salary' => $finalSalary,
                    'status' => 'Đang tính toán',
                ]
            );

            $salary->user = $user;
            $salary->working_display = $checkedInDays . '/' . $daysInMonth;
            $salaries[] = $salary;
        }

        return view('admin.salary.index', compact('salaries', 'month', 'year'));
    }

    public function show($id)
    {
        $this->authorizeRole('admin');
        $salary = Salary::with('user.position')->findOrFail($id);
        return view('admin.salary.show', compact('salary'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salary $salary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        //
    }


}