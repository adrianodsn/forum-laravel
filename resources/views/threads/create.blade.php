@extends('layouts.app')

@section('content')

    <form action="{{route('threads.store')}}" method="POST">
        @csrf

        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Novo tópico</h2>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Título</label>
                    <input class="form-control" id="title" name="title" type="text" value="{{old('title')}}">
                </div>
                <div class="form-group">
                    <label for="body">Conteúdo</label>
                    <textarea class="form-control" id="body" name="body" rows="5">{{old('body')}}</textarea>
                </div>
            </div>
            <div class="card-footer small">
                <button type="submit" class="btn btn-success btn-lg">Gravar</button>
                <a href="#" onclick="history.back(); return false;" class="btn btn-secondary btn-lg">Cancelar</a>
            </div>
        </div>
    </form>
    
@endsection