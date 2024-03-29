<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function posts()
    {
        return $this->morphMany(Post::class, 'postable');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
