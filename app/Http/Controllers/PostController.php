<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Intervention\Image\Facades\Image;
use App\Policies\PostPolicy;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->Paginate(5);
        return view('posts.index', compact('posts'));
    }
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('posts.create');
    }
    public function store()
    {
        $this->authorize('create', Post::class);
        $data = request()->validate([
            'title' => 'required',
            'contents' => 'required',
            'image' => 'image',
        ]);
        if(request('image')) {
            $imagePath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(1200, 800);
            $image->save();
        } else {
            $imagePath = null;
        }
        auth()->user()->posts()->create([
            'title' => $data['title'],
            'contents' => $data['contents'],
            'image' => $imagePath,
        ]);
        return redirect('/');
    }
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }
    public function update(Post $post)
    {
        $this->authorize('update', $post);
        $data = request()->validate([
            'title' => 'required',
            'contents' => 'required',
            'image' => '',
        ]);
        $imagePath = $post->image;
        if(request('image')) {
            \File::delete($imagePath);
            $imagePath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(1200, 800);
            $image->save();
        }
        $post->update(array_merge($data, ['image' => $imagePath]));
        return redirect("posts/{$post->id}");
    }
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $imagePath = public_path().'/storage/'.$post->image;
        \File::delete($imagePath);
        $post->delete();
        return redirect('/');
    }
}
