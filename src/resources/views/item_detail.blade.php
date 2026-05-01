@extends('layouts.app')

@section('content')
<style>
    .detail-wrapper {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .detail-container {
        display: flex;
        gap: 60px;
        align-items: flex-start;
    }

    .image-section {
        flex: 1;
        display: flex;
        justify-content: center;
    }

    .image-section img {
        width: 100%;
        max-width: 450px;
        height: auto;
        display: block;
    }

    .info-section {
        flex: 1;
    }

    .item-name {
        font-size: 32px;
        margin: 0;
        line-height: 1.2;
    }

    .brand-name {
        font-size: 16px;
        margin: 5px 0 20px;
        color: #666;
    }

    .price-box {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .price-box span {
        font-size: 14px;
        font-weight: normal;
    }

    .actions {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .action-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 40px;
    }

    .action-icon {
        width: 32px;
        height: 32px;
        cursor: pointer;
    }

    .btn-buy {
        display: block;
        width: 100%;
        background: #ff4d4d;
        color: white;
        text-align: center;
        padding: 15px;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 20px;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin: 30px 0 15px;
    }

    .info-table {
        width: 100%;
        margin-bottom: 40px;
        border-collapse: collapse;
    }

    .info-table th {
        text-align: left;
        width: 120px;
        padding: 10px 0;
        vertical-align: top;
    }

    .info-table td {
        padding: 10px 0;
    }

    .category-tag {
        background: #e0e0e0;
        padding: 4px 15px;
        border-radius: 20px;
        font-size: 13px;
        margin-right: 5px;
        display: inline-block;
        margin-bottom: 5px;
    }

    .comment-user {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }

    .user-icon {
        width: 40px;
        height: 40px;
        background: #ddd;
        border-radius: 50%;
    }

    .comment-box {
        background: #f0f0f0;
        padding: 15px;
        border-radius: 4px;
        margin: 10px 0 30px;
    }

    .comment-label {
        font-weight: bold;
        display: block;
        margin-bottom: 10px;
    }

    .comment-textarea {
        width: 100%;
        height: 120px;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        box-sizing: border-box;
    }

    .btn-comment {
        width: 100%;
        background: #555;
        color: white;
        border: none;
        padding: 15px;
        border-radius: 4px;
        font-weight: bold;
        margin-top: 10px;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .detail-container {
            flex-direction: column;
            gap: 20px;
        }
    }
</style>

<div class="detail-wrapper">
    <div class="detail-container">
        {{-- 左：画像 --}}
        <div class="image-section">
            @if($item->image_file)
            <img src="{{ asset('storage/' . $item->image_file) }}" alt="{{ $item->name }}">
            @else
            <div style="width:100%; height:400px; background:#eee; display:flex; align-items:center; justify-content:center;">No Image</div>
            @endif
        </div>

        {{-- 右：詳細 --}}
        <div class="info-section">
            <h1 class="item-name">{{ $item->name }}</h1>
            <p class="brand-name">{{ $item->brand ?? 'ブランド名なし' }}</p>
            <div class="price-box">¥{{ number_format($item->price) }} <span>(税込)</span></div>

            {{-- ボタン・数字エリア --}}
            <div class="actions">
                <div class="action-item">
                    <form action="{{ route('like.store', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="border: none; background: none; cursor: pointer; padding: 0;">
                            @if(Auth::check() && $item->likes->contains('user_id', Auth::id()))
                            <span style="font-size: 32px; color: #ff4d4d;">❤️</span>
                            @else
                            <span style="font-size: 32px; color: #ccc;">❤️</span>
                            @endif
                        </button>
                    </form>
                    <span>{{ $item->likes->count() }}</span>
                </div>

                <div class="action-item">
                    <span style="font-size: 32px;">💬</span>
                    <span>{{ $item->comments->count() }}</span>
                </div>
            </div>

            <a href="#" class="btn-buy">購入手続きへ</a>

            <h2 class="section-title">商品説明</h2>
            <p>{!! nl2br(e($item->description)) !!}</p>

            <h2 class="section-title">商品の情報</h2>
            <table class="info-table">
                <tr>
                    <th>カテゴリー</th>
                    <td>
                        @foreach($item->categories as $category)
                        <span class="category-tag">{{ $category->name }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>商品の状態</th>
                    <td>{{ $item->condition->condition ?? '不明' }}</td>
                </tr>
            </table>

            <h2 class="section-title">コメント ({{ $item->comments->count() }})</h2>
            @foreach($item->comments as $comment)
            <div class="comment-user">
                <div class="user-icon"></div>
                <strong>{{ $comment->user->name }}</strong>
            </div>
            <div class="comment-box">
                {{ $comment->content }}
            </div>
            @endforeach

            <form action="{{ route('comment.store', $item->id) }}" method="POST" style="margin-top: 40px;">
                @csrf
                <span class="comment-label">商品へのコメント</span>
                <textarea name="content" class="comment-textarea" placeholder="ここにコメントを入力してください"></textarea>
                @error('content')
                <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p>
                @enderror
                <button type="submit" class="btn-comment">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection