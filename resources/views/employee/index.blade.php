@extends('layouts.staff-layout')
@section('title', 'Chắm công')
@section('username', $user->name)
@section('avatar', $user->avatar)

@section('staff-body')
  <h2>Chắm công tuần này</h2>
  <br />
  <table class="table" border="1" cellpadding="10">
    <thead>
    <tr>
      <th>Thứ</th>
      <th>Ngày</th>
      <th>Trạng thái</th>
      <th>Giờ vào</th>
      <th>Giờ ra</th>
      <th>Hành động</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($weekDates as $day)
    <tr>
      <td>{{ $day['date']->locale('vi')->format('l')}}</td>
      <td>{{ $day['date']->format('d/m/Y') }}</td>
      <td>
      @if ($day['attendance'])
      {{ $day['attendance']->status }}
    @else
      Chưa check-in
    @endif
      </td>
      <td>
      @if ($day['attendance'] && $day['attendance']->check_in)
      {{ $day['attendance']->check_in }}
    @else
      --
    @endif
      </td>
      <td>
      @if ($day['attendance'] && $day['attendance']->check_out)
      {{ $day['attendance']->check_out }}
    @else
      --
    @endif
      </td>
      <td class="btn-attendance">
      @if ($day['is_today'])
      @if (!$day['attendance'])
      <form action="{{ route('employee.attendances.checkin') }}" method="POST">
      @csrf
      <button class="btn btn-info" type="submit">Check-in</button>
      <button class="btn btn-danger" formaction="{{ route('employee.attendances.absent') }}"
      type="submit">Absent</button>
      </form>
    @elseif ($day['attendance'] && $day['attendance']->check_in && !$day['attendance']->check_out)
      Đã check-in
      <form action="{{ route('employee.attendances.checkout') }}" method="POST">
      @csrf
      <button class="btn btn-warning" type="submit">Check-out</button>
      </form>
    @elseif ($day['attendance'] && $day['attendance']->check_in && $day['attendance']->check_out)
      Đã chấm hôm nay
    @else
      --
    @endif
    @else
      --
    @endif
      </td>
    </tr>
  @endforeach
    </tbody>
  </table>
@endsection