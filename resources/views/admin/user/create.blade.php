@extends('layouts.admin-layout')
@section('title', 'Tạo tài khoản')
@section('admin-body')
  <h2>Tạo tài khoản</h2>
  <form action="{{route('admin.users.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
    <label for="name" class="form-label">Họ và tên <span class="require">(*)</span></label>
    <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp"
      value="{{ old('name') }}">
    @error('name')
    <div class="text-danger">{{ $message }}</div>
  @enderror
    </div>
    <div class="mb-3">
    <label for="email" class="form-label">Email <span class="require">(*)</span></label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
      value="{{ old(key: 'email') }}">
    @error('email')
    <div class="text-danger">{{ $message }}</div>
  @enderror
    </div>
    <div class="mb-3">
    <label for="password" class="form-label">Mật khẩu <span class="require">(*)</span></label>
    <input type="password" class="form-control" id="password" name="password" value="{{ old(key: 'password') }}">
    @error('password')
    <div class="text-danger">{{ $message }}</div>
  @enderror
    </div>
    <div class="mb-3">
    <label for="phone" class="form-label">Số điện thoại</label>
    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
    </div>
    <div class="mb-3">
    <label for="adress" class="form-label">Địa chỉ</label>
    <input type="text" class="form-control" id="adress" name="adress" value="{{ old('adress') }}">
    </div>
    <div class="mb-3">
    <label for="avatar" class="form-label">Ảnh đại diện</label>
    <input type="file" class="form-control" id="avatar" name="avatar">
    </div>
    <div class="mb-3">
    <label for="birthday" class="form-label">Ngày sinh</label>
    <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday') }}">
    </div>
    <div class="mb-3">
    <div class="mb-1 form-check">
      <input type="radio" class="form-check-input" id="male" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }}>
      <label class="form-check-label" for="male">Nam</label>
    </div>
    <div class="form-check">
      <input type="radio" class="form-check-input" id="female" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}>
      <label class="form-check-label" for="female">Nữ</label>
    </div>
    <div class="mb-3 form-check">
      <input type="radio" class="form-check-input" id="orther" name="gender" value="orther" {{ old('gender') == 'orther' ? 'checked' : '' }}>
      <label class="form-check-label" for="orther">Khác</label>
    </div>
    </div>
    <div class="mb-3">
    <label for="position" class="form-label">Vị trí <span class="require">(*)</span></label>
    <select class="form-select" name="position_id" id="position">
      @foreach($positions as $position)
      <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
      {{ $position->name }}
      </option>
    @endforeach
    </select>
    @error('position')
    <div class="text-danger">{{ $message }}</div>
  @enderror
    </div>
    <div>
    <label class="form-label">
      Quyền đăng nhập hệ thống <span class="require">(*)</span>
    </label>
    </div>
    <div>
    <div class="mb-1 form-check">
      <input type="radio" class="form-check-input" id="admin" name="role" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }}>
      <label class="form-check-label" for="admin">Quản trị viên</label>
    </div>
    <div class="mb-3 form-check">
      <input type="radio" class="form-check-input" id="staff" name="role" value="staff" {{ old('role') == 'staff' ? 'checked' : '' }}>
      <label class="form-check-label" for="staff">Nhân viên</label>
    </div>
    @error('role')
    <div class="text-danger">{{ $message }}</div>
  @enderror
    </div>
    <button type="submit" class="btn btn-primary">Tạo tài khoản</button>
  </form>
@endsection