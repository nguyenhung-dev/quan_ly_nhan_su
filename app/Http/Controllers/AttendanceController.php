<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorizeRole('staff');
        $user = Auth::user();
        $userId = $user->id;

        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập');
        }

        if ($user->role !== 'staff') {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập');
        }
        Carbon::setLocale('vi');
        $today = Carbon::today();
        $startOfWeek = $today->copy()->startOfWeek();
        $endOfWeek = $today->copy()->endOfWeek();

        $weekDates = [];
        for ($i = 0; $i < 7; $i++) {
            $currentDate = $startOfWeek->copy()->addDays($i);
            $attendance = Attendance::where('user_id', $user->id)
                ->whereDate('date', $currentDate)
                ->first();

            $weekDates[] = [
                'date' => $currentDate,
                'attendance' => $attendance,
                'is_today' => $currentDate->isToday(),
            ];
        }

        return view('employee.index', compact('user', 'weekDates'));
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
        $this->authorizeRole('staff');
        $user = Auth::user();
        if (!$user || $user->role !== 'staff') {
            return redirect()->route('login')->with('error', 'Không có quyền chấm công.');
        }

        $today = Carbon::today();
        $existing = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($existing) {
            return redirect()->route('employee.attendance.index')->with('error', 'Bạn đã chấm công hôm nay.');
        }

        Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'check_in' => Carbon::now()->format('H:i:s'),
            'status' => 'present',
        ]);

        return redirect()->route('employee.index')->with('success', 'Chấm công thành công!');
    }
    public function updateInfo(Request $request, User $user)
    {
        $this->authorizeRole('staff');
        $user = Auth::user();

        $emailRule = $request->email !== $user->email
            ? 'required|email|unique:users,email'
            : 'required|email';

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => $emailRule,
            'password' => 'nullable|min:6',
            'phone' => 'nullable|string|max:15',
            'adress' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'nullable|in:male,female,other',
        ]);

        // Xử lý avatar nếu có
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Xử lý password nếu có nhập
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('employee.index')->with('success', 'Cập nhật tài khoản thành công');
    }


    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
    public function myInfo()
    {
        $this->authorizeRole('staff');
        $user = Auth::user();
        $positions = Position::all();
        return view('employee.my-info', compact('user', 'positions'));
    }

    public function indexForAdmin()
    {
        $this->authorizeRole('admin');

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $users = User::where('role', '!=', 'admin')->get();

        $daysInMonth = collect();
        $startOfMonth = Carbon::create($year, $month, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $daysInMonth->push($date->copy());
        }

        $attendances = Attendance::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get()
            ->map(function ($item) {
                $item->date = Carbon::parse($item->date);
                return $item;
            })
            ->groupBy(function ($item) {
                return $item->user_id . '-' . $item->date->format('Y-m-d');
            });


        return view('admin.attendances.index', compact('users', 'daysInMonth', 'attendances'));
    }

    public function showForAdmin(Attendance $attendance)
    {
        $this->authorizeRole('admin');
        $attendance->date = Carbon::parse($attendance->date);
        $attendances = Attendance::all();

        return view('admin.attendances.detail', compact('attendance'));
    }
    public function updateForAdmin(Request $request, Attendance $attendance)
    {
        $this->authorizeRole('admin');
        // Validate dữ liệu nhập vào
        $validated = $request->validate([
            'status' => 'required|string|in:present,absent,late',
            'check_in' => 'nullable|date_format:H:i:s',
            'check_out' => 'nullable|date_format:H:i:s',
        ]);

        // Cập nhật bản ghi chấm công
        $attendance->update($validated);

        return redirect()->route('admin.attendances.index')->with('success', 'Cập nhật chấm công thành công');
    }
    public function destroyForAdmin(Attendance $attendance)
    {
        $this->authorizeRole('admin');
        // Xóa bản ghi chấm công
        $attendance->delete();
        return redirect()->route('admin.attendances.index')->with('success', 'Đã xóa chấm công');
    }
    public function checkIn(Request $request)
    {
        $this->authorizeRole('staff');
        $user = Auth::user();
        $today = Carbon::today();

        $existing = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($existing && $existing->check_in) {
            return redirect()->route('employee.index')->with('error', 'Bạn đã check-in hôm nay.');
        }

        $now = Carbon::now();
        $status = $now->gt(Carbon::createFromTime(8, 15, 0)) ? 'late' : 'present';

        if (!$existing) {
            Attendance::create([
                'user_id' => $user->id,
                'date' => $today,
                'check_in' => $now->format('H:i:s'),
                'status' => $status,
            ]);
        } else {
            $existing->update([
                'check_in' => $now->format('H:i:s'),
                'status' => $status,
            ]);
        }

        return redirect()->route('employee.index')->with('success', 'Check-in thành công!');
    }
    public function checkOut(Request $request)
    {
        $this->authorizeRole('staff');
        $user = Auth::user();
        $today = Carbon::today();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance || $attendance->check_out) {
            return redirect()->route('employee.index')->with('error', 'Bạn chưa check-in hoặc đã check-out rồi.');
        }

        $attendance->update([
            'check_out' => Carbon::now()->format('H:i:s'),
        ]);

        return redirect()->route('employee.index')->with('success', 'Check-out thành công!');
    }
    public function markAbsent(Request $request)
    {
        $this->authorizeRole('staff');
        $user = Auth::user();
        $today = Carbon::today();

        $existing = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($existing) {
            return redirect()->route('employee.index')->with('error', 'Bạn đã chấm công hôm nay.');
        }

        Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'status' => 'absent',
        ]);

        return redirect()->route('employee.index')->with('success', 'Đã ghi nhận nghỉ phép!');
    }
    public function showDetailForAdmin($id)
    {
        $this->authorizeRole('admin');
        $attendance = Attendance::findOrFail($id);
        $attendance->date = Carbon::parse($attendance->date);
        return view('admin.attendances.detail', compact('attendance'));
    }
    public function editForAdmin($id)
    {
        $this->authorizeRole('admin');
        $attendance = Attendance::findOrFail($id);
        $attendance->date = Carbon::parse($attendance->date);
        return view('admin.attendances.edit', compact('attendance'));
    }


}