<?= view('layout/header', ['styles' => [
    'header.css',
    'taskCard.css',
    'subTaskCardPreview.css',
]]) ?>

<?php
$color = '';
switch ($task['priority']) {
    case 'baja':
        $color = '#9FF4CF';
        break;
    case 'media':
        $color = '#A4E3FA';
        break;
    case 'alta':
        $color = '#FFB6B9';
        break;
    default:
        $color = "white";
}
?>

<main class="taskCard-main">




    <form action="<?= site_url('/tasks/update/' . $task['id']) ?>" method="post">
        <!-- If there is an error inputs, returns exception messages -->
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger"><?= session('error') ?></div>
        <?php endif; ?>

        <style>
            .taskCard--container {
                border-left: 10px solid <?= $color ?>;
            }
        </style>

        <section class="taskCard--container">
            <div class="taskCard-task-col taskCard-col1">
                <div class="taskCard-task-header">
                    <input type="text" name="subject" id="subject" value="<?= esc($task['subject']) ?>" required>
                </div>
                <div class="taskCard-task-body">
                    <p><strong>Description</strong></p>
                    <textarea name="description" id="description" rows="3" cols="60" required><?= esc($task['description']) ?></textarea>
                </div>

                <!-- SubtasksCard preview list -->
                <div class="taskCard-subtaskList">
                    <?php if (empty($subTasks)): ?>
                        <p>No hay subtareas disponibles.</p>
                    <?php else: ?>
                        <?php foreach ($subTasks as $subtask): ?>
                            <?= view('layout/SubTaskCardPreview', [
                                'idTask' => $task['id'],
                                'idSubTask' => $subtask['id'],
                                'nickname' => $responsible['nickname'],
                                'priority' => $subtask['priority'],
                                'subject' => $subtask['subject'],
                                'description' => $subtask['description'],
                            ]) ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="taskCard-task-col taskCard-col2">
                <div>
                    <p><strong>State</strong></p>
                    <select name="state" id="state" required>
                        <option value="no iniciada" <?= $task['state'] == 'no iniciada' ? 'selected' : '' ?>>No iniciada</option>
                        <option value="en proceso" <?= $task['state'] == 'en proceso' ? 'selected' : '' ?>>En proceso</option>
                        <option value="completada" <?= $task['state'] == 'completada' ? 'selected' : '' ?>>Completada</option>
                    </select>
                </div>
                <div>
                    <p><strong>Priority</strong></p>
                    <select name="priority" id="priority" required>
                        <option value="baja" <?= $task['priority'] == 'baja' ? 'selected' : '' ?>>Baja</option>
                        <option value="media" <?= $task['priority'] == 'media' ? 'selected' : '' ?>>Media</option>
                        <option value="alta" <?= $task['priority'] == 'alta' ? 'selected' : '' ?>>Alta</option>
                    </select>
                </div>
                <div>
                    <p><strong>Expiration Date</strong></p>
                    <input type="date" name="expirationDate" value="<?= esc($task['expirationDate']) ?>" required>
                </div>
                <div>
                    <p><strong>Reminder Date</strong></p>
                    <input type="date" name="reminderDate" value="<?= esc($task['reminderDate']) ?>">
                </div>
                <div>
                    <input type="submit" value="Guardar cambios">
                </div>
            </div>
        </section>
    </form>

</main>

<?= view('layout/footer') ?>