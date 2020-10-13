@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edycja postu</h1>
    <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group row">
            <div class="col-md-6">
            <label for="title">Tytuł</label>
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $post->title }}" required autofocus>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
            <label for="contents">Treść</label>
                <textarea id="contents" class="form-control @error('contents') is-invalid @enderror" name="contents" required style="resize: none;" rows="10" cols="50">{{ old('contents') ?? $post->contents }}</textarea>
                @error('contents')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
            <label for="contents">Zdjęcie</label>
                <input type="file" id="contents" class="form-control @error('contents') is-invalid @enderror" name="image">
                @error('contents')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <button type="submit" class="btn btn-primary ml-3">
                Edytuj!
            </button>
        </div>
    </form>
</div>
@endsection