<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/subtareaTable.css">
    <title>Manejador de Tareas</title>
</head>

<body>
    <?= view('Layout/header.php'); ?>

    <main>
        <?= view('Layout/sideBar.php'); ?>

        <section>
            <h1>Detalles de Tarea</h1>

            <div class="options--container">
                <div>
                    <a href="/subtasks/create/<?= $task['id'] ?>">Añadir subtarea</a>
                </div>
                <div>
                    <a href="/tasks/update/<?= $task['id'] ?>">Editar</a>
                </div>
                <div>
                    <a href="/tasks/delete/<?= $task['id'] ?>">Eliminar</a>
                </div>
            </div>

            <section class="tableTask--container">
                <!-- Cabecera -->
                <div class="tableTask--header">
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
                <div class="tableTask--row">
                    <div><?= htmlspecialchars($task['id']) ?></div>
                    <div><?= htmlspecialchars($task['subject']) ?></div>
                    <div><?= htmlspecialchars($task['description']) ?></div>
                    <div><?= htmlspecialchars($task['priority']) ?></div>
                    <div><?= htmlspecialchars($task['state']) ?></div>
                    <div><?= htmlspecialchars($task['reminderDate']) ?></div>
                    <div><?= htmlspecialchars($task['expirationDate']) ?></div>
                    <div><?= htmlspecialchars($task['authorNickname']) ?></div>
                </div>
            </section>


            <h2>Subtareas</h2>
            <?= view('Layout/SubtaskFilter') ?>
            <section class="tableSubtask--container">
                <?php if (!isset($subtasks) || !is_array($subtasks) || count($subtasks) === 0): ?>
                    <div class="empty-message">
                        <p>No hay subtareas registradas.</p>
                    </div>
                <?php else: ?>
                    <!-- Cabecera -->
                    <div class="tableSubtask--header">
                        <div>ID</div>
                        <div>Título</div>
                        <div>Descripcion</div>
                        <div>Prioridad</div>
                        <div>Estado</div>
                        <div>Recordatorio</div>
                        <div>Vencimiento</div>
                        <div>Comentario</div>
                        <div>Autor</div>
                    </div>

                    <!-- Filas -->
                    <?php foreach ($subtasks as $subtask): ?>
                        <div class="tableSubtask--row" onclick="window.location='/subtasks/<?= $subtask['id'] ?>'">
                            <div><?= htmlspecialchars($subtask['id']) ?></div>
                            <div><?= htmlspecialchars($subtask['subject']) ?></div>
                            <div><?= htmlspecialchars($subtask['description']) ?></div>
                            <div><?= htmlspecialchars($subtask['priority']) ?></div>
                            <div><?= htmlspecialchars($subtask['state']) ?></div>
                            <div><?= htmlspecialchars($subtask['reminderDate']) ?></div>
                            <div><?= htmlspecialchars($subtask['expirationDate']) ?></div>
                            <div><?= htmlspecialchars($subtask['comment']) ?></div>
                            <div><?= htmlspecialchars($subtask['responsibleNickname']) ?></div>
                            <div class="row--actions" onclick="event.stopPropagation()">
                                <a href="/subtasks/editar/<?= $subtask['id'] ?>">✏️</a>
                                <a href="/subtasks/eliminar/<?= $subtask['id'] ?>">❌</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </section>
    </main>
</body>

</html>