<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/login.css') ?>">
    <title>Tasks Manager</title>
</head>

<body>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <main>
        <div id="login--container">

            <form action="/log_in" method="post">
                <div class="login-header--container login-box">
                    <h3 class="login-header">Login</h3>
                </div>
                <div class="login-body--container">
                    <div class="login-email--container login-box">
                        <p>Email</p>
                        <input type="text" name="email" id="email">
                    </div>
                    <div class="login-password--container login-box">
                        <p>Password</p>
                        <input type="text" name="password" id="password">
                    </div>
                    <div class="login-button--container login-box">
                        <input type="submit" value="Submit">
                    </div>
                </div>
            </form>
            <div>
                <a href="<?= site_url('sign_up') ?>">Sign Up</a>
            </div>
        </div>


    </main>
</body>

</html>