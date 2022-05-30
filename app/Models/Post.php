<?php

namespace App\Models;

use App\Models\Tree;
use App\Models\Flower;
use App\Models\Grass;
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
        'visability',
        'postable_type',
        'postable_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAllUsersPosts($query)
    {
        $posts = $query->where('user_id', Auth::user()->id);

        return $posts;
    }

    public function scopeUserPosts($query)
    {
        $posts = $query->where('user_id', Auth::user()->id);

        return $posts;
    }

    /**
     * Get the parent postable model Tree, Grass, Flower.
     */
    public function postable()
    {
        return $this->morphTo();
    }
}
