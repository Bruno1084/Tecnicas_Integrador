<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('css/signUp.css') ?>">
    <title>Tasks Manager</title>
</head>

<body>

    <main>
        <form action="/sign_up" method="post" id="signUp--container">
            <div class="signUp-header--container signUp-box">
                <h3 class="signUp-header">Sign Up</h3>
            </div>
            <div class="signUp-body--container">
                <div class="signUp-name--container signUp-box">
                    <p>Name</p>
                    <input type="text" name="name" id="name">
                </div>
                <div class="signUp-nickname--container signUp-box">
                    <p>Nickname</p>
                    <input type="text" name="nickname" id="nickname">
                </div>
                <div class="signUp-email--container signUp-box">
                    <p>Email</p>
                    <input type="text" name="email" id="email">
                </div>
                <div class="signUp-password--container signUp-box">
                    <p>Password</p>
                    <input type="text" name="password" id="password">
                </div>
                <div class="signUp-button--container signUp-box">
                    <input type="submit" value="Submit">
                </div>
            </div>
        </form>
    </main>
</body>

</html>