@extends('layouts.admin-layout')
@section('title', 'Quản lý chấm công')
@section('admin-body')
  <h3>Danh sách chấm công ngày </h3>
  <br />
  <table class="table">
    <thead>
    <tr>
      <th>Nhân viên</th>
      <th>Ngày</th>
      <th>Giờ vào</th>
      <th>Giờ ra</th>
      <th>Trạng thái</th>
      <th>Hành động</th>
    </tr>
    </thead>
    <tbody>
    @foreach($attendances as $attendance)
    <tr>
      <td>{{ $attendance->user->name }}</td>
      <td>{{ $attendance->date->format('d/m/Y') }}</td>
      <td>{{ $attendance->check_in ?? '- - - - - -' }}</td>
      <td>{{ $attendance->check_out }}</td>
      <td>{{ $attendance->status }}</td>
      <td>
      <a class="btn btn-primary" href="">Xem </a>
      <a class="btn btn-success" href="">Sửa</a>
      </td>
    </tr>
  @endforeach
    </tbody>
  </table>
@endsection