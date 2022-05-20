<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidatePostFormRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->hasRole('user')) {
            $posts = Post::userPosts()->get();

        } elseif (Auth::user()->hasRole('admin')) {
            $posts = Post::all();

        } else {
            return redirect('/')
                ->with('error', 'You do not have permissions');
        }

        return view('dashboard.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->hasRole('user')) {
            return view('dashboard.posts.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidatePostFormRequest $request)
    {
        $post = Post::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'visability'    => $request->visability,
            'user_id'       => Auth::user()->id
        ]);

        if($post) {
            return redirect('/dashboard/posts')
                ->with('success', 'New post added successfully');

        } else {
            return redirect('/dashboard/posts')
                ->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if (Auth::user()->id == $post->user_id) {
            if ($post) {
                return view('dashboard.posts.show', compact('post'));
            } else {
                return redirect('/dashboard/posts')
                    ->with('error', 'Post not found');
            }
        } else {
            return redirect('/dashboard/posts')
                ->with('error', 'You do not have necessary permissions');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (Auth::user()->id == $post->user_id) {
            return view('dashboard.posts.edit', compact('post'));
        } else {
            return redirect('/dashboard/posts')
            ->with('error', 'You do not have necessary permissions');
        }    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidatePostFormRequest $request, Post $post)
    {
        if (Auth::user()->id == $post->user_id) {
            if ($post) {
                $post->title         =  $request->title;
                $post->description   =  $request->description;
                $post->visability    =  $request->visability;
                $post->save();

                if ($post) {
                    return redirect('dashboard/posts')
                        ->with('success', 'Post updated successfully');

                } else {
                    return redirect('/dashboard/posts')
                        ->with('error', 'Something went wrong');
                }

            } else {
                return redirect('/dashboard/posts')
                    ->with('error', 'Post not found');
            }
        } else {
            return redirect('/dashboard/posts')
            ->with('error', 'You do not have necessary permissions');
        }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Auth::user()->id == $post->user_id || Auth::user()->hasRole('admin')) {
            if ($post) {
                $post->delete();

                return redirect('dashboard/posts')
                    ->with('success', 'Post deleted successfully');

            } else {
                return redirect('/dashboard/posts')
                    ->with('error', 'Something went wrong');
            } 
        } else {
            return redirect('/dashboard/posts')
            ->with('error', 'You do not have necessary permissions');
        }  
    }

    public function updateVisability(Request $request, Post $post)
    {
        $post     = Post::where('id', $request->id)->first();
        $user     = User::where('id', $post->user_id)->first();

        if (Auth::user()->id == $user->id || Auth::user()->hasRole('admin')) {
            if ($request->mode == 'true') {
                DB::table('posts')->where('id', $request->id)
                    ->update([
                        'visability' => '1'
                    ]);
            }
            else {
                DB::table('posts')->where('id', $request->id)
                    ->update(['visability' => '0']);
            }

            return response()->json([
                'message'  => 'Post visability was successfully updated',
                'status'   => 200
            ]);
        } else {
            return redirect('/dashboard/posts')
            ->with('error', 'You do not have necessary permissions');
        }  
    }
}
