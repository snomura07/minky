<?php

use App\Core\Route;
require_once '../app/Controller/test.php';

Route::get('/test', TestController::class);
Route::get('/dashboard', App\Controller\DashboardController::class);
