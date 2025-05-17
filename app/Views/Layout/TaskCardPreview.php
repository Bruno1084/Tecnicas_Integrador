<a href="<?= base_url('tasks/' . $id . '/subtasks') ?>" class="taskCardPreview--container">
    <div class="taskCardPreview-header--container">
        <div class="taskCardPreview-header-left">
            <img src="/img/person-circle.svg" alt="icon">
            <p><?= $nickname ?></p>
        </div>
        <div class="taskCardPreview-header-right">
            <p><?= $priority ?></p>
        </div>
    </div>
    <div class="taskCardPreview-body--container">
        <p><?= $subject ?></p>
        <p><?= $description ?></p>
    </div>
</a>