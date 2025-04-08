@extends('layouts.admin-layout')
@section('title', 'Sửa chức vụ')

@section('admin-body')
  <div class="container">
    <h2 class="mb-4">Sửa chức vụ</h2>
  </div>

  <form action="{{ route('admin.position.update', $position->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
    <label for="name" class="form-label">Tên chức vụ <span class="require">(*)</span></label>
    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $position->name) }}">
    @error('name')
    <div class="text-danger">{{ $message }}</div>
  @enderror
    </div>

    <div class="mb-3">
    <label for="description" class="form-label">Mô tả</label>
    <textarea name="description" class="form-control"
      id="description">{{ old('description', $position->description) }}</textarea>
    </div>

    <div class="mb-3">
    <label for="base_salary" class="form-label">Lương cơ bản <span class="require">(*)</span></label>
    <input type="number" step="0.01" name="base_salary" class="form-control" id="base_salary"
      value="{{ old('base_salary', $position->base_salary) }}">
    @error('base_salary')
    <div class="text-danger">{{ $message }}</div>
  @enderror
    </div>

    <button type="submit" class="btn btn-primary">Sửa chức vụ</button>
  </form>
  </div>
@endsection