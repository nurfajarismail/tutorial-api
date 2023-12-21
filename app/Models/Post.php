<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'news_content', 'author', 'created_at', 'updated_at', 'deleted_at', 'image',
    ];

    public function writer()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    public function comments()
    {

        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}
