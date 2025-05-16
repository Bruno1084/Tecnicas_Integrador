<div class="taskFilter--container">
    <form action="/tasks" method="get">
        <input type="text" name="subject" placeholder="Task subject">
        <select name="priority">
            <option value="">-- Priority --</option>
            <option value="alta">Alta</option>
            <option value="media">Media</option>
            <option value="baja">Baja</option>
        </select>
        <input type="date" name="expirationDate" id="expirationDate">
        <button type="submit">Filter</button>
    </form>
</div>