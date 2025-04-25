<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task View</title>
</head>

<body>
    <h1>Task View</h1>

    <?php if (empty($tasks)): ?>
        <p>No hay tareas disponibles.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <strong><?= esc($task['subject']) ?></strong><br>
                    <?= esc($task['description']) ?><br>
                    Estado: <?= esc($task['state']) ?><br>
                    Prioridad: <?= esc($task['priority']) ?><br>
                    Color: <?= esc($task['color']) ?><br>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>