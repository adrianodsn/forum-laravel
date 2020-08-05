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
                    <label for="channel_id">Canal</label>
                    <select class="form-control @error('channel_id') is-invalid @enderror" id="channel_id" name="channel_id">
                        <option value=""></option>
                        @foreach ($channels as $channel)
                            <option value="{{$channel->id}}" @if (old('channel_id') == $channel->id) selected @endif>{{$channel->name}}</option>                            
                        @endforeach
                    </select>
                    @error('channel_id')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="title">Título</label>
                    <input class="form-control @error('title') is-invalid @enderror" id="title" name="title" type="text" value="{{old('title')}}">
                    @error('title')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="body">Conteúdo</label>
                    <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="5">{{old('body')}}</textarea>
                    @error('body')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="card-footer small">
                <button type="submit" class="btn btn-success btn-lg">Gravar</button>
                <a href="#" onclick="history.back(); return false;" class="btn btn-secondary btn-lg">Cancelar</a>
            </div>
        </div>
    </form>
    
@endsection