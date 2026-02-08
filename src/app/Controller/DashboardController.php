<?php

namespace App\Controller;

class DashboardController
{
    public function __invoke()
    {
        session_start();

        // CSRFトークン生成
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $this->render(__DIR__ . '/../../view/layout.php', [
            'title'      => 'ダッシュボード',
            'view'       => 'dashboard',
            'csrf_token' => $_SESSION['csrf_token'],
        ]);
    }

    private function render(string $template, array $data = [])
    {
        extract($data, EXTR_SKIP);
        include $template;
    }
}
