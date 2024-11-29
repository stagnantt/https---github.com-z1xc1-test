<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
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
                    <?php 
            include("php/config.php");

            if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];
                $password = $_POST['password'];
                $lastname = $_POST['lastname'];
                $firstname = $_POST['firstname'];
                $mi = $_POST['mi'];

                $name = $firstname . ' ' . $mi . ' ' . $lastname;

                $username = filter_var($username, FILTER_SANITIZE_STRING);
                if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                    echo "Invalid username. Only alphanumeric characters and underscores are allowed.";
                    exit;
                }

                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "Invalid email address.";
                    exit;
                }

                if (strlen($age) < 1 || strlen($age) > 3) {
                    echo "Invalid age. Age must be between 1 and 3 digits.";
                    exit;
                }

                if (strlen($password) < 8) {
                    echo "Password must be at least 8 characters long.";
                    exit;
                }

                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                // Prepare a statement to verify if the email is already in use
                $verify_stmt = $con->prepare("SELECT Email FROM users WHERE Email=?");
                $verify_stmt->bind_param("s", $email);
                $verify_stmt->execute();
                $verify_result = $verify_stmt->get_result();

                if($verify_result->num_rows > 0) {
                    echo "<div class='message'>
                        <p>This email is used, Try another One Please!</p>
                    </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                } else {
                    // Prepare an insert statement to add the new user
                    $insert_stmt = $con->prepare("INSERT INTO users(Username, Name, Email, Age, Password) VALUES (?, ?, ?, ?, ?)");
                    $insert_stmt->bind_param("sssis", $username, $name, $email, $age, $password_hash);
                    $insert_stmt->execute();

                    echo "<div class='message'>
                        <p>Registration successfully!</p>
                    </div> <br>";
                    echo "<a href='index.php'><button class='btn'>Login Now</button>";
                }
            }else{
            ?>
            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="lastname">Lastname</label>
                    <input type="text" name="lastname" id="lastname" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="firstname">Firstname</label>
                    <input type="text" name="firstname" id="firstname" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="mi">M.I.</label>
                    <input type="text" name="mi" id="mi" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>
                <div class="links">
                    <a href="index.php">Sign In</a>
                </div>
            </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>