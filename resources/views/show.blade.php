@extends('layouts.app')

@section('title', $task->title)


@section('content')
<p>{{ $task->description }}</p>

@if($task->long_description)
    <p>{{ $task->long_description }}</p>
@endif

<p>{{ $task->created_at }}</p>
<p>{{ $task->updated_at }}</p>

<div>
    <form action="{{ route('task.destory', ['task' => $task->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
</div>


@endsection