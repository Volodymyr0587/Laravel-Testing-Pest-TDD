<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'status' => 'required'
        ]);
        auth()->user()->posts()->create($validated);

        return to_route('welcome');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }
}
