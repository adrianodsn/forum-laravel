@extends('layouts.app')

@section('content')

    <div class="list-group">

        @forelse ($threads as $thread)

            <a href="{{route('threads.show', $thread->slug)}}" class="list-group-item list-group-item-action">
                <h5>{{$thread->title}}</h5>
                <small>Por {{$thread->user->name}} | {{$thread->created_at->diffForHumans()}}</small>
            </a>
            
            @empty
            
            <div class="alert alert-warning">
                Nenhum tópico encontrado.
            </div>
            
        @endforelse

    </div>

    {{$threads->links()}}
    
@endsection