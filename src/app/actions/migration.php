<?php

require_once __DIR__ . '/../repositories/migrations.php';

class Migration
{
    protected MigrationRepository $migrationRepository;
    protected string $migrationDir;

    public function __construct(string $migrationDir)
    {
        $this->migrationDir        = $migrationDir;
        $this->migrationRepository = new MigrationRepository();
    }

    public function up()
    {
        print("Running migrations..." . PHP_EOL);
        $this->scanAndRegistFiles();

        $migrations   = $this->migrationRepository->findByRev($rev=null);
        $latestRevNum = $this->migrationRepository->getLatestRevNumber();
        foreach ($migrations as $migration) {
            $migrationFilePath = $this->migrationDir . '/' . $migration->name;
            if (file_exists($migrationFilePath)) {
                print("Applying migration: " . $migration->name . PHP_EOL);

                require_once $migrationFilePath;
                $migrationClass = require $migrationFilePath;
                $migrationClass->up();

                $migration->rev = $latestRevNum + 1;
                $migration->save();
            }
            else {
                print("Migration file not found: " . $migrationFilePath . PHP_EOL);
            }
        }
   }

    public function rollback()
    {
        print("Running migration rollback..." . PHP_EOL);

        $latestRevNum = $this->migrationRepository->getLatestRevNumber();
        $migrations   = $this->migrationRepository->findByRev($latestRevNum);

        foreach ($migrations as $migration) {
            $migrationFilePath = $this->migrationDir . '/' . $migration->name;
            if (file_exists($migrationFilePath)) {
                print("Rolling back migration: " . $migration->name . PHP_EOL);

                require_once $migrationFilePath;
                $migrationClass = require $migrationFilePath;
                $migrationClass->down();

                $migration->rev = null;
                $migration->save();
            }
            else {
                print("Migration file not found: " . $migrationFilePath . PHP_EOL);
            }
        }
    }

    public function status()
    {
        $this->scanAndRegistFiles();        

        $migrations = $this->migrationRepository->getAll();
        $this->outMigrationStatus($migrations);
    }

    private function outMigrationStatus($migrations)
    {
        printf("%-4s | %-50s | %-5s%s", "id", "Migration", "Rev", PHP_EOL);
        printf("%s+%s+%s%s", str_repeat("-", 5), str_repeat("-", 52), str_repeat("-", 7), PHP_EOL);
        foreach ($migrations as $migration) {
            printf("%-4d | %-50s | %-5s%s", $migration->id, $migration->name, is_null($migration->rev) ? " " : $migration->rev, PHP_EOL);
        }
        printf("%s+%s+%s%s", str_repeat("-", 5), str_repeat("-", 52), str_repeat("-", 7), PHP_EOL);
    }

    private function scanAndRegistFiles()
    {
        $files = array_diff(scandir($this->migrationDir), ['.', '..', 'run.php']);
        foreach ($files as $fileName) {
            $isexists = $this->migrationRepository->isExistsByName($fileName);
            if(!$isexists) {
                $data = [
                    'name' => $fileName,
                    'rev'  => null,
                ];
                $this->migrationRepository->create($data);
            }
        }
    }
}