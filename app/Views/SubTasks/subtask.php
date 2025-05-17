<?= view('layout/header', ['styles' => [
    'header.css',
    'subTaskCard.css',
]]) ?>

<main class="subTaskCard-main">
    <form action="<?= site_url('/subtasks/update/' . $subtask['id']) ?>" method="post">
        <?php if (session()->has('error')): ?>
            <div class="alert alert-danger"><?= session('error') ?></div>
        <?php endif; ?>

        <section class="subTaskCard--container">

            <input type="hidden" name="idTask" value="<?= esc($subtask['idTask']) ?>">
            <div class="subTaskCard-task-col subTaskCard-col1">
                <div class="subTaskCard-task-header">
                    <input type="text" name="subject" id="subject" value="<?= esc($subtask['subject']) ?>" required>
                </div>
                <div class="subTaskCard-task-body">
                    <div class="subTaskCard-task-description">
                        <p><strong>Description</strong></p>
                        <textarea name="description" rows="3" cols="60" required><?= esc($subtask['description']) ?></textarea>
                    </div>
                    <div class="subTaskCard-task-commentary">
                        <p><strong>Comment</strong></p>
                        <textarea name="comment" rows="3" cols="60" required><?= esc($subtask['comment']) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="subTaskCard-task-col subTaskCard-col2">
                <div>
                    <p><strong>State</strong></p>
                    <select name="state" id="state" required>
                        <option value="no iniciada" <?= $subtask['state'] == 'no iniciada' ? 'selected' : '' ?>>No iniciada</option>
                        <option value="en proceso" <?= $subtask['state'] == 'en proceso' ? 'selected' : '' ?>>En proceso</option>
                        <option value="completada" <?= $subtask['state'] == 'completada' ? 'selected' : '' ?>>Completada</option>
                    </select>
                </div>
                <div>
                    <p><strong>Priority</strong></p>
                    <select name="priority" id="priority" required>
                        <option value="baja" <?= $subtask['priority'] == 'baja' ? 'selected' : '' ?>>Baja</option>
                        <option value="media" <?= $subtask['priority'] == 'media' ? 'selected' : '' ?>>Media</option>
                        <option value="alta" <?= $subtask['priority'] == 'alta' ? 'selected' : '' ?>>Alta</option>
                    </select>
                </div>
                <div>
                    <p><strong>Expiration Date</strong></p>
                    <input type="date" name="expirationDate" value="<?= esc($subtask['expirationDate']) ?>" required>
                </div>
                <div>
                    <p><strong>Reminder Date</strong></p>
                    <input type="date" name="reminderDate" value="<?= esc($subtask['reminderDate']) ?>">
                </div>
                <div>
                    <input type="submit" value="Edit Subtask">
                    
                </div>
            </div>
        </section>
    </form>

</main>

<?= view('layout/footer') ?>