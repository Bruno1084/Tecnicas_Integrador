<div class="taskCard--container">
    <a href="<?= base_url('tasks/'. $id .'/subtasks')?>">
        <p><strong>Subject:</strong> <?= $subject ?></p>
        <p><strong>Description:</strong> <?= $description ?></p>
        <p><strong>Priority:</strong> <?= $priority ?></p>
        <p><strong>State:</strong> <?= $state ?></p>
        <p><strong>Reminder Date:</strong> <?= $reminderDate ?></p>
        <p><strong>Expiration Date:</strong> <?= $expirationDate ?></p>
        <p><strong>Color:</strong> <?= $color ?></p>
    </a>
</div>