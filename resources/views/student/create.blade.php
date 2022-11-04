@extends('layout.master') @section('content')

<form action="{{ route('students.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group" width="50%">
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="" />
    </div>
    <br />
    Gender
    <input type="radio" name="gender" value="0" checked />Nam
    <input type="radio" name="gender" value="1" />Nữ
    <br />
    BirthDate
    <input type="date" name="birthdate" />
    <br />
    Status @foreach($arrStudentStatus as $option => $value)
    <input type="radio" name="status" value="{{ $value }}" @if ($loop ->first)
    checked @endif
    />
    {{ $option }}
    <br />
    @endforeach
    <br />
    Avatar
    <input type="file" name="avatar">
    <br>
    Course
    <select name="course_id">
        @foreach($courses as $course)
        <option value="{{ $course->id }}">
            {{$course->name}}
        </option>
        @endforeach
    </select>
    <br>
    <button>Thêm</button>
</form>

@endsection