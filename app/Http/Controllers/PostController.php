<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
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
}
