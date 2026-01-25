<?php

require __DIR__ . '/../models/cities.php';

class CitiesRepository
{
    public function getAll(){
        return Cities::all();
    }
}