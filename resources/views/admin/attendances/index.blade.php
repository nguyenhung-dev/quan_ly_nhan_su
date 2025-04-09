@extends('layouts.admin-layout')
@section('title', 'Danh sách chấm công')
@section('admin-body')
  <style>
    .check {
    position: relative;
    display: inline-block;
    }

    .check span {
    cursor: pointer;
    font-size: 18px;
    }

    .check-action {
    position: absolute;
    top: 25px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #f8f9fa;
    border: 1px solid #ccc;
    padding: 5px;
    border-radius: 6px;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
    display: none;
    z-index: 100;
    white-space: nowrap;
    }

    .check-action a {
    margin: 0 3px;
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {

    document.addEventListener('click', function (e) {
      document.querySelectorAll('.check-action').forEach(el => el.style.display = 'none');
    });

    document.querySelectorAll('.check span').forEach(function (span) {
      span.addEventListener('click', function (e) {
      e.stopPropagation(); // Ngăn click lan ra ngoài
      const actionBox = this.nextElementSibling;

      document.querySelectorAll('.check-action').forEach(el => el.style.display = 'none');

      actionBox.style.display = (actionBox.style.display === 'block') ? 'none' : 'block';
      });
    });
    });
  </script>


  <h3>Danh sách chấm công tháng {{ now()->format('m/Y') }}</h3>
  <br />
  <table class="table table-bordered text-center align-middle">
    <thead class="table-dark">
    <tr>
      <th>Nhân viên</th>
      @foreach ($daysInMonth as $day)
      <th>{{ $day->format('d') }}</th>
    @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
    <tr>
      <td class="text-start">{{ $user->name }}</td>
      @foreach ($daysInMonth as $day)
      @php
    $key = $user->id . '-' . $day->format('Y-m-d');
    $attendance = $attendances[$key][0] ?? null;
  @endphp
      <td>
      @if ($attendance)
      <div class="check text-center">
      @if ($attendance->status === 'present')
      <span>✅</span>
    @elseif ($attendance->status === 'absent')
      <span>❌</span>
    @else
      <span>⚠️</span>
    @endif
      <div class="check-action">
      <a href="{{ route('admin.attendances.showDetail', $attendance->id) }}"
      class="btn btn-sm btn-primary mb-1">Xem</a>
      <a href="{{ route('admin.attendances.edit', $attendance->id) }}" class="btn btn-sm btn-danger">Sửa</a>
      </div>
      </div>
    @else
      -
    @endif
      </td>
    @endforeach
    </tr>
  @endforeach
    </tbody>
  </table>

@endsection