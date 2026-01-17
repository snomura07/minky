<?php

require __DIR__ . '/../models/migrations.php';

class MigrationRepository
{
    public function getAll()
    {
        return Migrations::all();
    }

    public function getLatestRevNumber()
    {
        return Migrations::orderBy('rev', 'desc')->first()->rev;
    }

    public function create(array $data): Migrations
    {
        return Migrations::create($data);
    }

    public function findByName($name)
    {
        return Migrations::where('name', $name)->first();
    }

    public function findByRev($rev)
    {
        return Migrations::where('rev', $rev)->get();
    }

    public function isExistsByName($name)
    {
        return Migrations::where('name', $name)->exists();
    }
}
