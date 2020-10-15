@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        @can('update', $post)
            <a href="{{route('posts.edit', $post->id)}}" class="mr-3 h5 btn btn-primary">Edytuj post</a>
        @endcan
        @can('delete', $post)
            <form action="{{route('posts.destroy', $post->id)}}" method="post" onsubmit="return confirm('Czy na pewno chcesz usunąć post?');">
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
        <h2>{{$post->countComments()}} Komentarzy</h2>
        <div class="row mx-auto w-100">
            @guest
                <h4 class="mx-auto"><a href="{{ route('login') }}">Zaloguj się</a> aby dodawać komentarze!</h4>
            @else
                <form action="{{ route('comments.store', $post->id) }}" method="post">
                    @csrf
                    <textarea class="w-100 form-control mt-2" style="resize: none;" rows="2" cols="150" placeholder="Dodaj komentarz..." name="comment" required>{{$comment->comment ?? ''}}</textarea>
                    @error('comment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <input type="submit" value="Dodaj" class="ml-auto d-block btn-primary btn mt-1">
                </form>
            @endguest
        </div>
        @foreach($post->comments as $comment)
            <!-- Comments -->
            <div class="d-flex flex-row w-100 mt-3 p-3">
                <div class="p-0">
                    <img src="https://www.gravatar.com/avatar/{{ md5($comment->email) }}.jpg?s=64" class="d-block ml-auto">
                </div>
                <div class="pl-2 w-100">
                    <div class="d-flex flex-row">
                        <h5 class="font-weight-bold {{$comment->adminComment() ? 'text-danger' : ''}}">{{ $comment->name }}</h5>
                        <p class="m-0 ml-auto">{{ $comment->created_at }}</p>
                    </div>
                    <p class="h5">
                        {{ $comment->comment }}
                    </p>
                    <div class="d-flex flex-row">
                        <button class="font-weight-bold btn p-0 mr-1 {{ (!Auth::check()) ? 'disabled' : ''}}" onclick="reply({{$comment->id}})">Odpowiedz</button>
                        <form></form>
                        @can('update', $comment)
                            <a href="{{route('comments.edit', $comment->id)}}" class="mx-1 btn text-primary p-0">Edytuj</a>
                        @endcan
                        @can('delete', $comment)
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="post" onsubmit="return confirm('Czy na pewno chcesz usunąć post?');">
                            @method('delete')
                            @csrf
                            <button class="text-danger btn p-0 mx-1">Usuń</button>
                        </form>
                        @endcan
                    </div>
                    <div class="row p-3 w-100">
                        <form action="{{ route('comments.reply', $comment->id) }}" method="post" style="display:none;" id="replyform{{$comment->id}}">
                            @csrf
                            <textarea class="w-100 form-control mt-2" style="resize: none;" rows="2" cols="150" placeholder="Odpowiedz na komentarz..." name="comment" required id="text{{$comment->id}}"></textarea>
                            @error('comment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="submit" value="Dodaj" class="ml-auto d-block btn-primary btn mt-1">
                        </form>
                    </div>
                </div>
            </div>
            <!-- Replies -->
            @foreach($comment->replies as $reply)
                <div class="d-flex flex-row p-3 ml-5 w-100">
                    <div class="p-0">
                        <img src="https://www.gravatar.com/avatar/{{ md5($reply->email) }}.jpg?s=64" class="d-block ml-auto">
                    </div>
                    <div class="pl-2 w-100">
                        <div class="d-flex flex-row">
                            <h5 class="font-weight-bold {{$reply->adminComment() ? 'text-danger' : ''}}">{{ $reply->name }}</h5>
                            <p class="m-0 ml-auto">{{ $reply->created_at }}</p>
                        </div>
                        <p class="h5">
                            {{ $reply->comment }}
                        </p>
                        <div class="d-flex flex-row">
                            <button class="font-weight-bold btn p-0 mr-1 {{ (!Auth::check()) ? 'disabled' : ''}}" onclick="reply({{$reply->id}})">Odpowiedz</button>
                            @can('update', $reply)
                                <a href="{{route('comments.edit', $reply->id)}}" class="mx-1">Edytuj</a>
                            @endcan
                            @can('delete', $reply)
                            <form action="{{ route('comments.destroy', $reply->id) }}" method="post" onsubmit="return confirm('Czy na pewno chcesz usunąć post?');">
                                @method('delete')
                                @csrf
                                <button class="text-danger p-0 mx-1" type="submit" id="com_del_button">Usuń</button>
                            </form>
                            @endcan
                        </div>
                        <div class="row p-3 w-100">
                            <form action="{{ route('comments.reply', $reply->reply_id) }}" method="post" style="display:none;" id="replyform{{$reply->id}}">
                                @csrf
                                <textarea class="w-100 form-control mt-2" style="resize: none;" rows="2" cols="150" placeholder="Odpowiedz na komentarz..." name="comment" required id="text{{$reply->id}}"></textarea>
                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <input type="submit" value="Dodaj" class="ml-auto d-block btn-primary btn mt-1">
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>
<script type="text/javascript">
    function reply(id) {
        var x = document.getElementById("replyform"+id);
        if (x.style.display === "none") {
            x.style.display = "block";
            document.getElementById("text"+id).focus();
        } else {
            x.style.display = "none";
        }
    }
</script>
@endsection