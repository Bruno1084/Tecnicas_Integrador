<!DOCTYPE html>
<html lang="es">

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
            <h1>Compartir Tarea</h1>

            <div class="taskForm--container">
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger"><?= session('error') ?></div>
                <?php endif; ?>

                <form action="/tasks/share/" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="idTask">Seleccionar Tarea:</label>
                        <select name="idTask" id="idTask" required>
                            <option value="">-- Elegir Tarea --</option>
                            <?php foreach ($tasks as $task): ?>
                                <option value="<?= esc($task['id']) ?>">
                                    <?= esc($task['subject']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="userEmail">Invitar a Usuario:</label>
                        <input type="email" name="userEmail" id="userEmail" placeholder="usuario@email.com" required>
                    </div>

                    <div class="form-group">
                        <label for="priority">Puede Editar</label>
                        <select name="priority" id="priority" required>
                            <option value="false">No</option>
                            <option value="true">Si</option>
                        </select>
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