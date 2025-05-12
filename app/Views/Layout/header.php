<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>

    <?php foreach ($styles ?? [] as $style): ?>
        <link rel="stylesheet" href="<?= base_url("css/" . $style) ?>">
    <?php endforeach; ?>
</head>

<body>
    <?php
    //Require the user nickname to create a dynamic url
    $session = session();
    $userModel = new \App\Models\UserModel();
    $currentUser = $userModel->find($session->get('userId'));
    ?>

    <header>
        <div>
            <h1>Task Manager</h1>
        </div>
        <div class="headerNav--container">
            <nav>
                <a href="/users/<?= $currentUser['nickname']?>">Profile</a>
                <a href="/log_out">Log out</a>
                <a href="#">Notifications</a>
            </nav>
        </div>
    </header>