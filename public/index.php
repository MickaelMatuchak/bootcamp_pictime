<?php
session_start();

// Si l'utilisateur est connecté on le redirige
if (isset($_SESSION['email'])) {
    header('Location: account.php');
}
?>

<html>
    <head>
        <title>PiCraft</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
              integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous" />
        <link rel="stylesheet" href="css/styles.css" />
    </head>
    <body>
        <h1>Duel PiCraft</h1>

        <hr>

        <h2>Register now</h2>
        <form action="user/register.php" method="post">
            <div class="form-group">
                <label for="register-email">Email</label>
                <input type="email" placeholder="your-email.com" name="email" class="form-control" id="register-email" />
            </div>
            <div class="form-group">
                <label for="register-password">Password</label>
                <input type="password" placeholder="password" name="password" class="form-control" id="register-password" />
            </div>
            <div class="form-group">
                <label for="register-retype-password">Retype password</label>
                <input type="password" placeholder="retype password" name="retype-password" class="form-control" id="register-retype-password" />
            </div>
            <input type="submit" class="btn btn-primary" value="Ok" />
        </form>

        <hr>

        <h2>I have already an account</h2>
        <form action="user/login.php" method="post">
            <div class="form-group">
                <label for="login-email">Email</label>
                <input type="email" placeholder="your-email.com" name="email" class="form-control" id="login-email" />
            </div>
            <div class="form-group">
                <label for="login-password">Password</label>
                <input type="password" placeholder="password" name="password" class="form-control" id="login-password" />
            </div>
            <input type="submit" class="btn btn-primary" value="Ok" />
        </form>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    </body>
</html>
