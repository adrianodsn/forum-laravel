@extends('layouts.app')

@section('content')

    <h2 class="mb-4">Tópicos</h2>

    <div class="list-group mb-4">

        @forelse ($threads as $thread)

            <a href="{{route('threads.show', $thread->slug)}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge badge-secondary badge-pill">
                        {{$thread->channel->name}}
                    </span>
                    <h5 class="mt-2">{{$thread->title}}</h5>
                    <small><b>{{$thread->user->name}}</b> {{$thread->created_at->diffForHumans()}}</small>
                </div>  
                <span class="badge badge-success badge-pill">
                    {{$thread->replies()->count()}}
                </span>
            </a>
            
            @empty
            
            <div class="alert alert-warning">
                Nenhum tópico encontrado.
            </div>
            
        @endforelse

    </div>

    {{$threads->links()}}
    
@endsection