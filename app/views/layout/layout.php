<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'FindIn' ?></title>
    <link rel="stylesheet" href="/public/styles/main.css">
    <?php
        $cssPath = "/public/styles/{$view}.css";
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $cssPath)) {
            echo '<link rel="stylesheet" href="' . $cssPath . '">';
        }
    ?>
    
</head>
<body>
    <?= $content ?>
</body>
</html>