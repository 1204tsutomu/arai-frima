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

    /**
     * 複数代入可能な属性
     */
    protected $fillable = [
        'name',
        'price',
        'brand',
        'description',
        ' image_file',      // image_file から img_url に修正
        'condition_id',
        'user_id',
    ];

    /**
     * カテゴリーとの多対多リレーション
     */
    public function categories()
    {
        // コントローラー側の attach と合わせるため、
        // テーブル名を 'category_item' に統一します
        return $this->belongsToMany(Category::class, 'item_category');
    }

    /**
     * 商品の状態とのリレーション
     */
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    /**
     * 出品者(User)とのリレーション
     */
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
