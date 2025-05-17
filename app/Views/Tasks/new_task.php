<?= view('layout/header', ['styles' => [
    'header.css',
    'taskCard.css'
]]) ?>

<main class="taskCard-main">
    <section>
        <form action="/tasks" method="post">
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger"><?= session('error') ?></div>
            <?php endif; ?>

            <?php if (session()->has('errors')): ?>
                <ul class="alert alert-danger">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <section class="taskCard--container">
                <div class="taskCard-task-col taskCard-col1">
                    <h2>Create New Task</h2>

                    <div class="taskCard-task-header">
                        <p><strong>Subject</strong></p>
                        <input type="text" name="subject" id="subject" required>
                    </div>
                    <div class="taskCard-task-body">
                        <p><strong>Description</strong></p>
                        <textarea name="description" id="description" rows="3" cols="60" required></textarea>
                    </div>
                </div>

                <div class="taskCard-task-col taskCard-col2">
                    <div>
                        <p><strong>Priority</strong></p>
                        <select name="priority" id="priority" required>
                            <option value="alta">Alta</option>
                            <option value="media">Media</option>
                            <option value="baja">Baja</option>
                        </select>
                    </div>
                    <div>
                        <p><strong>Expiration Date</strong></p>
                        <input type="date" name="expirationDate" id="expirationDate" required>
                    </div>
                    <div>
                        <p><strong>Reminder Date</strong></p>
                        <input type="date" name="reminderDate" id="reminderDate">
                    </div>
                    <div>
                        <input type="submit" value="Create Task">
                    </div>
                </div>
            </section>
        </form>
    </section>
</main>

<?= view('layout/footer') ?>