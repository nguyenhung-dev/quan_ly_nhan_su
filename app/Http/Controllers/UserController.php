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
    $this->authorizeRole('admin');
    $data = User::paginate();
    return view('admin.user.index', compact('data', ));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $this->authorizeRole('admin');
    $positions = Position::all();
    return view('admin.user.create', compact('positions'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $this->authorizeRole('admin');

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
    if ($request->hasFile('avatar')) {
      $avatarPath = $request->file('avatar')->store('avatars', 'public');
      $validated['avatar'] = $avatarPath;
    }

    $validated['password'] = Hash::make($request->password);

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
    $this->authorizeRole('admin');
    $positions = Position::all();
    return view('admin.user.edit', compact('user', 'positions'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, User $user)
  {
    $this->authorizeRole('admin');
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

    if ($request->hasFile('avatar')) {

      if ($user->avatar) {
        Storage::delete('public/' . $user->avatar);
      }
      $avatarPath = $request->file('avatar')->store('avatars', 'public');
      $validated['avatar'] = $avatarPath;
    }

    if ($request->filled('password')) {
      $validated['password'] = Hash::make($request->password);
    } else {
      $validated['password'] = $user->password;
    }

    $user->update($validated);

    return redirect()->route('admin.users.index')->with('success', 'Cập nhật tài khoản thành công');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(User $user)
  {
    $this->authorizeRole('admin');

    if ($user->id == Auth::id()) {
      return redirect()->route('admin.users.index')->with('error', 'Không thể xóa tài khoản đang đăng nhập');
    }

    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'Xóa tài khoản thành công');
  }
}