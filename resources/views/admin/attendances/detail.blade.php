@extends('layouts.admin-layout')
@section('title', 'Chi tiết chấm công')
@section('admin-body')
  <h3>Chi tiết chấm công</h3>
  <br />
  <table class="table table-bordered">
    <tr>
    <th>Nhân viên</th>
    <td>{{ $attendance->user->name }}</td>
    </tr>
    <tr>
    <th>Ngày</th>
    <td>{{ $attendance->date->format('d/m/Y') }}</td>
    </tr>
    <tr>
    <th>Giờ vào</th>
    <td>{{ $attendance->check_in ?? '---' }}</td>
    </tr>
    <tr>
    <th>Giờ ra</th>
    <td>{{ $attendance->check_out ?? '---' }}</td>
    </tr>
    <tr>
    <th>Trạng thái</th>
    <td>{{ $attendance->status }}</td>
    </tr>
  </table>
  <a href="{{ route('admin.attendances.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection