<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/tareaFormCreate.css">
    <title>Manejador de Tareas</title>
</head>

<body>
    <?= view('Layout/header.php'); ?>

    <main>
        <?= view('Layout/sideBar.php'); ?>

        <section>
            <h1>Editar Subtarea</h1>

            <div class="taskForm--container">
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger"><?= session('error') ?></div>
                <?php endif; ?>

                <form action="/subtasks/update/<?= $subtask['id'] ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="subject">Título</label>
                        <input type="text" id="subject" name="subject" value="<?= $subtask['subject'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <input type="text" id="description" name="description" value="<?= $subtask['description'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="comment">Comentario</label>
                        <input type="text" id="comment" name="comment">
                    </div>

                    <div class="form-group">
                        <label for="priority">Prioridad</label>
                        <select name="priority" id="priority" required>
                            <option value="alta" <?= $subtask['priority'] === 'alta' ? 'selected' : '' ?>>Alta</option>
                            <option value="media" <?= $subtask['priority'] === 'media' ? 'selected' : '' ?>>Media</option>
                            <option value="baja" <?= $subtask['priority'] === 'baja' ? 'selected' : '' ?>>Baja</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="state">Estado</label>
                        <select name="state" id="state" required>
                            <option value="no iniciada" <?= $subtask['state'] === 'no iniciada' ? 'selected' : '' ?>>No Iniciada</option>
                            <option value="en proceso" <?= $subtask['state'] === 'en proceso' ? 'selected' : '' ?>>En Proceso</option>
                            <option value="completada" <?= $subtask['state'] === 'completada' ? 'selected' : '' ?>>Completada</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="expirationDate">Fecha de Vencimiento</label>
                        <input type="date" name="expirationDate" id="expirationDate" value="<?= $subtask['expirationDate'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="reminderDate">Fecha de Recordatorio</label>
                        <input type="date" name="reminderDate" id="reminderDate" value="<?= $subtask['reminderDate'] ?>">
                    </div>

                    <div class="form-actions">
                        <button type="submit">Crear</button>
                        <a href="/subtasks" class="cancel-button">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>

</html>