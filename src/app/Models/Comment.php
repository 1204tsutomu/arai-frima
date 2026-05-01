<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // 複数代入を許可する項目（これがないと保存時にエラーになります）
    protected $fillable = [
        'user_id',
        'item_id',
        'content',
    ];

    /**
     * このコメントを投稿したユーザーを取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * このコメントが投稿された商品を取得
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
