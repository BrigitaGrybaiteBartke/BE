<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\UserPostResource;
use App\Models\Post;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPostController extends Controller
{
    use HttpResponses;

    public function index()
    {
        return  UserPostResource::collection(
            Post::where('user_id', Auth::user()->id)->with('comments')->latest()->get()
        );
    }


    public function show($id)
    {
        $post = Post::with('comments')->findOrFail($id);

        return $this->isNotAuthorized($post)
            ? $this->isNotAuthorized($post)
            : new UserPostResource($post);
    }


    public function store(StorePostRequest $request)
    {
        $request->validated($request->all());

        $post = Post::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'min_to_read' => $request->min_to_read,
            'image_path' => $request->image_path
        ]);
        return $post;
    }


    public function update(Request $request, Post $post)
    {
        if (Auth::user()->id !== $post->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }

        $post->update($request->all());
        return new UserPostResource($post);
    }


    public function destroy(Post $post)
    {
        return $this->isNotAuthorized($post)
            ? $this->isNotAuthorized($post)
            : $post->delete();
    }


    private function isNotAuthorized($post)
    {
        if (Auth::user()->id !== $post->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }
}
