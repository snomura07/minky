<?php

require_once __DIR__ . '/../repositories/cities.php';

class CityAction
{
    protected CitiesRepository $citiesRepository;

    function __construct()
    {
        $this->citiesRepository = new CitiesRepository();
    }

    public function getAll()
    {
        return $this->citiesRepository->getAll();
    }
}