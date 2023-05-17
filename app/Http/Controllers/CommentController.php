<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use HttpResponses;

    public function store(StoreCommentRequest $request, $id)
    {
        $id = request()->route('id');

        if (!$id) {
            return $this->error(null, 'No post id', 400);
        }

        if (auth()->check()) {
            $user_id = Auth::user()->id;
        } else {
            return $this->error(null, 'User is not logged in', 401);
        }

        $comment = Comment::create([
            'post_id' => $id,
            'user_id' => $user_id,
            'commentText' => $request->input('commentText'),
        ]);

        return $this->success($comment, 'Comment created successfully');
    }
}
