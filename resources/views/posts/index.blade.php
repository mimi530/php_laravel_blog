@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        @if($posts->count())
            @foreach($posts as $post)
                <div class="row mb-5 p-2">
                    <div class="col-10 offset-1 offset-md-0 col-md-12 d-md-flex p-0">
                        <div class="col-12 col-md-4 p-0 mb-3 mb-md-0">
                            <a href="{{route('posts.show', $post->id)}}"><img src="{{ $post->postImage() }}" class="w-100 rounded-left"></a>
                        </div>
                        <div class="col-12 col-md-8">
                            <a href="{{route('posts.show', $post->id)}}" class="text-dark"><h1 class="font-weight-bold">{{ $post->title }}</h1></a>
                            <p class="h5" html="true">{{ \Illuminate\Support\Str::limit($post->contents, 250, $end='... ') }}<a href="{{route('posts.show', $post->id)}}" class="text-dark font-weight-bold"><br>Zobacz cały post</a></p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row text-center"><h1>Brak postów do wyświetlenia :/</h1></div>
        @endif
        <div class="row text-dark">
            {{ $posts->links("pagination::bootstrap-4") }}
        </div>
    </div>
</div>
@endsection