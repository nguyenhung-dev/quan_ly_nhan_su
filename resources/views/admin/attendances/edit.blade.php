@extends('layouts.admin-layout')
@section('title', 'Chỉnh sửa chấm công')
@section('admin-body')
  <h3>Chỉnh sửa chấm công</h3>
  <br />
  <form action="{{ route('admin.attendances.update', $attendance->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
    <label>Nhân viên:</label>
    <input type="text" class="form-control" value="{{ $attendance->user->name }}" disabled>
    </div>

    <div class="form-group">
    <label>Ngày:</label>
    <input type="text" class="form-control" value="{{ $attendance->date->format('d/m/Y') }}" disabled>
    </div>

    <div class="form-group">
    <label>Giờ vào:</label>
    <input type="time" name="check_in" class="form-control" value="{{ $attendance->check_in }}">
    </div>

    <div class="form-group">
    <label>Giờ ra:</label>
    <input type="time" name="check_out" class="form-control" value="{{ $attendance->check_out }}">
    </div>

    <div class="form-group">
    <label>Trạng thái:</label>
    <select name="status" class="form-control">
      <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Có mặt</option>
      <option value="late" {{ $attendance->status == 'late' ? 'selected' : '' }}>Đi trễ</option>
      <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Vắng</option>
    </select>
    </div>

    <button type="submit" class="btn btn-success">Lưu thay đổi</button>
    <a href="{{ route('admin.attendances.index') }}" class="btn btn-secondary">Hủy</a>
  </form>
@endsection