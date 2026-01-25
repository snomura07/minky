<?php
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table   = 'cities';
    public $timestamps = false;

    protected $fillable = [
        'prefecture_name',
        'city_name',
        'latitude',
        'longitude',
    ];
}
