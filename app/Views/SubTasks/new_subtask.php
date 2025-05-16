<?= view('layout/header', ['styles' => [
    'header.css',
    'taskCard.css',
]]) ?>

<main class="taskCard-main">

    <section>
        <form action="/subtasks/create" method="post">
            <!-- If there is an error inputs, returns exception messages -->
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif; ?>

            <input type="hidden" name="idTask" value="<?= esc($idTask) ?>">
            <section class="taskCard--container">
                <div class="taskCard-task-col taskCard-col1">
                    <h2>New Subtask</h2>

                    <div class="taskCard-task-header">
                        <p><strong>Subject</strong></p>
                        <input type="text" name="subject" id="subject" required>
                    </div>
                    <div class="taskCard-task-body">
                        <p><strong>Description</strong></p>
                        <textarea name="description" id="description" rows="3" cols="60" required></textarea>
                    </div>
                    <div class="taskCard-task-body">
                        <p><strong>Comment</strong></p>
                        <textarea name="comment" id="comment" rows="3" cols="60" required></textarea>
                    </div>
                </div>

                <div class="taskCard-task-col taskCard-col2">
 
                    <div>
                        <p><strong>Priority</strong></p>
                        <select name="priority" id="priority" required>
                            <option value="baja">Baja</option>
                            <option value="media">Media</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>
                    <div>
                        <p><strong>Expiration Date</strong></p>
                        <input type="date" name="expirationDate" required>
                    </div>
                    <div>
                        <p><strong>Reminder Date</strong></p>
                        <input type="date" name="reminderDate">
                    </div>
                    <div>
                        <input type="submit" value="Crear subtask">
                    </div>
                </div>
            </section>
        </form>
    </section>
</main>

<?= view('layout/footer') ?>