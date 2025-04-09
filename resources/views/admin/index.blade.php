@extends('layouts.admin-layout')
@section('title', 'Thống kê')
@section('admin-body')
  <h2 class="mb-4">Thống kê lương - thưởng - phạt tháng {{ $month }}/{{ $year }}</h2>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
    <tr>
      <th>STT</th>
      <th>Họ tên</th>
      <th>Chức vụ</th>
      <th>Lương cơ bản</th>
      <th>Lương thực nhận</th>
      <th>Tổng thưởng</th>
      <th>Tổng phạt</th>
      <th>Trạng thái lương</th>
    </tr>
    </thead>
    <tbody>
    @forelse($users as $index => $user)
    @php
    $salary = $user->salary?->first();
    $rewards = $user->rewards->where('type', 'reward')->sum('amount');
    $penalties = $user->rewards->where('type', 'penalty')->sum('amount');
  @endphp
    <tr>
      <td>{{ $index + 1 }}</td>
      <td>{{ $user->name }}</td>
      <td>{{ $user->position->name ?? 'N/A' }}</td>
      <td>{{ number_format($user->position->base_salary ?? 0) }}đ</td>
      <td>{{ number_format(($salary->final_salary ?? 0) + $rewards - $penalties) }}đ</td>
      <td class="text-success">{{ number_format($rewards) }}đ</td>
      <td class="text-danger">{{ number_format($penalties) }}đ</td>
      <td>
      @if($salary?->status === 'hoàn tất')
      <span class="badge bg-success">Hoàn tất</span>
    @else
      <span class="badge bg-warning text-dark">Đang tính</span>
    @endif
      </td>
    </tr>
  @empty
  <tr>
    <td colspan="8" class="text-center">Không có dữ liệu</td>
  </tr>
@endforelse
    </tbody>
  </table>

@endsection