@extends('layouts.app')


@section('title', 'The List of tasks')


@section('content')


    @forelse ($tasks as $task)
        <div>
            <a href="{{ route('tasks.show', ['task' => $task->id
            ]) }}">{{ $task->title }}</a>
        </div>
    @empty
        <div>There are no Task</div>
    @endforelse
@endsection

