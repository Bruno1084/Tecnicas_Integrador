<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/tareaTable.css">
    <title>Manejador de Tareas</title>
</head>

<body>
    <?= view('Layout/header.php'); ?>

    <main>
        <?= view('Layout/sideBar.php'); ?>

        <section>
            <h1>Tareas</h1>

            <div class="options--container">
                <div>
                    <a href="/tasks/create">Añadir</a>
                </div>
            </div>

            <?= view('Layout/TaskFilter') ?>

            <section class="table--container">
                <?php if (!isset($tasks) || !is_array($tasks) || count($tasks) === 0): ?>
                    <div class="empty-message">
                        <p>No hay tareas registradas.</p>
                    </div>
                <?php else: ?>
                    <!-- Cabecera -->
                    <div class="table--header">
                        <div>ID</div>
                        <div>Título</div>
                        <div>Descripcion</div>
                        <div>Prioridad</div>
                        <div>Estado</div>
                        <div>Recordatorio</div>
                        <div>Vencimiento</div>
                        <div>Autor</div>
                    </div>

                    <!-- Filas -->
                    <?php foreach ($tasks as $task): ?>
                        <div class="table--row" onclick="window.location='/tasks/<?= $task['id'] ?>'">
                            <div><?= htmlspecialchars($task['id']) ?></div>
                            <div><?= htmlspecialchars($task['subject']) ?></div>
                            <div><?= htmlspecialchars($task['description']) ?></div>
                            <div><?= htmlspecialchars($task['priority']) ?></div>
                            <div><?= htmlspecialchars($task['state']) ?></div>
                            <div><?= htmlspecialchars($task['reminderDate']) ?></div>
                            <div><?= htmlspecialchars($task['expirationDate']) ?></div>
                            <div><?= htmlspecialchars($userNickname) ?></div>
                            <div class="row--actions" onclick="event.stopPropagation()">
                                <a href="/tasks/editar/<?= $task['id'] ?>">✏️</a>
                                <a href="/tasks/eliminar/<?= $task['id'] ?>">❌</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </section>
    </main>
</body>

</html>