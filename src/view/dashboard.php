<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title>

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="/tailwind.css">
</head>
<body class="bg-gray-100 p-8">

    <h1 class="text-3xl font-bold text-blue-600">
        <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
    </h1>

</body>
</html>
