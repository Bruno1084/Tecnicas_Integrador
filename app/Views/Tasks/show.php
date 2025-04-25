<?= view('layout/header', ['title' => 'Show Task']) ?>
<h2>Detalle de la tarea</h2>

<p><strong>Asunto:</strong> <?= $task['subject'] ?></p>
<p><strong>Descripción:</strong> <?= $task['description'] ?></p>

<h3>Subtareas</h3>
<?php if (empty($subTasks)): ?>
    <p>No hay subtareas.</p>
<?php else: ?>
    <ul>
        <?php foreach ($subTasks as $sub): ?>
            <li><?= $sub['title'] ?> - <?= $sub['status'] ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?= view('layout/footer') ?>