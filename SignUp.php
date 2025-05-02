<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empire Estate Sign Up</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('images/bg_signup.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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
    session_start();

    $conn = mysqli_connect("localhost", "root", "", "empire_living");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Check if username already exists
        $check_username = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

        // confirms username is taken
        if (mysqli_num_rows($check_username) > 0) {
            $error = "Username already taken.";
        } else {

            // Since username isnt taken, check if email is taken
            $check_email = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
            if (mysqli_num_rows($check_email) > 0) {
                // Confirms username is taken
                $error = "Email already registered.";
            } else {
                // Email and user isnt taken. make account
                $insert = mysqli_query($conn, "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')");
                if ($insert) {
                    header("Location: sell.php");
                    exit();
                } else {
                    $error = "Could not create account. Please try again.";
                }
            }
        }

        mysqli_close($conn);
    }
    ?>

    <div class="container">
        <h2>Sign Up</h2>
        <?php if (!empty($error))
            echo "<div class='error'>$error</div>"; ?>
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
</body>

</html>
<!--Made by: Dion Hajrullahu. I declare that this code is written by me and not by ai or any other software service mentioned in the guidelines.-->