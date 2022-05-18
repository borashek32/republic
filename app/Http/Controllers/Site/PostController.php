<?php

namespace App\Http\Controllers\Site;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            $posts = Post::all();

        } else {
            $posts = Post::where('visability', '1')->get();
        }

        return view('welcome', compact('posts'));
    }

    public function onePost($id)
    {
        $post = Post::find($id);

        return view('post', compact('post'));
    }
}
