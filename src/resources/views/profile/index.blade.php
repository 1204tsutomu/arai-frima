@extends('layouts.app')

@section('content')
<style>
    .profile-wrapper {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
    }

    /* ユーザー情報ヘッダー */
    .profile-header {
        display: flex;
        align-items: center;
        gap: 40px;
        margin-bottom: 50px;
        justify-content: center;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        background: #ddd;
        border-radius: 50%;
        overflow: hidden;
        border: 1px solid #eee;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-info {
        display: flex;
        align-items: center;
        gap: 40px;
    }

    .user-name {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .btn-edit-profile {
        border: 2px solid #ff4d4d;
        color: #ff4d4d;
        padding: 8px 24px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
        background-color: #fff;
    }

    .btn-edit-profile:hover {
        background: #ff4d4d;
        color: #fff;
    }

    /* タブ切り替えエリア */
    .tabs {
        display: flex;
        border-bottom: 2px solid #eee;
        margin-bottom: 30px;
        gap: 40px;
    }

    .tab-item {
        padding: 10px 0;
        cursor: pointer;
        font-weight: bold;
        color: #333;
        text-decoration: none;
        border-bottom: 3px solid transparent;
        transition: 0.3s;
    }

    .tab-item.active {
        color: #ff4d4d;
        border-bottom-color: #ff4d4d;
    }

    /* 商品グリッド */
    .item-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 30px;
    }

    .item-card {
        text-decoration: none;
        color: #333;
        transition: opacity 0.3s;
    }

    .item-card:hover {
        opacity: 0.8;
    }

    .item-image {
        width: 100%;
        aspect-ratio: 1 / 1;
        background: #f5f5f5;
        margin-bottom: 12px;
        position: relative;
        border-radius: 4px;
        overflow: hidden;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-name {
        font-size: 15px;
        font-weight: bold;
        line-height: 1.4;
    }

    /* 売り切れラベル（Figmaに合わせる場合） */
    .sold-label {
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 60px 60px 0 0;
        border-color: #ff4d4d transparent transparent transparent;
        z-index: 1;
    }

    .sold-text {
        position: absolute;
        top: 8px;
        left: 4px;
        color: #fff;
        font-size: 12px;
        font-weight: bold;
        transform: rotate(-45deg);
        z-index: 2;
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            gap: 20px;
        }

        .profile-info {
            flex-direction: column;
            gap: 15px;
        }

        .item-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
    }
</style>

<div class="profile-wrapper">
    {{-- ユーザー情報ヘッダー --}}
    <div class="profile-header">
        <div class="profile-avatar">
            @if($user->img_url)
            <img src="{{ asset('storage/' . $user->img_url) }}" alt="ユーザーアイコン">
            @else
            <div style="font-size: 60px; text-align: center; line-height: 120px; background: #eee; color: #999;">👤</div>
            @endif
        </div>
        <div class="profile-info">
            <span class="user-name">{{ $user->name }}</span>
            <a href="{{ route('profile.edit') }}" class="btn-edit-profile">プロフィールを編集</a>
        </div>
    </div>

    {{-- タブ切り替え --}}
    @php $currentPage = request('page', 'selling'); @endphp
    <div class="tabs">
        <a href="?page=selling" class="tab-item {{ $currentPage == 'selling' ? 'active' : '' }}">出品した商品</a>
        <a href="?page=purchased" class="tab-item {{ $currentPage == 'purchased' ? 'active' : '' }}">購入した商品</a>
    </div>

    {{-- 商品リストエリア --}}
    <div class="item-grid">
        @php
        $displayItems = ($currentPage == 'selling') ? $sellingItems : $purchasedItems;
        @endphp

        @forelse($displayItems as $item)
        <a href="{{ route('item.show', $item->id) }}" class="item-card">
            <div class="item-image">
                {{-- 売り切れ判定（購入履歴がある、またはフラグがある場合） --}}
                @if($item->is_sold || ($currentPage == 'purchased'))
                <div class="sold-label"></div>
                <span class="sold-text">SOLD</span>
                @endif

                @if($item->img_url)
                <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
                @else
                <div style="width:100%; height:100%; background:#f0f0f0; display:flex; align-items:center; justify-content:center; color:#ccc;">No Image</div>
                @endif
            </div>
            <div class="item-name">{{ $item->name }}</div>
        </a>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; color: #999; margin-top: 50px; font-weight: bold;">
            {{ $currentPage == 'selling' ? '出品した商品はありません' : '購入した商品はありません' }}
        </div>
        @endforelse
    </div>
</div>
@endsection