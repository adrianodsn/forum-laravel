@extends('layouts.app')

@section('content')

    <h2>{{$thread->title}}</h2>

    <div class="card">
        <div class="card-header">
            Por {{$thread->user->name}} há {{$thread->created_at->diffForHumans()}}
        </div>
        <div class="card-body">
            {{$thread->body}}
        </div>
        <div class="card-footer">
            <form action="{{route('threads.destroy', $thread->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <a href="{{route('threads.edit', $thread->id)}}" class="btn btn-primary btn-sm">Editar</a>
                <button class="btn btn-danger btn-sm" type="submit">Excluir</a>
            </form>
        </div>
    </div>
    
@endsection