<?php
session_start();

require_once 'php/config.php';

if (isset($_SESSION['valid'])) {
    header("Location: home.php");
    exit;
}

$error_message = '';

if (isset($_POST['submit'])) {

    $login = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $stmt = $con->prepare("SELECT * FROM users WHERE Email = ? OR Username = ?");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['Password'])) {

            $_SESSION['valid'] = $row['Email'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['age'] = $row['Age'];
            $_SESSION['id'] = $row['Id'];

            header("Location: home.php");
            exit;
        } else {

            $error_message = 'Wrong Username or Password';
        }
    } else {

        $error_message = 'Wrong Username or Password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
</head>
<body>
    <div class="nav1">
        <div class="logo">
            <a href="home.php">
                <img src="assets/taxi.png" alt="Movers Logo">
            </a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <header>Login</header>
            <?php if ($error_message) : ?>
                <div class="message">
                    <p><?= $error_message ?></p>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email or Username</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    <a href="register.php">Sign Up Now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>