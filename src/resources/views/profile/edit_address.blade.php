@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 40px auto; padding: 0 20px;">
    <h2 style="text-align: center; margin-bottom: 30px; font-weight: bold;">住所の変更</h2>

    <form action="{{ route('profile.updateAddress', ['item_id' => $item_id]) }}" method="POST">
        @csrf

        {{-- 郵便番号 --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px;">郵便番号</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}"
                style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            @error('postal_code')
            <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        {{-- 住所 --}}
        <div style="margin-bottom: 20px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px;">住所</label>
            <input type="text" name="address" value="{{ old('address', $user->address) }}"
                style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            @error('address')
            <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        {{-- 建物名 --}}
        <div style="margin-bottom: 30px;">
            <label style="display: block; font-weight: bold; margin-bottom: 8px;">建物名</label>
            <input type="text" name="building" value="{{ old('building', $user->building) }}"
                style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            @error('building')
            <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        {{-- 更新ボタン --}}
        <button type="submit" style="width: 100%; background: #ff4d4d; color: #fff; padding: 15px; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 16px;">
            更新する
        </button>
    </form>
</div>
@endsection