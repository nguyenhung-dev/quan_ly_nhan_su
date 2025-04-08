@extends('layouts.staff-layout')
@section('title', 'Chấm công')
@section('username', $user->name)
@section('avatar', $user->avatar)

@section('staff-body')
  <form action="{{ route('employee.my-info.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
    <label for="name" class="form-label">Họ và tên <span class="require">(*)</span></label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
    @error('name')
    <div class="text-danger">{{ $message }}</div>
  @enderror
    </div>

    <div class="mb-3">
    <label for="email" class="form-label">Email <span class="require">(*)</span></label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
    @error('email')
    <div class="text-danger">{{ $message }}</div>
  @enderror
    </div>

    <div class="mb-3">
    <label for="password" class="form-label">Mật khẩu</span></label>
    <input type="password" class="form-control" id="password" name="password">
    <small class="text-muted">Để trống nếu không thay đổi mật khẩu</small>
    </div>

    <div class="mb-3">
    <label for="phone" class="form-label">Số điện thoại</label>
    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
    </div>

    <div class="mb-3">
    <label for="adress" class="form-label">Địa chỉ</label>
    <input type="text" class="form-control" id="adress" name="adress" value="{{ old('adress', $user->adress) }}">
    </div>

    <div class="mb-3">
    <label for="avatar" class="form-label">Ảnh đại diện</label>
    <input type="file" class="form-control" id="avatar" name="avatar">
    @if($user->avatar)
    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" width="100">
  @endif
    </div>

    <div class="mb-3">
    <label for="birthday" class="form-label">Ngày sinh</label>
    <input type="date" class="form-control" id="birthday" name="birthday"
      value="{{ old('birthday', $user->birthday) }}">
    </div>

    <div class="mb-3">
    <div class="mb-1 form-check">
      <input type="radio" class="form-check-input" id="male" name="gender" value="male" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }}>
      <label class="form-check-label" for="male">Nam</label>
    </div>
    <div class="form-check">
      <input type="radio" class="form-check-input" id="female" name="gender" value="female" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }}>
      <label class="form-check-label" for="female">Nữ</label>
    </div>
    <div class="mb-3 form-check">
      <input type="radio" class="form-check-input" id="orther" name="gender" value="other" {{ old('gender', $user->gender) == 'other' ? 'checked' : '' }}>
      <label class="form-check-label" for="orther">Khác</label>
    </div>
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật tài khoản</button>
  </form>
@endsection