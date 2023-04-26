<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Traits\HttpResponses;

use function PHPUnit\Framework\returnSelf;

class PostController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return  PostResource::collection(
            Post::with('comments')->latest()->get()
        );
    }

    public function show($id)
    {
        $post = Post::with('comments')->findOrFail($id);
        return new PostResource($post);
    }

    // search post by title
    public function search($title)
    {
        return Post::where('title', 'like', '%' . $title . '%')->with('comments')->get();
    }
}
