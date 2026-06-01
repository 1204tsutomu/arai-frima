<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール認証 - COACHTECH</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .verify-container {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 480px;
            width: 100%;
            text-align: center;
        }

        h1 {
            font-size: 22px;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .btn-verify {
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            padding: 12px 30px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-verify:hover {
            background-color: #e03d3d;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="verify-container">
        <h1>会員登録ありがとうございます！</h1>

        @if (session('message'))
        <div class="alert-success">
            {{ session('message') }}
        </div>
        @endif

        <p>
            現在、仮登録の状態です。<br>
            ご登録いただいたメールアドレス宛に認証メールをお送りしました。<br>
            メール内のリンクをクリックして、本登録を完了させてください。
        </p>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-verify">
                認証はこちらから
            </button>
        </form>
    </div>

</body>

</html>