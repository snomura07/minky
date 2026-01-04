<?php

require __DIR__ . '/../models/migrations.php';

class MigrationRepository
{
    public function getAll()
    {
        return Migrations::all();
    }

    public function findByName($name)
    {
        return Migrations::where('name', $name)->first();
    }

    public function isExistsByName($name)
    {
        return Migrations::where('name', $name)->exists();
    }
}
