 <?php
    session_start();

    // Checking if the user is already logged in.
    if (isset($_SESSION['username'])) {
        // Determine redirect based on role if logged in
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'staff') {
            header("Location: staff_dashboard.php");
        } else {
            header("Location: home.php");
        }
        exit();
    }

    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "empire_living");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $error = "";

    // Remember me
    if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
        $username = $_COOKIE['username'];
        $password = $_COOKIE['password'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Fetching password and role using prepared statement for sql injection protection
        $stmt = mysqli_prepare($conn, "SELECT password, role FROM user WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $dbPassword = $row['password'];
            $userRole = $row['role']; // Geting the role

            if ($password === $dbPassword) {
                $_SESSION["username"] = $username;
                $_SESSION["role"] = $userRole; // Storing role in session

                if (isset($_POST['remember_me'])) {
                    setcookie("username", $username, time() + (86400 * 30), "/");
                    setcookie("password", $password, time() + (86400 * 30), "/");
                }

                // Redirect based on role
                if ($userRole === 'staff') {
                    header("Location: staff_dashboard.php");
                } else {
                    header("Location: home.php");
                }
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }
        mysqli_stmt_close($stmt); // Closing the prepared statement
        mysqli_close($conn); // Closing the database connection
    }

    // Including the header file
    include('header.php');
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empire Living | Login</title>
    <link rel="icon" href="images/EmpireLivingLogo-Transparent.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: url('images/bg_signup.jpg') no-repeat center center/cover;
            margin: 0;
            padding: 0;
        }

        .login-section {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 60px);
            padding-top: 60px;
            overflow: hidden;
        }

        .container {
            background: white;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 420px;
            text-align: center;
        }

        .container h2 {
            margin-bottom: 20px;
            font-size: 32px;
            color: #1D2731;
            font-family: "Playfair Display", serif;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            text-align: left;
            margin-bottom: 6px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        input[type="checkbox"] {
            margin-right: 8px;
        }

        .remember {
            font-size: 0.9em;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            color: #333;
        }

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: #004d99;
        }

        .signup-button {
            width: 100%;
            padding: 12px;
            background-color: #FFFFFF;
            border: none;
            color: grey;
            text-decoration: underline;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .signup-link {
            margin-top: 20px;
            font-size: 14px;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <section class="login-section">
        <div class="container">
            <h2>Login</h2>
            <?php if (!empty($error))
                echo "<div class='error'>$error</div>"; ?>
            <form method="post" action="">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <div class="remember">
                    <input type="checkbox" name="remember_me" id="remember_me">
                    <label for="remember_me">Remember Me</label>
                </div>

                <input type="submit" value="Login">
            </form>

            <div class="signup-link">
                <a href="sign_up.php"><button class="signup-button">Sign Up</button></a>
            </div>
        </div>
    </section>
</body>
</html>
<!--Made by: Dion Hajrullahu. I declare that this code is written by me and not by ai or any other software service mentioned in the guidelines.-->
