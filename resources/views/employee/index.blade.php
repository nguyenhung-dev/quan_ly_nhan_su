@extends('layouts.staff-layout')
@section('title', 'Chấm công')
@section('username', $user->name)
@section('avatar', $user->avatar)

@section('staff-body')
  <h2>Chấm công tuần này</h2>
  <br />
  <table class="table" border="1" cellpadding="10">
    <thead>
    <tr>
      <th>Thứ</th>
      <th>Ngày</th>
      <th>Trạng thái</th>
      <th>Giờ vào</th>
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
      Chưa chấm
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
      @if ($day['is_today'] && !$day['attendance'])
      <form action="{{route('employee.attendances.store')}}" method="POST">
      @csrf
      <button class="btn btn-info" type="submit">Chấm công</button>
      </form>
    @elseif ($day['is_today'])
      Đã chấm hôm nay
    @else
      --
    @endif
      </td>
    </tr>
  @endforeach
    </tbody>
  </table>
@endsection