@extends('layouts.app')

@section('content')

    <form action="{{route('threads.update', $thread->id)}}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Editar tópico de {{$thread->user->name}}</h2>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Título</label>
                    <input class="form-control" id="title" name="title" type="text" value="{{$thread->title}}">
                </div>
                <div class="form-group">
                    <label for="body">Conteúdo</label>
                    <textarea class="form-control" id="body" name="body" rows="5">{{$thread->body}}</textarea>
                </div>
            </div>
            <div class="card-footer small">
                <button type="submit" class="btn btn-success btn-lg">Gravar</button>
                <a href="#" onclick="history.back(); return false;" class="btn btn-secondary btn-lg">Cancelar</a>
            </div>
        </div>
    </form>
    
@endsection