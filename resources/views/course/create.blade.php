@extends('layout.master') @section('content')

<form action="{{ route('course.store') }}" method="post">
    @csrf Name
    <input type="text" name="name" value="{{ old('name') }}" />
    @if ($errors->has('name'))
    <span class="error">
        {{ $errors->first('name') }}
    </span>
    @endif
    <br />
    <button>Thêm</button>
</form>

@endsection
