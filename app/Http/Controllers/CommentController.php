<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Http\Controllers\PostController;
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
            'comment' => $data['comment'],
        ]);
        return redirect("/posts/{$post->id}");
    }
    public function edit()
    {
        //
    }
    public function update()
    {
        //
    }
    public function destroy()
    {
        //
    }
}
