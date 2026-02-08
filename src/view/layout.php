<?php
// $title と $view が index.php から渡される前提
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="/tailwind.css">

    <!-- JS -->
    <script src="/assets/app.js" defer></script>
</head>

<body class="bg-gray-50 min-h-screen text-gray-900">

    <?php include __DIR__ . "/header.php"; ?>

    <main class="max-w-6xl mx-auto px-6 py-10">
        <?php include __DIR__ . "/{$view}.php"; ?>
    </main>

    <?php include __DIR__ . "/footer.php"; ?>

</body>
</html>
