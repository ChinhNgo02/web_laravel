@extends('layout.master') @section('content')

<form action="{{ route('course.update', $each->id) }}" method="post">
    @csrf @method('PUT') Name
    <input type="text" name="name" value="{{ $each->name }}" />
    @if ($errors->has('name'))
    <span class="error">
        {{ $errors->first('name') }}
    </span>
    @endif
    <br />
    <button>Edit</button>
</form>
@endsection