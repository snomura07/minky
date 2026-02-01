<?php

require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Route;

require_once __DIR__ . '/../routes/web.php';

Route::dispatch();
