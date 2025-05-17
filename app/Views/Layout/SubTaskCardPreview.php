<a href="<?= base_url('subtasks/' . $idSubTask) ?>" class="subTaskCardPreview--container">
    <div class="subTaskCardPreview-header--container">
        <div class="subTaskCardPreview-header-left">
            <img src="/img/person-circle.svg" alt="icon">
            <p><?= esc($nickname) ?></p>
        </div>
        <div class="subTaskCardPreview-header-right">
            <p><?= esc($priority) ?></p>
        </div>
    </div>
    <div class="subTaskCardPreview-body--container">
        <p><?= esc($subject) ?></p>
        <p><?= esc($description) ?></p>
    </div>
</a>
