<?= view('layout/header', ['styles' => [
    'header.css',
    'newTask.css',
]]) ?>

<main>
    <h2>Create New Task</h2>
    <div class="form--container">
        <!-- If there is an error inputs, returns exception messages -->
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
        <form action="/tasks" method="post">
            <div class="form-box">
                <p>Subject</p>
                <input type="text" name="subject" id="subject">
            </div>
            <div class="form-box">
                <p>Description</p>
                <input type="text" name="description" id="description">
            </div>
            <div class="form-box">
                <p>Priority</p>
                <select name="priority" id="priority">
                    <option value="alta">Alta</option>
                    <option value="media">Media</option>
                    <option value="baja">Baja</option>

                </select>
            </div>
            <div class="form-box">
                <p>Expiration Date</p>
                <input type="date" name="expirationDate" id="expirationDate">
            </div>
            <div class="form-box">
                <p>Reminder Date</p>
                <input type="date" name="reminderDate" id="reminderDate">
            </div>

            <div class="form-box">
                <input type="submit" value="Create Task">
            </div>
        </form>
    </div>
</main>

<?= view('layout/footer') ?>