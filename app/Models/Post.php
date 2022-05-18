<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'visability'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUserPosts($query)
    {
        $posts = $query->where('user_id', Auth::user()->id);

        return $posts;
    }
}
