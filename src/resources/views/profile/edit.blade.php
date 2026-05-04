@extends('layouts.app')

@section('content')
<style>
    .edit-wrapper {
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

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 16px;
    }

    /* 画像選択エリア */
    .avatar-section {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
    }

    .avatar-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #eee;
        overflow: hidden;
        border: 1px solid #ddd;
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .btn-select-image {
        border: 2px solid #ff4d4d;
        color: #ff4d4d;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        background: #fff;
    }

    .btn-update {
        width: 100%;
        background: #ff4d4d;
        color: #fff;
        padding: 15px;
        border: none;
        border-radius: 4px;
        font-weight: bold;
        cursor: pointer;
        font-size: 16px;
        margin-top: 10px;
    }

    .error-msg {
        color: #ff4d4d;
        font-size: 14px;
        margin-top: 5px;
    }
</style>

<div class="edit-wrapper">
    <h2 class="page-title">プロフィール設定</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 画像設定セクション --}}
        <div class="avatar-section">
            <div class="avatar-preview">
                @if($user->img_url)
                <img src="{{ asset('storage/' . $user->img_url) }}" alt="avatar" id="preview">
                @else
                <div id="no-image" style="font-size: 50px; text-align: center; line-height: 100px; color: #999;">👤</div>
                @endif
            </div>
            <label class="btn-select-image">
                画像を選択する
                <input type="file" name="image" style="display: none;" onchange="previewImage(this);">
            </label>
        </div>

        {{-- ユーザー名 --}}
        <div class="form-group">
            <label class="form-label">ユーザー名</label>
            <input type="text" name="username" value="{{ old('username', $user->name) }}" class="form-control">
            @error('username') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        {{-- 郵便番号 --}}
        <div class="form-group">
            <label class="form-label">郵便番号</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" class="form-control">
            @error('postal_code') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        {{-- 住所 --}}
        <div class="form-group">
            <label class="form-label">住所</label>
            <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control">
            @error('address') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        {{-- 建物名 --}}
        <div class="form-group">
            <label class="form-label">建物名</label>
            <input type="text" name="building" value="{{ old('building', $user->building) }}" class="form-control">
            @error('building') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn-update">更新する</button>
    </form>
</div>

<script>
    function previewImage(obj) {
        var fileReader = new FileReader();
        fileReader.onload = (function() {
            var canvas = document.getElementById('preview');
            if (!canvas) {
                // No Imageの状態から画像を選択した場合の処理
                document.getElementById('no-image').innerHTML = '<img id="preview" style="width:100%; height:100%; object-fit:cover;">';
                canvas = document.getElementById('preview');
            }
            canvas.src = fileReader.result;
        });
        fileReader.readAsDataURL(obj.files[0]);
    }
</script>
@endsection