<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>会員登録</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
    <style>
        .header {
            background: #000;

            border-bottom: none;

        }

        .header__logo {
            color: #fff;

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
    </style>
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                COACHTECH
            </a>
        </div>
    </header>

    <main>
        <div class="contact-form__content">
            <div class="contact-form__heading">
                <h2>会員登録</h2>
            </div>
            <form class="form" action="/register" method="post">
                @csrf <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">ユーザー名</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="text" name="name" placeholder="例: test太郎" value="{{ old('name') }}" />
                        </div>
                        <div class="form__error">
                            @error('name') {{ $message }} @enderror
                        </div>
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">メールアドレス</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="email" name="email" placeholder="test@example.com" value="{{ old('email') }}" />
                        </div>
                        <div class="form__error">
                            @error('email') {{ $message }} @enderror
                        </div>
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">パスワード</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="password" name="password" />
                        </div>
                        <div class="form__error">
                            @error('password') {{ $message }} @enderror
                        </div>
                    </div>
                </div>

                <div class="form__group">
                    <div class="form__group-title">
                        <span class="form__label--item">確認用パスワード</span>
                    </div>
                    <div class="form__group-content">
                        <div class="form__input--text">
                            <input type="password" name="password_confirmation" />
                        </div>
                    </div>
                </div>

                <div class="form__button">
                    <button class="form__button-submit" type="submit">登録する</button>
                </div>
            </form>

            <div class="form__login-link">
                <a href="/login">ログインはこちら</a>
            </div>
        </div>
    </main>
</body>

</html>