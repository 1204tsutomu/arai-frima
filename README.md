# COACHTECH フリマ

## 環境構築

### Dockerビルド

- `git clone <リポジトリのURL>`
- `docker-compose up -d --build`

### Laravel環境構築

- `docker-compose exec php bash`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan storage:link`
- `exit`

## 開発環境

- 会員登録画面：http://localhost/register
- ログイン画面：http://localhost/login
- 商品一覧画面：http://localhost/
- phpMyAdmin：http://localhost:8080/

## 使用技術（実行環境）

- PHP 8.x
- Laravel 10.x
- MySQL 8.0.x
- nginx 1.21.1
- Docker / docker-compose

## テスト環境の構築

### 1. テスト用データベースの作成

- `docker-compose exec mysql bash`
- `mysql -u root -p` (Password: root)
- `CREATE DATABASE demo_test;`
- `exit`

### 2. テスト用設定ファイルの準備 (srcディレクトリ)

- `cp .env .env.testing`

### 3. テスト用データベースの初期化

- `docker-compose exec php bash`
- `php artisan key:generate --env=testing`
- `php artisan migrate --env=testing`
- `exit`

### 4. テストの実行

- `php artisan test`

### .env.testingファイルの設定内容

APP_ENV=test
DB_DATABASE=demo_test
DB_USERNAME=root
DB_PASSWORD=root

## ER図

![ER図](ER.drawio.png)
