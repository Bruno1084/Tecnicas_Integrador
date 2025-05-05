<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/header.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/newTask.css') ?>">
    <title>Task Manager</title>
</head>

<body>
    <header>
        <div>
            <h1>Task Manager</h1>
        </div>
        <div>
            <nav>
                <a href="#">Link1</a>
                <a href="#">Link2</a>
                <a href="#">Link3</a>
            </nav>
        </div>
    </header>

    <main>
        <h2>Create New Task</h2>
        <div class="form--container">
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
                    <input type="text" name="priority" id="priority">
                </div>
                <div class="form-box">
                    <p>State</p>
                    <input type="text" name="state" id="state">
                </div>
                <div class="form-box">
                    <p>Reminder Date</p>
                    <input type="date" name="reminderDate" id="reminderDate">
                </div>
                <div class="form-box">
                    <p>Expiration Date</p>
                    <input type="date" name="expirationDate" id="expirationDate">
                </div>
                <div class="form-box">
                    <p>Color</p>
                    <select name="color" id="color">
                        <option value="verde">Green</option>
                        <option value="rojo">Red</option>
                        <option value="azul">Blue</option>
                    </select>
                </div>
                <div class="form-box">
                    <input type="submit" value="Create Task">
                </div>
            </form>
        </div>
    </main>
</body>

</html>