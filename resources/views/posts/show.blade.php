@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
    @can('update', $post)
        <a href="{{route('posts.edit', $post->id)}}" class="mr-3 h5 btn btn-primary">Edytuj post</a>
    @endcan
    @can('delete', $post)
        <form action="{{route('posts.delete', $post->id)}}" method="post" onsubmit="return confirm('Czy na pewno chcesz usunąć post?');">
            @method('delete')
            @csrf
            <input type="submit" class="mr-3 h5 btn btn-danger" value="Usuń post" />
        </form>
    @endcan
    </div>
    <div class="col-md-8 offset-2 text-center mt-3">
        <div class="row mb-5">
            <a href="../storage/{{ $post->image }}"><img src="../storage/{{ $post->image }}" class="w-100"></a>
        </div>
        <div class="col-12">
            <h1 class="mb-3">{{$post->title}}</h1>
            <p class="h5">{{$post->contents}}</p>
        </div>
    </div>
    
</div>
@endsection