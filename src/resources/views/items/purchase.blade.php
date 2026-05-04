@extends('layouts.app')

@section('content')
<style>
    /* 全体コンテナ：左右のバランスを見本に合わせる */
    .purchase-container {
        max-width: 1050px;
        margin: 50px auto;
        display: flex;
        gap: 80px;
        /* 左右の余白を広げて見本のゆとりを再現 */
        padding: 0 25px;
    }

    /* 左側：メインエリア */
    .purchase-left {
        flex: 1;
    }

    /* 右側：決済確認ボックス（どっしり固定） */
    .purchase-right {
        flex: 0 0 380px;
        /* 幅を固定して見本のような重厚感を出す */
        border: 2px solid #000;
        /* 枠線を太くして存在感を強調 */
        padding: 30px;
        height: fit-content;
        border-radius: 2px;
    }

    .payment-select {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 15px;
    }

    /* 商品情報エリア：画像と文字をコンパクトに */
    .item-info {
        display: flex;
        gap: 35px;
        margin-bottom: 40px;
        align-items: flex-start;
    }

    .item-image {
        width: 130px;
        /* 見本のサイズ感に調整 */
        height: 130px;
        background: #eee;
        flex-shrink: 0;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-detail h2 {
        font-size: 22px;
        /* 見本に合わせて少し控えめに */
        margin: 0 0 15px 0;
        font-weight: bold;
        line-height: 1.2;
    }

    .item-detail p {
        font-size: 20px;
        font-weight: 500;
        margin: 0;
    }

    /* セクション：下線のみのデザインに見本通り変更 */
    .section-box {
        border-bottom: 1px solid #000;
        /* 上線ではなく下線を黒で引く */
        padding: 25px 0;
        margin-bottom: 5px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .section-title {
        font-size: 16px;
        font-weight: bold;
    }

    .btn-change {
        color: #007bff;
        text-decoration: none;
        font-size: 14px;
        font-weight: normal;
    }

    .section-box p {
        margin: 0;
        font-size: 15px;
        line-height: 1.6;
    }

    /* 右側：決済確認テーブル */
    .summary-table {
        width: 100%;
        margin-bottom: 40px;
        border-collapse: collapse;
    }

    .summary-table td {
        padding: 12px 0;
        font-size: 16px;
    }

    /* 合計金額（2列目）の強調 */
    .summary-table .price-val {
        text-align: right;
        font-weight: bold;
        font-size: 18px;
    }

    /* 購入確定ボタン */
    .btn-buy {
        width: 100%;
        background: #ff4d4d;
        color: #fff;
        border: none;
        padding: 16px;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        font-size: 16px;
        transition: opacity 0.3s;
    }

    .btn-buy:hover {
        opacity: 0.8;
    }

    /* レスポンシブ：スマホ時は縦並びに */
    @media (max-width: 768px) {
        .purchase-container {
            flex-direction: column;
            gap: 40px;
        }

        .purchase-right {
            width: 100%;
            box-sizing: border-box;
        }
    }
</style>
<div class="purchase-container">
    {{-- 左側：入力・確認エリア (Task 61, 63, 64) --}}
    <div class="purchase-left">
        <div class="item-info">
            <div class="item-image">
                {{-- 万が一画像がない場合も考慮 --}}
                <img src="{{ asset('storage/' . $item->image_file) }}" alt="{{ $item->name }}" style="width: 100%; height: auto;">
            </div>
            <div class="item-detail">
                <h2>{{ $item->name }}</h2>
                <p>¥{{ number_format($item->price) }}</p>
            </div>
        </div>

        <div class="section-box">
            <div class="section-header">
                <span class="section-title">支払い方法</span>
            </div>
            <select name="payment_method" form="buy-form" class="payment-select" required>
                <option value="" disabled selected>選択してください</option>
                <option value="コンビニ払い">コンビニ払い</option>
                <option value="カード支払い">カード支払い</option>
            </select>
        </div>

        {{-- 配送先 (Task 64) --}}
        <div class="section-box">
            <div class="section-header">
                <span class="section-title">配送先</span>
                {{-- 配送先変更画面への遷移 (Task 64) --}}
                <a href="{{ route('profile.editAddress', $item->id) }}" class="btn-change">変更する</a>
            </div>
            <p>〒 {{ Auth::user()->post_code }}</p>
            <p>{{ Auth::user()->address }} {{ Auth::user()->building }}</p>
        </div>
    </div>
    <div class="purchase-right">
        <table class="summary-table">
            <tr>
                <td>商品代金</td>
                <td class="price-val">¥{{ number_format($item->price) }}</td>
            </tr>
            <tr>
                <td>支払い方法</td>
                <td class="price-val">{{ session('payment_method', '未選択') }}</td>
            </tr>
        </table>

        <form action="{{ route('item.buy', $item->id) }}" method="POST" id="buy-form">
            @csrf
            <button type="submit" class="btn-buy">購入する</button>
        </form>
    </div>
</div>
@endsection