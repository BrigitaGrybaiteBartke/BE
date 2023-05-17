<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\UserPostResource;
use App\Models\Post;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserPostController extends Controller
{
    use HttpResponses;

    public function index()
    {
        if (auth()->check()) {
            return  UserPostResource::collection(
                Post::where('user_id', Auth::user()->id)
                    ->with('comments')
                    ->latest()
                    ->get()
            );
        }
    }

    public function show($id)
    {
        $post = Post::with('comments')->findOrFail($id);
        return $this->isNotAuthorized($post)
            ? $this->isNotAuthorized($post)
            : new UserPostResource($post);
    }

    public function store(StorePostRequest $request, Post $post)
    {
        $request->validated($request->all());

        try {
            $imageName = Str::random() . '.' . $request->image_path->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $request->image_path, $imageName);

            $post = Post::create([
                'user_id' => Auth::user()->id,
                'title' => $request->title,
                'excerpt' => $request->excerpt,
                'body' => $request->body,
                'min_to_read' => $request->min_to_read,
                'image_path' => $imageName
            ]);

            return $this->success(new UserPostResource($post), 'Post created successfully');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->error([], 'Something went wrong while creating the post', 500);
        }
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $request->validated($request->all());

        try {
            $post->fill($request->post())->update();

            if ($request->hasFile('image_path')) {
                if ($post->image_path) {
                    $exists = Storage::disk('public')->exists("images/{$post->image_path}");
                    if ($exists) {
                        Storage::disk('public')->delete("images/{$post->image_path}");
                    }
                }

                $imageName = Str::random() . '.' . $request->image_path->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('images', $request->image_path, $imageName);
                $post->image_path = $imageName;
            }

            $post->save();

            return $this->success(new UserPostResource($post), 'Post updated successfully', 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->error([], 'Something went wrong while updating the post', 500);
        }
    }

    public function destroy(Post $post)
    {
        $response = $this->isNotAuthorized($post);

        try {
            if ($response) {
                return $response;
            }
            $post->delete();
            return $this->success(null, 'Post deleted successfully', 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $this->error('', 'Something went wrong while deleting the post', 500);
        }
    }

    private function isNotAuthorized($post)
    {
        if (Auth::user()->id !== $post->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }
}
