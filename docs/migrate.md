## target
- migrate.php

## 実行方法
 - php migrate.php 
 - php migrate.php rollback
 - php migrate.php status

## 機能
### up 処理
- ディレクトリ内のmigrationsを一覧で取得
- DB内のmigrationsテーブルと照合し、存在しないものをinsert
- 一覧中のrevがnullのものを対象に実行

### rollback 処理
- DB内のMigrationテーブル内のrev最大値を取得
- 最大revに対応するmigrationファイルを特定し、down処理を実行
- その後、DB内のMigrationテーブルから該当レコードを削除

### status処理
- ディレクトリ内のmigrationsを一覧で取得
- DB内のmigrationsテーブルと照合し、存在しないものをinsert
- insert後の一覧を表示


