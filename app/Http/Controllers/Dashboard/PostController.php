<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidatePostFormRequest;
use App\Http\Requests\ValidateCategoryUpdateRequest;
use Illuminate\Http\Request;

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
            $posts = Post::userPosts()->paginate(6);

        } elseif (Auth::user()->hasRole('admin')) {
            $posts = Post::paginate(6);

        } else {
            return redirect('/')
                ->with('error', 'You do not have permissions');
        }

        if($posts) {
//            $categories    = ['App\Models\Tree', 'App\Models\Grass', 'App\Models\Flower'];
            $categories    = array_keys(config('model-types.types'));

            $trees         = DB::table('trees');
            $flowers       = DB::table('flowers');
            $subcategories = DB::table('grasses')
                ->union($trees)
                ->union($flowers)
                ->get();
            return view('dashboard.posts.index', compact('posts', 'categories', 'subcategories'));
        
        } else {
            return redirect('/dashboard/posts')
                ->with('error', 'Something went wrong');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category_array    = ['App\Models\Tree', 'App\Models\Grass', 'App\Models\Flower'];

        $trees   = DB::table('trees');
        $flowers = DB::table('flowers');
        $subcategory_array = DB::table('grasses')
                    ->union($trees)
                    ->union($flowers)
                    ->get();
        
        if (Auth::user()->hasRole('user')) {
            return view('dashboard.posts.create', compact('category_array', 'subcategory_array'));
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
            'postable_id'   => $request->postable_id,
            'postable_type' => $request->postable_type,
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
        if (Auth::user()->can('view', $post)) {
            if ($post) {
                return view('dashboard.posts.show', compact('post'));
            } else {
                return back()
                    ->with('error', 'Post not found');
            }
        } else {
            return back()
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
        if (Auth::user()->can('view', $post)) {
            $category_array    = ['App\Models\Tree', 'App\Models\Grass', 'App\Models\Flower'];

            $trees   = DB::table('trees');
            $flowers = DB::table('flowers');
            $subcategory_array = DB::table('grasses')
                ->union($trees)
                ->union($flowers)
                ->get();

            return view('dashboard.posts.edit', compact('post', 'category_array', 'subcategory_array'));
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
        if (Auth::user()->can('update', $post)) {
            if ($post) {
                $post->title         =  $request->title;
                $post->description   =  $request->description;
                $post->visability    =  $request->visability;
                $post->postable_id   =  $request->postable_id;
                $post->postable_type =  $request->postable_type;
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
        if (Auth::user()->can('delete', $post) || Auth::user()->hasRole('admin')) {
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

        if (Auth::user()->can('update', $post) || Auth::user()->hasRole('admin')) {
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

    public function updateCategory(ValidateCategoryUpdateRequest $request, $id)
    {
        $post = Post::find($id);

        if (Auth::user()->can('update', $post)) {
            $model = $request->postable_type::find($request->postable_id);

            if ($model->user_id == Auth::user()->id) {
                if ($model) {
                    $post->postable()->associate($model);
                    $post->save();

                    return redirect('/dashboard/posts')
                        ->with('success', 'Post updated successfully');

                } else {
                    return redirect('/dashboard/posts')
                        ->with('error', 'There is no such subcategory in this category');
                }
            }
        } else {
            return redirect('/dashboard/posts')
            ->with('error', 'You do not have necessary permissions');
        }
    }
}
