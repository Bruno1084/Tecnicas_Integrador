<?= view('layout/header', ['styles' => [
    'header.css',
    'user.css',
]]) ?>

<h2>User Profile</h2>
<main>
    <h3>User Details</h3>
    <form action="/users" method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?= $user['name'] ?>">
        </div>
        <div>
            <label for="nickname">Nickname:</label>
            <input type="text" name="nickname" id="nickname" value="<?= $user['nickname'] ?>">
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?= $user['email'] ?>">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="text" name="password" id="password" value="<?= $user['password'] ?>">
        </div>
        <input type="submit" value="Edit profile">
    </form>
</main>

<?= view('layout/footer') ?>