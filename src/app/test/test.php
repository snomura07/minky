<?php

require __DIR__ . '/../../bootstrap/app.php';
require __DIR__ . '/../repositories/migrations.php';

$migrationRepository = new MigrationRepository();
$migrations = $migrationRepository->getAll();

printf("%-4s | %-50s | %-5s%s", "id", "Migration", "Rev", PHP_EOL);
printf("%s+%s+%s%s", str_repeat("-", 5), str_repeat("-", 52), str_repeat("-", 7), PHP_EOL);
foreach ($migrations as $migration) {
    printf("%-4d | %-50s | %-5d%s", $migration->id, $migration->name, is_null($migration->rev) ? " " : $migration->rev, PHP_EOL);
}
printf("%s+%s+%s%s", str_repeat("-", 5), str_repeat("-", 52), str_repeat("-", 7), PHP_EOL);

$migrarionFileName = '2025_01_01_000001_add_users_table';
$isexists = $migrationRepository->isExistsByName($migrarionFileName);
if($isexists) {
    print("Migration '$migrarionFileName' exists." . PHP_EOL);
} else {
    print("Migration '$migrarionFileName' does not exist." . PHP_EOL);
}

$latestRevNum = $migrationRepository->getLatestRevNumber();
print("Latest revision number: " . $latestRevNum . PHP_EOL);

$dir   = __DIR__.'/../../database/migrations';
$files = array_diff(scandir($dir), ['.', '..']);
foreach ($files as $file) {
    $migrationFileName = basename($file, '.php');
    echo $migrationFileName . PHP_EOL;

    $isexists = $migrationRepository->isExistsByName($migrationFileName);
    if($isexists) {
        print("  -> exists in database." . PHP_EOL);
    }
    else {
        print("  -> does not exist in database." . PHP_EOL);

        $data = [
            'name' => $migrationFileName,
            'rev'  => null,
        ];
        $migrationRepository->create($data);
    }
}
