<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $data = User::paginate();
    return view('admin.user.index', compact('data', ));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $positions = Position::all();
    return view('admin.user.create', compact('positions'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    // Validate dữ liệu
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6',
      'role' => 'required|in:admin,staff',
      'phone' => 'nullable|string|max:15',
      'adress' => 'nullable|string|max:255',
      'birthday' => 'nullable|date',
      'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'gender' => 'nullable|in:male,female,other',
      'position_id' => 'required|exists:positions,id',
    ]);

    // Nếu có avatar, xử lý upload
    if ($request->hasFile('avatar')) {
      $avatarPath = $request->file('avatar')->store('avatars', 'public');
      $validated['avatar'] = $avatarPath;
    }

    // Mã hóa password trước khi lưu
    $validated['password'] = Hash::make($request->password);

    // Tạo user
    User::create($validated);

    return redirect()->route('admin.users.index');
  }

  /**
   * Display the specified resource.
   */
  public function show(User $user)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(User $user)
  {
    $positions = Position::all();
    return view('admin.user.edit', compact('user', 'positions'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user)
  {
    // Validate dữ liệu
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,' . $user->id,
      'password' => 'nullable|min:6',
      'role' => 'required|in:admin,staff',
      'phone' => 'nullable|string|max:15',
      'adress' => 'nullable|string|max:255',
      'birthday' => 'nullable|date',
      'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
      'gender' => 'nullable|in:male,female,other',
      'position_id' => 'required|exists:positions,id',
    ]);

    // Nếu có avatar, xử lý upload
    if ($request->hasFile('avatar')) {
      // Xóa ảnh cũ nếu có
      if ($user->avatar) {
        Storage::delete('public/' . $user->avatar);
      }
      // Lưu ảnh mới
      $avatarPath = $request->file('avatar')->store('avatars', 'public');
      $validated['avatar'] = $avatarPath;
    }

    // Nếu có thay đổi mật khẩu, mã hóa và cập nhật
    if ($request->filled('password')) {
      $validated['password'] = Hash::make($request->password);
    } else {
      $validated['password'] = $user->password;
    }

    // Cập nhật dữ liệu người dùng
    $user->update($validated);

    return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công');
  }


  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'Xóa tài khoản thành công');
  }
}