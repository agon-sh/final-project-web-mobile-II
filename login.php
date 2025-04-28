<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Real Estate Login</title>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(rgba(0, 0, 50, 0.7), rgba(0, 0, 50, 0.7)), 
                    url('https://images.unsplash.com/photo-1570129477492-45c003edd2be') no-repeat center center/cover;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .container {
        background-color: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.25);
        width: 350px;
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

    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
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
        background-color: #0066cc;
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

    .error {
        color: red;
        text-align: center;
        margin-bottom: 15px;
    }
</style>
</head>
<body>
<?php
session_start();

$conn = new mysqli("localhost", "webmobile", "RITK2025", "webmobile");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    $username = $_COOKIE['username'];
    $password = $_COOKIE['password'];  
}  

if (isset($_POST['remember_me'])) {
    setcookie('username', $username, time() + (86400 * 30), "/");
    setcookie('password', $password, time() + (86400 * 30), "/");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($dbPassword);
        $stmt->fetch();

        if ($password === $dbPassword) {
            $_SESSION["username"] = $username;
            header("Location: profile.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }

    $stmt->close();
}

$conn->close();
?>

<div class="container">
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
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
        <br>
    <p>Don't have an account? <a href="SignUp.php"><button type="button">Sign Up</button></a></p>

    </form>
</div>
</body>
</html>
