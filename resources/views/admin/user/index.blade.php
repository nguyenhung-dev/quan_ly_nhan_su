@extends('layouts.admin-layout')
@section('title', 'Quản lý tài khoản')
@section('admin-body')
  <div>
    <a class="btn btn-primary" href="{{route('admin.users.create')}}">Tạo tài khoản</a>
    <table class="table table-hover custom-table">
    <thead>
      <tr>
      <th>ID</th>
      <th>Ảnh đại diện</th>
      <th>Họ và tên</th>
      <th>Giới tính</th>
      <th>Email</th>
      <th>Vị trí</th>
      <th>Quyền</th>
      <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $item)
      <tr>
      <td>{{$item->id}}</td>
      <td>
      <img src="{{ asset('storage/' . $item->avatar) }}" alt="{{$item->name}}" width="50">
      </td>
      <td>{{$item->name}}</td>
      <td>{{$item->gender}}</td>
      <td>{{$item->email}}</td>
      <td>{{$item->position->name ?? 'Chưa có chức vụ' }}</td>
      <td>{{$item->role}}</td>
      <td>
      <form action="{{route('admin.users.destroy', $item->id)}}" method="POST">
      @csrf @method('DELETE')
      <a class="btn btn-primary" href="/admin/users/{{$item->id}}/edit">Sửa</a>
      <button class="btn btn-danger" onclick="return confirm('Bạn chắc chắn xóa tài khoản này!')">Xóa</button>
      </form>
      </td>
      </tr>
    @endforeach
    </tbody>
    </table>
    <hr />
    {{$data->links()}}

  </div>
@endsection