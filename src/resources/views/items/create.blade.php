@extends('layouts.app')

@section('content')
<style>
    .sell-wrapper {
        max-width: 600px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .page-title {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        color: #666;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin: 40px 0 20px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    /* 画像アップロード */
    .image-upload-box {
        border: 2px dashed #ccc;
        border-radius: 8px;
        padding: 40px;
        text-align: center;
        cursor: pointer;
        position: relative;
    }

    .btn-select-img {
        border: 2px solid #ff4d4d;
        color: #ff4d4d;
        padding: 5px 15px;
        border-radius: 4px;
        font-weight: bold;
    }

    /* カテゴリー */
    .category-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .category-item input {
        display: none;
    }

    .category-label {
        display: inline-block;
        padding: 5px 15px;
        border: 1px solid #ff4d4d;
        color: #ff4d4d;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
    }

    .category-item input:checked+.category-label {
        background: #ff4d4d;
        color: #fff;
    }

    /* 出品ボタン */
    .btn-sell {
        width: 100%;
        background: #ff4d4d;
        color: #fff;
        padding: 15px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        font-size: 16px;
        margin-top: 30px;
    }
</style>

<div class="sell-wrapper">
    <h2 class="page-title">商品の出品</h2>

    <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 1. 商品画像 --}}
        <div class="form-group">
            <label class="form-label">商品画像</label>
            <div class="image-upload-box" onclick="document.getElementById('item-img').click();">
                <span class="btn-select-img">画像を選択する</span>
                <input type="file" id="item-img" name="image" style="display:none;" onchange="preview(this)">
                <div id="preview-container" style="margin-top:15px;"></div>
            </div>
        </div>

        {{-- 2. 商品の詳細 --}}
        <div class="section-title">商品の詳細</div>

        <div class="form-group">
            <label class="form-label">カテゴリー</label>
            <div class="category-grid">
                @foreach($categories as $category)
                <div class="category-item">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat-{{ $category->id }}">
                    <label for="cat-{{ $category->id }}" class="category-label">{{ $category->name }}</label>
                </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">商品の状態</label>
            <select name="condition_id" class="form-control">
                <option value="" disabled selected>選択してください</option>
                @foreach($conditions as $condition)
                <option value="{{ $condition->id }}">{{ $condition->condition }}</option>
                </option>
                @endforeach
            </select>
        </div>

        {{-- 3. 商品名と説明 --}}
        <div class="section-title">商品名と説明</div>

        <div class="form-group">
            <label class="form-label">ブランド名</label>
            <input type="text" name="brand" class="form-control" placeholder="例：シャネル">
        </div>

        <div class="form-group">
            <label class="form-label">商品名</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">商品の説明</label>
            <textarea name="description" rows="5" class="form-control"></textarea>
        </div>

        {{-- 4. 販売価格 --}}
        <div class="section-title">販売価格</div>
        <div class="form-group">
            <label class="form-label">販売価格</label>
            <div style="position:relative; display: flex; align-items: center;">
                <span style="position:absolute; left:12px;">¥</span>
                <input type="number" name="price" class="form-control" style="padding-left:30px;" placeholder="0">
            </div>
        </div>

        {{-- 出品ボタン --}}
        <div style="margin-top: 40px; text-align: center;">
            <button type="submit" class="btn-sell">出品する</button>
        </div>
    </form>
</div>

<script>
    function preview(input) {
        const container = document.getElementById('preview-container');
        container.innerHTML = '';
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100px';
                container.appendChild(img);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection