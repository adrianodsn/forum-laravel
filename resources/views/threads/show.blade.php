@extends('layouts.app')

@section('content')

    <h2 class="mb-4">{{$thread->title}}</h2>

    <div class="card mb-5">
        <div class="card-header">
            <b>{{$thread->user->name}}</b> {{$thread->created_at->diffForHumans()}}
        </div>
        <div class="card-body">
            {{$thread->body}}
        </div>
        @can('update', $thread)
            <div class="card-footer">
                <form action="{{route('threads.destroy', $thread->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <a href="{{route('threads.edit', $thread->id)}}" class="btn btn-primary btn-sm">Editar</a>
                    <button class="btn btn-danger btn-sm" type="submit">Excluir</a>
                </form>
            </div>
        @endcan

    </div>

    @if ($thread->replies->count())

        <div class="mb-5">
            <h5>Respostas</h5>

            @foreach ($thread->replies as $reply)
            
                <div class="card mb-3">
                    <div class="card-body">
                        <div>{{$reply->reply}}</div>
                        <small><b>{{$reply->user->name}}</b> {{$reply->created_at->diffForHumans()}}</small>
                    </div>
                </div>
            
            @endforeach

        </div>

    @endif

    @auth
        <div>
            <form action="{{route('replies.store')}}" method="POST">
                @csrf

                <div class="form-group">
                    <input type="hidden" name="thread_id" value="{{$thread->id}}">
                    <textarea class="form-control @error('reply') is-invalid @enderror" id="reply" name="reply" placeholder="Responder" rows="5">{{old('reply')}}</textarea>
                    @error('reply')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <button class="btn btn-success btn-sm" type="submit">Enviar</button>
            </form>
        </div>
    @else
        <div class="alert alert-warning">
            É necessário estar logado para responder a este tópico.
        </div>
    @endauth
@endsection