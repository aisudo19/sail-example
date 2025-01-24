## laravel project の作成

https://readouble.com/laravel/10.x/ja/starter-kits.html

1. Docker 環境に laravelsail をインストール

```
docker run -it -v $(pwd):/opt -w /opt laravelsail/php81-composer:latest /bin/bash
```

docker run: 新しいコンテナを作成・起動
-it: 対話型ターミナルを割り当て
-v $(pwd):/opt: 現在のディレクトリをコンテナの/opt にマウント
-w /opt: コンテナの作業ディレクトリを/opt に設定
laravelsail/php81-composer:latest: PHP 8.1 と Composer がインストールされた Docker イメージを使用
/bin/bash: コンテナ起動時に bash シェルを実行

2. 新規 Laravel アプリケーションの作成

```
composer create-project laravel/laravel:^10.0 sail-example
cd sail-example
```

もしうまくいかなかったら先頭に sail をつけて実行？

```
sail composer create-project laravel/laravel:^10.0 sail-example
```

3. Laravel Breeze をインストール

-   認証機能のスターターキットを提供
-   --dev フラグで開発環境依存パッケージとして追加

```
sail composer require laravel/breeze --dev
```

4. オプション選択:

-   Blade テンプレートエンジン + Alpine.js の組み合わせ: 軽量な JavaScript フレームワークで動的 UI 実装が可能
-   Dark mode: No ダークモードの CSS を含まない
-   Testing: PHPUnit: PHP 標準のテストフレームワーク

```
sail php artisan breeze:install
```

ターミナル画面上で選択する
┌ Which Breeze stack would you like to install? ───────────────┐
│ › ● Blade with Alpine │
│ ○ Livewire (Volt Class API) with Alpine │
│ ○ Livewire (Volt Functional API) with Alpine │
│ ○ React with Inertia │
│ ○ Vue with Inertia │
│ ○ API only │
└──────────────────────────────────────────────────────────────┘
┌ Which Breeze stack would you like to install? ───────────────┐
│ Blade with Alpine │
└──────────────────────────────────────────────────────────────┘

┌ Would you like dark mode support? ───────────────────────────┐
│ No │
└──────────────────────────────────────────────────────────────┘

┌ Which testing framework do you prefer? ──────────────────────┐
│ PHPUnit │
└──────────────────────────────────────────────────────────────┘

5. データベースマイグレーションを実行

-   認証に必要なテーブルを作成

```
sail php artisan migrate
```

5.

-   フロントエンド依存パッケージをインストール
-   Vite でアセットをビルド・監視

```
    npm install
    npm run dev
```
