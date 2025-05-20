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
            <h1>Detalle de Usuario</h1>

            <div class="taskForm--container">
                <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger"><?= session('error') ?></div>
                <?php endif; ?>

                <form action="/users/update/<?= $user['id'] ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" value="<?= $user['name'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nickname">Nickname</label>
                        <input type="text" id="nickname" name="nickname" value="<?= $user['nickname'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="text" id="email" name="email" value="<?= $user['email'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" value="<?= $user['password'] ?>">
                    </div>

                    <div class="form-actions">
                        <button type="submit">Editar</button>
                        <a href="/tasks" class="cancel-button">Cancelar</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>

</html>