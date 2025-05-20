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
            <h1>Editar Tarea</h1>

            <div class="taskForm--container">
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger"><?= session('error') ?></div>
                <?php endif; ?>

                <form action="/tasks/update/<?= $task['id'] ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="subject">Título</label>
                        <input type="text" id="subject" name="subject" value="<?= $task['subject'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <input type="text" id="description" name="description" value="<?= $task['description'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="priority">Prioridad</label>
                        <select name="priority" id="priority" required>
                            <option value="alta" <?= $task['priority'] === 'alta' ? 'selected' : '' ?>>Alta</option>
                            <option value="media" <?= $task['priority'] === 'media' ? 'selected' : '' ?>>Media</option>
                            <option value="baja" <?= $task['priority'] === 'baja' ? 'selected' : '' ?>>Baja</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="state">Estado</label>
                        <select name="state" id="state" required>
                            <option value="no iniciada" <?= $task['state'] === 'no iniciada' ? 'selected' : '' ?>>No Iniciada</option>
                            <option value="en proceso" <?= $task['state'] === 'en proceso' ? 'selected' : '' ?>>En Proceso</option>
                            <option value="completada" <?= $task['state'] === 'completada' ? 'selected' : '' ?>>Completada</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="expirationDate">Fecha de Vencimiento</label>
                        <input type="date" name="expirationDate" id="expirationDate" value="<?= $task['expirationDate'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="reminderDate">Fecha de Recordatorio</label>
                        <input type="date" name="reminderDate" id="reminderDate" value="<?= $task['reminderDate'] ?>">
                    </div>

                    <div class="form-actions">
                        <button type="submit">Crear</button>
                        <a href="/tasks" class="cancel-button">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>

</html>