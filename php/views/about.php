<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Page</title>
</head>
<body>
    <h1>This is the About Page</h1>
    <p>This data is coming from the server: <?= htmlspecialchars($catFact); ?></p>
    <h2>Users</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?= htmlspecialchars($user['username']); ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="/"><button>Back to Home</button></a>
</body>
</html>