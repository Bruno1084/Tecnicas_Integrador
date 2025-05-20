<header>
    <div>
        <a href="/tasks">Manejador de Tareas</a>
    </div>
    <div class="headerNav--container">
        <nav>
            <?php
            $session = session();
            $userLogged = $session->get('userId')
            ?>
            <a href="/users/<?= $userLogged ?>">Perfil</a>
            <a href="/log_out">Cerrar Sesión</a>
        </nav>
    </div>
</header>