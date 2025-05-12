<a href="<?= base_url('tasks/' . $idTask . '/subtasks/' . $idSubTask) ?>" class="subTaskCardPreview--container">
    <div class="subTaskCardPreview-header--container">
        <div class="subTaskCardPreview-header-left">
            <img src="#" alt="icon">
            <p><?= $nickname ?></p>
        </div>
        <div class="subTaskCardPreview-header-right">
            <p><?= $priority ?></p>
        </div>
    </div>
    <div class="subTaskCardPreview-body--container">
        <p><?= $subject ?></p>        
        <p><?= $description ?></p>
    </div>
</a>