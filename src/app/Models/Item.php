<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Like;

class Item extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     */
    protected $fillable = [
        'name',
        'price',
        'brand',        // 追加：要件にあるブランド名用
        'description',
        'image_file',   // マイグレーションのカラム名に合わせて調整
        'condition_id',
        'user_id',
    ];


    public function categories()
    {
        // 第二引数に中間テーブル名 'item_category' を指定します
        return $this->belongsToMany(Category::class, 'item_category');
    }

    /**
     * 商品の状態とのリレーション（1対多）
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
        return $this->hasMany(Like::class); // Likeモデルがある場合
    }
}
