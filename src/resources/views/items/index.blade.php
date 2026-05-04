@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

<div class="item-container">
    <div class="tabs">
        <span class="tab active">おすすめ</span>
        <span class="tab">マイリスト</span>
    </div>
    <div class="item-grid">
        @forelse ($items as $item)
        {{-- ここからが「1つの商品」のまとまり --}}
        <a href="{{ route('item.show', ['item_id' => $item->id]) }}" class="item-card-link" style="text-decoration: none; color: inherit;">
            <div class="item-card">
                <div class="item-image">
                    @if($item->image_file)
                    <img src="{{ asset('storage/image/' . $item->image_file) }}" alt="{{ $item->name }}">
                    @else
                    <div class="dummy-box">商品画像</div>
                    @endif
                </div>
                <div class="item-info">
                    <p class="item-name">{{ $item->name }}</p>
                </div>
            </div>
        </a>
        {{-- ここまでを1回だけ書く --}}
        @empty
        <p>商品が登録されていません。</p>
        @endforelse
    </div>
</div> {{-- 閉じタグ忘れずに --}}
@endsection