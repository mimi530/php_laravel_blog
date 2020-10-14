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
    <div class="col-md-10 text-center mt-3 mx-auto">
        <div class="col-12 mb-5">
            <a href="../storage/{{ $post->image }}"><img src="../{{ $post->postImage() }}" class="w-100"></a>
        </div>
        <div class="col-12">
            <h1 class="mb-3">{{$post->title}}</h1>
            <p class="h4">{{$post->contents}}</p>
        </div>
    </div>
    <div class="row mx-auto p-4 mt-5" style="background-color: #ddd;">
        <h2>{{$post->comments->count()}} Komentarzy</h2>
        <div class="row mx-auto w-100">
        @guest
            <h4 class="mx-auto"><a href="{{ route('login') }}">Zaloguj się</a> aby dodać komentarz!</h4>
        @else
            <form action="{{ route('comments.store', $post->id) }}" method="post">
                @csrf
                <textarea class="w-100 form-control mt-2" style="resize: none;" rows="2" cols="150" placeholder="Dodaj komentarz..." name="comment"></textarea>
                <input type="submit" value="Dodaj" class="ml-auto d-block btn-primary btn mt-1">
            </form>
        @endguest
        </div>
        @foreach($post->comments as $comment)
        <div class="d-flex flex-row w-100 mt-3 p-3">
            <div class="p-0">
                <img src="https://www.gravatar.com/avatar/{{ md5($comment->email) }}.jpg?s=64" class="d-block ml-auto">
            </div>
            <div class="pl-2">
                @if($comment->adminComment())
                    <h5 class="font-weight-bold text-danger">{{ $comment->name }}</h5>
                @else
                    <h5 class="font-weight-bold">{{ $comment->name }}</h5>
                @endif
                <p class="h5">
                {{ $comment->comment }}
                </p>
            </div>
        </div>
        @endforeach
        <!-- Odpowiedzi
        <div class="col-10 offset-1 d-flex">
            <div class="p-0">
                <img src="https://www.gravatar.com/avatar/{{ md5('mimi0192@wp.pl') }}.jpg?s=64" class="d-block ml-auto">
            </div>
            <div class="pl-2">
                <p class="h5">
                    Tu jest super fajny komentarz na temat tego postu bo ten post tez jest super duper fajny omg łapka w dupe.
                </p>
            </div>
        </div> -->
    </div>
    
</div>
@endsection