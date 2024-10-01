<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <title> <?= isset($title) ? h($title) : 'Mon Calendrier'; ?> </title>
</head>

<body>
    <nav class="navbar-dark bg-primary mb-3">
        <a href="/index.php" class="navbar-brand">Mon calendrier</a>
    </nav>