@extends('layouts.admin-layout')

@section('title', 'Danh sách khen thưởng - kỷ luật')

@section('admin-body')
  <h2 class="mb-4">Danh sách khen thưởng - kỷ luật</h2>

  <table class="table table-bordered">
    <thead>
    <tr>
      <th>STT</th>
      <th>Nhân viên</th>
      <th>Chức vụ</th>
      <th>Loại</th>
      <th>Lý do</th>
      <th>Số tiền</th>
      <th>Ngày áp dụng</th>
    </tr>
    </thead>
    <tbody>
    @forelse($records as $index => $record)
    <tr>
      <td>{{ $index + 1 }}</td>
      <td>{{ $record->user->name }}</td>
      <td>{{ $record->user->position->name ?? 'N/A' }}</td>
      <td>
      @if ($record->type === 'reward')
      <span class="badge bg-success">Khen thưởng</span>
    @else
      <span class="badge bg-danger">Kỷ luật</span>
    @endif
      </td>
      <td>{{ $record->reason }}</td>
      <td>{{ number_format($record->amount, 0, ',', '.') }} VNĐ</td>
      <td>{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}</td>
    </tr>
  @empty
  <tr>
    <td colspan="7" class="text-center">Không có dữ liệu</td>
  </tr>
@endforelse
    </tbody>
  </table>
@endsection