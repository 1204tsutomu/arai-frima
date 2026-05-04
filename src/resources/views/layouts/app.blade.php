<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <style>
        /* ヘッダー周りの基盤スタイル */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .header {
            background: #000;
            color: #fff;
        }

        .header__inner {
            max-width: 1230px;
            margin: 0 auto;
            padding: 15px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header__logo img {
            height: 25px;
            display: block;
        }

        .header__search {
            flex: 1;
            margin: 0 40px;
        }

        .header__search input {
            width: 100%;
            padding: 8px 15px;
            border-radius: 4px;
            border: none;
        }

        .nav-list {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 20px;
            align-items: center;
        }

        .nav-list a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-exhibit {
            background-color: #fff;
            color: #000 !important;
            padding: 6px 15px;
            border-radius: 4px;
        }

        /* --- スマホ・タブレット用（レスポンシブ） --- */
        @media screen and (max-width: 768px) {
            .header__inner {
                flex-wrap: wrap;
                padding: 10px 20px;
            }

            .header__logo {
                order: 1;
            }

            .header__nav {
                order: 2;
            }

            .header__search {
                order: 3;
                flex: 0 0 100%;
                margin: 10px 0 0 0;
            }

            .nav-list {
                gap: 10px;
            }

            .nav-list a {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__logo">
                <a href="{{ route('items.index') }}">
                    <img src="{{ asset('img/logo.png') }}" alt="COACHTECHロゴ">
                </a>
            </div>

            <div class="header__search">
                <input type="text" placeholder="なにかをお探しですか？">
            </div>

            <nav class="header__nav">
                <ul class="nav-list">
                    @auth
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none; border:none; color:#fff; font-weight:bold; cursor:pointer; font-size:14px;">ログアウト</button>
                        </form>
                    </li>
                    <li><a href="{{ route('profile.index') }}">マイページ</a></li>
                    @endauth

                    @guest
                    <li><a href="{{ route('login') }}">ログイン</a></li>
                    <li><a href="{{ route('register') }}">会員登録</a></li>
                    @endguest

                    <li><a href="{{ route('item.create') }}" class="btn-exhibit">出品</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>