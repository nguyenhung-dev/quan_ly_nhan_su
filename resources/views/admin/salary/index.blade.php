@extends('layouts.admin-layout')
@section('title', 'Danh sách lương nhân viên')

@section('admin-body')
  <style>
    .table a {
    color: black !important;
    }
  </style>
  <h3 class="mb-4">Lương tháng {{ $month }}/{{ $year }}</h3>

  <table class="table table-bordered text-center">
    <thead class="table-dark">
    <tr>
      <th>Nhân viên</th>
      <th>Chức vụ</th>
      <th>Lương cơ bản</th>
      <th>Số ngày làm</th>
      <th>Số ngày vắng/trễ</th>
      <th>Thưởng</th>
      <th>Phạt</th>
      <th>Lương thực nhận</th>
      <th>Trạng thái</th>
      <th>Chi tiết</th>
    </tr>
    </thead>
    <tbody>
    @foreach($salaries as $salary)
    <tr>
      <td>{{ $salary->user->name }}</td>
      <td>{{ $salary->user->position->name }}</td>
      <td>{{ number_format($salary->user->position->base_salary) }}đ</td>
      <td>{{ $salary->working_display }}</td>
      <td>{{ $salary->late_or_absent_days }}</td>
      <td class="text-success">+{{ number_format($salary->bonus) }}đ</td>
      <td class="text-danger">-{{ number_format($salary->penalty) }}đ</td>
      <td><strong>{{ number_format($salary->final_salary) }}đ</strong></td>
      <td>{{ ucfirst($salary->status) }}</td>
      <td><a href="{{ route('admin.salary.show', $salary->id) }}" class="btn btn-sm btn-info">Xem</a></td>
    </tr>
  @endforeach
    </tbody>
  </table>
@endsection