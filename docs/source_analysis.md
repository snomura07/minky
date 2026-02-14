# ソースコード分析

## 概要
- このリポジトリは、PHPで構成された小規模な気象データ収集アプリです。
- Webダッシュボード（`/dashboard`）を提供します。
- バッチ処理で気象データの取得と日次集計を行います。
- 独自のマイグレーション実行機構を持ちます。
- 実行基盤はDocker（Nginx + PHP-FPM + MySQL）です。

## ディレクトリ構成
- `src/public/index.php`: Webエントリポイント
- `src/bootstrap/`: 環境変数・DB初期化
- `src/routes/web.php`: ルーティング定義
- `src/app/Core/Route.php`: 最小構成のルーター
- `src/app/Controller/`: コントローラー（`DashboardController`、`TestController`）
- `src/app/actions/`: ユースケース層（気象取得、日次集計、マイグレーション、Discord通知）
- `src/app/repositories/`: Eloquentモデルを利用したデータアクセス層
- `src/app/models/`: Eloquentモデル
- `src/database/migrations/`: マイグレーションファイルと実行スクリプト
- `src/script/`: CLIバッチスクリプト
- `docker/`: Compose、Dockerfile、Nginx/PHP-FPM/Supervisor設定

## Web実行フロー
1. Nginxが `src/public/index.php` を起点にリクエストを処理します。
2. `index.php` が `bootstrap/app.php`、Composerオートロード、ルーティングを読み込みます。
3. `Route::dispatch()` がパスを解決してコントローラーを生成・実行します。
4. `DashboardController` がセッション開始、CSRFトークン生成、`src/view/layout.php` の描画を行います。

## バッチ/データフロー
1. `src/script/get_wether.php` が Open-Meteo API を呼び出し、`weather_reports` に観測データを保存します。
2. 同スクリプトがDiscord Webhookへ通知を送信します。
3. `src/script/get_daily_weather_stats.php` が `weather_reports` から日次集計を算出します。
4. 集計結果を `daily_weather_stats` に保存し、Discordへ通知します。

## データ層
- ORMは `illuminate/database`（Eloquent）を使用しています。
- DB接続は `src/bootstrap/modules/init_db_connect.php` で初期化されます。
- 主なテーブル:
- `migrations`
- `weather_reports`
- `daily_weather_stats`
- `users`（作成されるが、現行アプリフローでは未使用）

## マイグレーション機構
- 実行入口: `src/database/migrations/run.php`
- ロジック本体: `src/app/actions/migration.php`
- 挙動:
- マイグレーションディレクトリを走査し、未登録ファイルを `migrations` テーブルに登録
- `rev = null` のレコードを対象に `up()` を実行
- ロールバック時は最新 `rev` の `down()` を実行
- ステータス表示で登録済みマイグレーション一覧を出力

## フロントエンド
- Tailwind CSS を `src/package.json` のスクリプトでビルドします。
- 入力ファイル: `src/input.css`
- 出力ファイル: `src/public/tailwind.css`
- `src/public/assets/app.js` は存在しますが、現状は空です。

## 環境・インフラの所見
- Docker Composeでは `DB_DATABASE/DB_USER/DB_PASSWORD` を設定していますが、PHP側は `DB_NAME/DB_USER/DB_PASS` を参照しています。
- MySQL初期化SQLでは `myappdb` + `appuser` を作成していますが、Composeでは `knowledge` + `knowledge` を利用しています。
- `src/.env` で上書きしない限り、DB接続不整合が発生する可能性があります。

## リスク・不整合
- `src/script/get_wether.php` はファイル名スペルに揺れ（`wether`）があり、保守性を下げます。
- `measured_time` がマイグレーション上 `string` 型のため、時刻比較が文字列比較依存です。
- モデルは `public $timestamps = false` ですが、テーブル定義には `timestamps()` が存在します。
- `MigrationRepository::getLatestRevNumber()` は、レコード0件時の考慮がありません。
- `docs/migrate.md` は `migrate.php` を参照していますが、実体は `src/database/migrations/run.php` です。
- `src/routes/web.php` の `require_once '../app/Controller/test.php'` は実行時カレントディレクトリ依存です。

## 改善優先度（短期）
1. Compose、`.env`、PHPブートストラップのDB環境変数名と値を統一する。
2. `measured_time` を `datetime` 型へ変更し、集計クエリ条件を整合させる。
3. マイグレーション処理を0件時にも安全に動くよう堅牢化する。
4. ファイル名とドキュメント参照先（`get_weather.php`、マイグレーション実行手順）を整合させる。
5. `require` パスを `__DIR__` ベースへ統一し、実行場所依存を排除する。

## 実行手順（現状）
- PHP依存をインストール: `composer install`（`src/`）
- フロント依存をインストール: `npm install`（`src/`）
- CSSをビルド: `npm run build`（`src/`）
- コンテナ起動: `docker compose -f docker/docker-compose.yml up --build`
- マイグレーション実行: `php src/database/migrations/run.php`
