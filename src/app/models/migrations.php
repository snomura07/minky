<?php
use Illuminate\Database\Eloquent\Model;

class Migrations extends Model
{
    protected $table   = 'migrations';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'rev',
    ];
}
