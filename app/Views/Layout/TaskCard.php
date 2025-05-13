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

    // case 'purple':
    //     $color = '#DBBAFE';
    //     break;
    default:
        $color = "white";
}
?>

<style>
    .taskCard--container {
        border-left: 10px solid <?= $color ?>;
    }
</style>

<section class="taskCard--container">
    <div class="taskCard-task-col taskCard-col1">
        <div class="taskCard-task-header">
            <input type="text" name="subject" id="subject" value="<?= $task['subject'] ?>">
        </div>
        <div class="taskCard-task-body">
            <p><strong>Description</strong></p>
            <textarea name="description" id="subject" rows="3" cols="60"><?= $task['description'] ?></textarea>
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
            <select name="state" id="state">
                <option value="no iniciada">No iniciada</option>
                <option value="en proceso">En proceso</option>
                <option value="completada">Completada</option>
            </select>
        </div>
        <div>
            <p><strong>Priority</strong></p>
            <p><?= $task['priority'] ?></p>
            <select name="priority" id="priority">
                <option value="alta">Baja</option>
                <option value="media">Media</option>
                <option value=""></option>
            </select>
        </div>
        <div>
            <p><strong>Expiration Date</strong></p>
            <p><?= $task['expirationDate'] ?></p>
        </div>
        <div>
            <p><strong>Reminder Date</strong></p>
            <p><?= $task['reminderDate'] ?></p>
        </div>
        <div>
            <button>New Subtask</button>
            <button>Edit Task</button>
        </div>
    </div>


</section>