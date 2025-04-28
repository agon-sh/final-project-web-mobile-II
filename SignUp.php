<!DOCTYPE html>
<html>
<head>
<title>Sign Up</title>
<style>
.container {
    width: 400px;
    margin: 100px auto;
    padding: 30px;
    background-color: #f4f4f4;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
input[type="text"], input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0 20px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}
button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
}
button:hover {
    background-color: #45a049;
}
</style>
</head>
<body>

<div class="container">
    <h2>Sign Up</h2>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="staff_code">Staff Code (only if registering as staff):</label>
        <input type="text" id="staff_code" name="staff_code" placeholder="Leave empty if client">

        <button type="submit">Register</button>
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "webmobile", "RITK2025", "webmobile");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $staff_code = $_POST['staff_code'];

    // Check if the username already exists
    $checkStmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "<p style='color:red; text-align:center;'>Username already taken.</p>";
    } else {
        // Determine the role
        $role = "client";
        if (!empty($staff_code) && $staff_code === "Kombinati") {
            $role = "staff";
        }

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);

        if ($stmt->execute()) {
            echo "<p style='color:green; text-align:center;'>Registration successful! You can now <a href='login.php'>Login</a>.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>Error during registration. Please try again.</p>";
        }
        $stmt->close();
    }
    $checkStmt->close();
    $conn->close();
}
?>

</body>
</html>
