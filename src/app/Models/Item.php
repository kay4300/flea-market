<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Item extends Model
{
    use HasFactory;

    public function user()
    {
        // DBのuser_idを参照
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        // DBのitem_idを参照
        return $this->hasMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item', 'item_id', 'category_id');
    }

    public function likedUsers()
    {
        return $this->belongsToMany(
            User::class,
            'likes',
            'item_id',
            'user_id'
        )->withTimestamps();
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    
}


    
