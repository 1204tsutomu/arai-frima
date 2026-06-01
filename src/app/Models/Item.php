<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;

class Item extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'price',
        'brand',
        'description',
        'image_file',
        'condition_id',
        'user_id',
    ];


    public function categories()
    {

        return $this->belongsToMany(Category::class, 'item_category');
    }


    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
