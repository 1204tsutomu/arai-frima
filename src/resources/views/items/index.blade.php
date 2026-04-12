@extends('layouts.app') {{-- これが重要！app.blade.phpを呼び出します --}}

@section('content') {{-- ここから下が、app.blade.php の @yield('content') に流し込まれます --}}
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

<div class="item-container">
    <div class="tabs">
        <span class="tab active">おすすめ</span>
        <span class="tab">マイリスト</span>
    </div>

    <div class="item-grid">
        @forelse ($items as $item)
        <div class="item-card">
            <div class="item-image">
                @if($item->image_name)
                <img src="{{ asset('storage/' . $item->image_name) }}" alt="{{ $item->name }}">
                @else
                <div class="dummy-box">商品画像</div>
                @endif
            </div>
            {{-- ↓ ここをカードの中にしっかり閉じ込めます ↓ --}}
            <div class="item-info">
                <p class="item-name">{{ $item->name }}</p>
            </div>
        </div>
        @empty
        <p>商品が登録されていません。</p>
        @endforelse
    </div>
    @endsection {{-- 終わり！ --}}