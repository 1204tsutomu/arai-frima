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
    </style>
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">COACHTECH</a>
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