<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Http\Controllers\PostController;
use App\Policies\CommentPolicy;

class CommentController extends Controller
{
    public function store(Post $post)
    {
        $this->middleware('auth');
        $data = request()->validate([
            'comment' => 'required',
        ]);
        $post->comments()->create([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'user_id' => auth()->user()->id,
            'reply_id' => null,
            'comment' => $data['comment'],
        ]);
        return redirect("/posts/{$post->id}");
    }
    public function reply(Comment $comment)
    {
        $this->middleware('auth');
        $data = request()->validate([
            'comment' => 'required',
        ]);
        $post = $comment->post;
        $post->comments()->create([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'user_id' => auth()->user()->id,
            'reply_id' => $comment->id,
            'comment' => $data['comment'],
        ]);
        return redirect("/posts/{$post->id}");
    }
    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        $post = $comment->post;
        return view('posts.show', ['post' => $post, 'comment'=>$comment]);
    }
    public function update(Comment $comment)
    {
        $this->authorize('update', $comment);
        $data = request()->validate([
            'comment' => 'required',
        ]);
        $comment->update($data);
        $post = $comment->post;
        // return view('posts.show', compact('post'));
        return redirect("posts/{$post->id}");
    }
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $post = $comment->post;
        $comment->delete();
        return redirect("/posts/{$post->id}");
    }
}
