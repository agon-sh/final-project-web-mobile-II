<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/EmpireLivingLogo-Transparent.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Empire Living | Sign Up</title>
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: url('images/bg_signup.jpg') no-repeat center center/cover;
            margin: 0;
            padding: 0;
        }

        .signup-section {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 60px);
            padding-top: 60px;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
            width: 400px;
            max-width: 90%;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #003366;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .buttons input[type="submit"],
        .buttons a button {
            width: 100%;
            padding: 12px;
            background-color: rgb(10, 3, 58);
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .buttons input[type="submit"]:hover,
        .buttons a button:hover {
            background-color: #004d99;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        #back {
            background-color: white;
            color: grey;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php
        if (!isset($_SESSION['username'])) {
            // User's already logged in, so we log user out
            session_start();
            session_destroy();
        }

        session_start();
        $conn = mysqli_connect("localhost", "root", "", "empire_living");

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            // Check if username already exists
            $check_username = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
            if (mysqli_num_rows($check_username) > 0) {
                $error = "Username already taken.";
            } 
            else {
                // Check if email already exists
                $check_email = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
                if (mysqli_num_rows($check_email) > 0) {
                    $error = "Email already registered.";
                } 
                else {
                    // Create new user
                    mysqli_query($conn, "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')");

                    $_SESSION["username"] = $username;

                    if (isset($_POST['remember_me'])) {
                        setcookie("username", $username, time() + (86400 * 30), "/");
                        setcookie("password", $password, time() + (86400 * 30), "/");
                    }

                    header("Location: home.php");
                    exit();
                }
            }

            mysqli_close($conn);
        }

        include('header.php')
    ?>

    <section class="signup-section">
        <div class="container">
            <h2>Sign Up</h2>
            <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
            <form method="post" action="">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>

                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <div class="buttons">
                    <input type="submit" value="Sign Up">
                    <a href="login.php"><button type="button" id="back">Go Back</button></a>
                </div>
            </form>
        </div>
    </section>
</body>

</html>
<!--Made by: Dion Hajrullahu. I declare that this code is written by me and not by ai or any other software service mentioned in the guidelines.-->