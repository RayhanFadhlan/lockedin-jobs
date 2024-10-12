<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'FindIn' ?></title>
    <link rel="stylesheet" href="/public/styles/main.css">
    <!-- <link rel="stylesheet" href="/public/styles/navbar.css">
    <link rel="stylesheet" href="/public/styles/toaster.css"> -->
    <?php
        $cssPath = "/public/styles/{$view}.css";
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $cssPath)) {
            echo '<link rel="stylesheet" href="' . $cssPath . '">';
        }
    ?>
</head>
<body>
    <!-- <?php include __DIR__ . '/../components/navbarjobseeker.php'; ?> -->

    <?= $content ?>

    <!-- <?php include __DIR__ . '/../components/toaster.php'; ?> -->
    <!-- <script src="/public/scripts/toaster.js"></script> -->
</body>
</html>
