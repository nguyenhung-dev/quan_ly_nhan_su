@extends('layouts.admin-layout')
@section('title', 'Quản lý chức vụ')
@section('admin-body')
  <div>
    <a class="btn btn-primary" href="{{route('admin.position.create')}}">Thêm chức vụ</a>
    <table class="table table-hover custom-table">
    <thead>
      <tr>
      <th>ID</th>
      <th>Tên chức vụ</th>
      <th>Mô tả</th>
      <th>Lương cơ bản</th>
      <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $item)
      <tr>
      <td>{{$item->id}}</td>
      <td>{{$item->name}}</td>
      <td>{{$item->description}}</td>
      <td>{{ number_format($item->base_salary, 0, ',', '.') }}₫</td>
      <td>
      <form action="{{route('admin.position.destroy', $item->id)}}" method="POST">
      @csrf @method('DELETE')
      <a class="btn btn-primary" href="/admin/position/{{$item->id}}/edit">Sửa</a>
      <button class="btn btn-danger" onclick="return confirm('Bạn chắc chắn xóa chức vụ này!')">Xóa</button>
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