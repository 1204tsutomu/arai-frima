@extends('layouts.app')

@section('content')
<div style="max-width:520px;margin:0 auto;padding:80px 0;font-family:sans-serif;">
    <div style="background:#fff;border:1px solid #eee;padding:48px 40px;text-align:center;">
        <!-- <h2 style="margin:0 0 24px;font-size:18px;font-weight:bold;">メール認証</h2> -->

        @if (session('status') === 'verification-link-sent')
        <p style="margin:0 0 16px;color:#2e7d32;font-weight:bold;">
            認証メールを再送しました。
        </p>
        @endif

        <p style="margin:0 0 28px;line-height:1.8;font-size:13px;color:#333;">
            登録していただいたメールアドレス宛に認証メールを送信しました。<br>
            メール認証を完了してください。
        </p>

        <form method="POST" action="{{ route('verification.send') }}" style="margin:0 0 16px;">
            @csrf
            <button type="submit"
                style="background:#e0e0e0;color:#333;border:1px solid #cfcfcf;padding:10px 18px;border-radius:3px;font-size:12px;cursor:pointer;">
                認証はこちらから
            </button>
        </form>

        <a href="{{ url('/') }}" style="font-size:12px;color:#1e88e5;text-decoration:underline;">
            認証メールを再送する
        </a>
    </div>
</div>
@endsection