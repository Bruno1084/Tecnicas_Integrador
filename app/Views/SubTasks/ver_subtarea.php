<!DOCTYPE html>
<html lang="en">

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
            <h1>Detalle de Subtarea</h1>

            <div class="options--container">
                <div>
                    <a href="/subtasks/crear">Añadir</a>
                </div>
                <div>
                    <a href="/subtasks/eliminar">Eliminar</a>
                </div>
            </div>

            <!-- Subtask List Table -->
            <section class="tableSubtask--container">
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
            </section>
        </section>
    </main>
</body>

</html>