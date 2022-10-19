<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grass extends Model
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
