<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['commentText', 'post_id'];
    protected $hidden = ['created_at', 'updated_at'];


    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
