<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
    <style>
        .header {
            background: #000;
            border-bottom: none;
        }

        .header__logo {
            color: #fff;
            text-decoration: none;
        }

        .form__button-submit {
            background: #ff5a5f;
        }

        .form__login-link {
            text-align: center;
            margin-top: 15px;
        }

        .form__login-link a {
            color: #0080ff;
            text-decoration: none;
            font-size: 14px;
        }

        .form__error p {
            color: red;
            font-size: 0.8em;
            margin-top: 5px;
            margin-bottom: 0;
        }

        /* ロゴ画像の高さを指定して、デカくなるのを防ぐ */
        .header__logo img {
            height: 40px;
            /* ここでお好みの大きさに調整してください（Figmaに近いのはこれくらい） */
            width: auto;
            /* 横幅は自動調整 */
            display: block;
            /* 余計な隙間をなくす */
        }

        /* ヘッダー内の配置を微調整（もし必要なら） */
        .header__inner {
            display: flex;
            align-items: center;
            /* 縦方向の中央寄せ */
            padding: 15px 40px;
            /* 上下の余白を作って、ロゴを中央に配置 */
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header__inner" style="padding: 10px 40px;">
            <a class="header__logo" href="/">
                <img src="{{ asset('img/logo.png') }}" alt="COACHTECH" style="height: 35px; display: block;">
            </a>
        </div>
    </header>

    <main>
        <div class="contact-form__content">
            <div class="contact-form__heading">
                <h2>ログイン</h2>
            </div>

            <form action="/login" method="POST" novalidate>
                @csrf

                {{-- メールアドレス --}}
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">メールアドレス</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="email" name="email" placeholder="test@example.com" value="{{ old('email') }}" />
                        </div>
                        <div class="form__error">
                            @error('email') <p>{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- パスワード --}}
                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">パスワード</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="password" name="password" />
                        </div>
                        <div class="form__error">
                            @error('password') <p>{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="form__button">
                    <button class="form__button-submit" type="submit">ログインする</button>
                </div>
            </form>

            <div class="form__login-link">
                <a href="/register">会員登録はこちら</a>
            </div>
        </div>
    </main>
</body>

</html>