<?php

require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../vendor/autoload.php';
use App\Controller\DashboardController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

switch ($uri) {
    case '/':
        require_once '../app/controllers/test.php';
        break;

    case '/test':
        require_once '../app/controllers/test.php';
        break;

    case '/dashboard':
        $controller = new DashboardController();
        $controller();
        break;

    default:
        http_response_code(404);
        echo "Not Found";
}
