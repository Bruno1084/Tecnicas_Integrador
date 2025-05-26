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
            <h1>Tareas Compartidas</h1>

            <?= view('Layout/TaskFilter') ?>

            <section class="table--container">
                <?php if (!isset($sharedTasks) || !is_array($sharedTasks) || count($sharedTasks) === 0): ?>
                    <div class="empty-message">
                        <p>No hay tareas compartidas.</p>
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
                        <div>Edición</div>
                    </div>
                    
                     <!-- Filas -->
                    <?php foreach ($sharedTasks as $sharedTasks): ?>
                        <div class="table--row" onclick="window.location='/tasks/<?= $sharedTasks['id'] ?>'">
                            <div><?= htmlspecialchars($sharedTasks['id']) ?></div>
                            <div><?= htmlspecialchars($sharedTasks['subject']) ?></div>
                            <div><?= htmlspecialchars($sharedTasks['description']) ?></div>
                            <div><?= htmlspecialchars($sharedTasks['priority']) ?></div>
                            <div><?= htmlspecialchars($sharedTasks['state']) ?></div>
                            <div><?= htmlspecialchars($sharedTasks['reminderDate']) ?></div>
                            <div><?= htmlspecialchars($sharedTasks['expirationDate']) ?></div>
                            <div><?= htmlspecialchars($sharedTasks['authorNickname']) ?></div>
                            <?php if($sharedTasks['canEdit']): ?>
                            <div class="row--actions" onclick="event.stopPropagation()">
                                <a href="/tasks/update/<?= $sharedTasks['id'] ?>">✏️</a>
                                <a href="/tasks/delete/<?= $sharedTasks['id'] ?>">❌</a>
                            </div>
                            <?php else: ?>
                            <div class="row--actions" onclick="event.stopPropagation()">
                                <p>Desactivado</p>
                            </div>
                            <?php endif; ?>    
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </section>
    </main>
</body>

</html>