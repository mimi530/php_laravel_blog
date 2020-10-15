@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dodaj nowy post!</h1>
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <div class="col-md-6">
            <label for="title">Tytuł</label>
                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" autocomplete="title" autofocus>
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
                <textarea id="contents" class="form-control @error('contents') is-invalid @enderror" name="contents" style="resize: none;" rows="10" cols="50" autocomplete="contents">{{ old('contents') }}</textarea>
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
                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <button type="submit" class="btn btn-primary ml-3">
                Dodaj!
            </button>
        </div>
    </form>
</div>
@endsection