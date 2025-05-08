<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>

    <?php foreach($styles ?? [] as $style): ?>
        <link rel="stylesheet" href="<?= base_url("css/" . $style) ?>">
    <?php endforeach; ?>
</head>

<body>
    <header>
        <div>
            <h1>Task Manager</h1>
        </div>
        <div>
            <nav>
                <a href="#">Link1</a>
                <a href="#">Link2</a>
                <a href="#">Link3</a>
            </nav>
        </div>
    </header>