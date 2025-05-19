<div class="taskFilter--container">
    <form action="/subtasks" method="get">
        <input type="text" name="subject" placeholder="Task subject" value="<?= esc($_GET['subject'] ?? '') ?>">

        <select name="priority">
            <option value="">-- Priority --</option>
            <option value="alta" <?= (($_GET['priority'] ?? '') === 'alta') ? 'selected' : '' ?>>Alta</option>
            <option value="media" <?= (($_GET['priority'] ?? '') === 'media') ? 'selected' : '' ?>>Media</option>
            <option value="baja" <?= (($_GET['priority'] ?? '') === 'baja') ? 'selected' : '' ?>>Baja</option>
        </select>

        <select name="state">
            <option value="">-- State --</option>
            <option value="no iniciada" <?= (($_GET['state'] ?? '') === 'no iniciada') ? 'selected' : '' ?>>No iniciada</option>
            <option value="en proceso" <?= (($_GET['state'] ?? '') === 'en proceso') ? 'selected' : '' ?>>En proceso</option>
            <option value="completada" <?= (($_GET['state'] ?? '') === 'completada') ? 'selected' : '' ?>>Completada</option>
        </select>

        <input type="date" name="expirationDate" value="<?= esc($_GET['expirationDate'] ?? '') ?>">

        <button type="submit">Filter</button>
    </form>
</div>