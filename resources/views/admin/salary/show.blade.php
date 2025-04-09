@extends('layouts.admin-layout')
@section('title', 'Chi tiết lương')

@section('admin-body')
  <style>
    .list-group li {
    background-color: #0f1422;
    color: #b8bfd9;
    }
  </style>
  <h2 class="mb-3">Chi tiết lương: {{ $salary->user->name }}</h2>
  <ul class="list-group">
    <li class="list-group-item"><strong>Tháng/Năm:</strong> {{ $salary->month }}/{{ $salary->year }}</li>
    <li class="list-group-item"><strong>Chức vụ:</strong> {{ $salary->user->position->name }}</li>
    <li class="list-group-item"><strong>Lương cơ bản:</strong> {{ number_format($salary->user->position->base_salary) }}đ
    </li>
    <li class="list-group-item"><strong>Số ngày làm:</strong> {{ $salary->total_working_days }}</li>
    <li class="list-group-item"><strong>Số ngày vắng/trễ:</strong> {{ $salary->late_or_absent_days }}</li>
    <li class="list-group-item"><strong>Thưởng:</strong> +{{ number_format($salary->bonus) }}đ</li>
    <li class="list-group-item"><strong>Phạt:</strong> -{{ number_format($salary->penalty) }}đ</li>
    <li class="list-group-item"><strong>Lương thực nhận:</strong> {{ number_format($salary->final_salary) }}đ</li>
    <li class="list-group-item"><strong>Trạng thái:</strong> {{ ucfirst($salary->status) }}</li>
  </ul>
  <a href="{{ route('admin.salary.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
@endsection