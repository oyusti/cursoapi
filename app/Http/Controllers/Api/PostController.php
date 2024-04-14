<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('scopes:create-post')->only('store');
        $this->middleware('scopes:read-post')->only('index', 'show');
        $this->middleware('scopes:update-post')->only('update');
        $this->middleware('scopes:delete-post')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::included()->filter()->sort()->GetorPaginate();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:posts',
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $user = auth()->user();
        $data['user_id'] = $user->id;

        $posts = Post::create($data);
        return PostResource::make($posts);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::included()->findOrFail($id);
        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,' . $post->id,
            'extract' => 'required',
            'body' => 'required',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $post->update($request->all());
        return PostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return PostResource::make($post);
    }
}
