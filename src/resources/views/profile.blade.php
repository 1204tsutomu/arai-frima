@extends('layouts.app')

@section('content')
<style>
    .profile-container {
        max-width: 520px;
        margin: 40px auto 0;
        font-family: sans-serif;
    }

    .profile-title {
        text-align: center;
        font-weight: bold;
        margin-bottom: 40px;
        font-size: 24px;
    }

    /* 入力欄の幅（ここだけ後で微調整すればOK） */
    .form-inner {
        width: 410px;
        /* 見本に近い太さ。合わなければ 360〜400 */
        margin: 0 auto;
    }

    /* 丸を入力欄の左に揃える */
    .avatar-section {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 12px;
        width: 100%;
        margin: 0 0 32px;
    }

    .avatar-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #d9d9d9;
        flex-shrink: 0;
    }

    .image-upload-label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        border: 1px solid #ff5a5f;
        color: #ff5a5f;
        border-radius: 4px;
        font-weight: bold;
        font-size: 14px;
        white-space: nowrap;
        background: transparent;
        cursor: pointer;
    }

    .form-group {
        margin-bottom: 25px;
        width: 100%;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .btn-update {
        width: 100%;
        background-color: #ff5a5f;
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 20px;
    }

    .d-none {
        display: none;
    }
</style>

<div class="profile-container">
    <h2 class="profile-title">プロフィール設定</h2>



    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-inner">
            <div class="avatar-section">
                <div class="avatar-circle"></div>
                <label class="image-upload-label">
                    画像を選択する
                    <input type="file" name="image" class="d-none">
                </label>
            </div>

            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="postcode">郵便番号</label>
                <input type="text" name="postcode" id="postcode" value="{{ old('postcode') }}">
            </div>

            <div class="form-group">
                <label for="address">住所</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}">
            </div>

            <div class="form-group">
                <label for="building">建物名</label>
                <input type="text" name="building" id="building" value="{{ old('building') }}">
            </div>

            <button type="submit" class="btn-update">更新する</button>
        </div>
    </form>
</div>
@endsection