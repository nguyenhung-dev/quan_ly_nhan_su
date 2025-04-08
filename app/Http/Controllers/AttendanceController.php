<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    public function updateInfo(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra nếu email bị thay đổi thì mới áp dụng rule unique
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
            unset($validated['password']); // Không cập nhật nếu không có
        }

        // Không cho cập nhật role hoặc position_id ở đây (nếu cần bảo mật thêm)

        // Cập nhật thông tin
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

    public function indexForAdmin()
    {
        // Lấy tất cả nhân viên
        $users = User::where('role', '!=', 'admin')->get();

        // Tạo một mảng để chứa dữ liệu attendances
        $attendances = [];

        // Lặp qua tất cả các nhân viên
        foreach ($users as $user) {
            // Lấy bản ghi chấm công của nhân viên trong tuần này (hoặc ngày hôm nay)
            $attendance = Attendance::where('user_id', $user->id)->first();

            // Nếu không có bản ghi chấm công, tạo một bản ghi giả (hoặc có thể bỏ qua nếu không cần)
            if (!$attendance) {
                $attendance = new Attendance([
                    'user_id' => $user->id,
                    'date' => Carbon::today(),
                    'check_in' => null, // Không có giờ vào
                    'check_out' => null, // Không có giờ ra
                    'status' => 'absent', // Chưa chấm công thì là vắng
                ]);
            }
            $attendance->date = Carbon::parse($attendance->date);

            // Thêm thông tin chấm công vào mảng attendances
            $attendances[] = $attendance;
        }

        // Trả về view với dữ liệu attendances
        return view('admin.attendances.index', compact('attendances'));
    }
    public function showForAdmin(Attendance $attendance)
    {
        $attendance->date = Carbon::parse($attendance->date);

        return view('admin.attendances.show', compact('attendance'));
    }
    public function updateForAdmin(Request $request, Attendance $attendance)
    {
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
        // Xóa bản ghi chấm công
        $attendance->delete();
        return redirect()->route('admin.attendances.index')->with('success', 'Đã xóa chấm công');
    }
}