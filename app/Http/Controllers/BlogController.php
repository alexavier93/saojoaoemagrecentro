<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{

    public function index()
    {

        $posts = Post::orderBy('id', 'desc')->paginate(10);

        return view('blog.index', compact('posts'));
    }


    public function posts($post)
    {
        $post = Post::where('slug', $post)->firstOrFail();

        $posts = Post::orderBy('id', 'desc')->limit(10)->get();

        return view('blog.post',  compact('post', 'posts'));
    }


}
