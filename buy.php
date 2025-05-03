<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "empire_living");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    header("Location: browse.php");
    exit();
}

$property_id = $_GET['id'];
$property_result = mysqli_query($conn, "SELECT * FROM property WHERE property_id = $property_id");
$property = mysqli_fetch_assoc($property_result);

if (!$property) {
    header("Location: browse.php");
    exit();
}

$username = $_SESSION['username'];
$user_result = mysqli_query($conn, "SELECT user_id FROM user WHERE username = '$username'");
$user = mysqli_fetch_assoc($user_result);
$user_id = $user['user_id'];

if ($property['user_id'] == $user_id) {
    header("Location: browse.php");
    exit();
}

$agents_result = mysqli_query($conn, "SELECT * FROM agent");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $agent_id = $_POST['agent_id'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];

    $insert = "INSERT INTO appointment (user_id, property_id, agent_id, appointment_date, appointment_time) 
               VALUES ('$user_id', '$property_id', '$agent_id', '$date', '$time')";
    mysqli_query($conn, $insert);
    header("Location: home.php");
    exit();
}

include('header.php');
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Empire Living | Book Appointment</title>
    <link rel="icon" href="images/EmpireLivingLogo-Transparent.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F3F0F1;
            display: flex;
            justify-content: center;
        }

        .book-container {
            max-width: 1000px;
            margin: 120px auto 40px auto; /* top, right, bottom, left */
            display: flex;
            gap: 40px;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        .left {
            width: 50%;
        }

        .left img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .left h2 {
            font-family: "Playfair Display", serif;
            font-size: 28px;
            color: #1D2731;
            margin-bottom: 10px;
        }

        .left p {
            font-size: 16px;
            color: #3C4A57;
            margin-bottom: 6px;
        }

        .right {
            width: 50%;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            color: #333;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
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

        button:hover {
            background-color: #004d99;
        }
    </style>
</head>

<body>
    <div class="book-container">
        <div class="left">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($property['image']); ?>" alt="Property Image">
            <h2><?php echo htmlspecialchars($property['title']); ?></h2>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($property['location']); ?></p>
            <p><strong>Price:</strong> $<?php echo number_format($property['cost']); ?></p>
            <p><strong>Size:</strong> <?php echo $property['square_feet']; ?> sqft</p>
            <p><strong>Bedrooms:</strong> <?php echo $property['bedrooms']; ?></p>
            <p><strong>Bathrooms:</strong> <?php echo $property['bathrooms']; ?></p>
            <p><strong>Description:</strong><br><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
        </div>

        <div class="right">
            <form method="POST">
                <label for="agent_id">Select Agent</label>
                
                <select name="agent_id" required>
                    <option value="">--</option>
                    <?php while ($agent = mysqli_fetch_assoc($agents_result)) : ?>
                        <option value="<?php echo $agent['agent_id']; ?>">
                            <?php echo $agent['first_name'] . ' ' . $agent['last_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <!-- date selector. Minimum date is today's date -->
                <label for="appointment_date">Appointment Date</label>
                <input type="date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" required>

                <!-- time selector. Time range is from 9-5 -->
                <label for="appointment_time">Appointment Time</label>
                <input type="time" name="appointment_time" min="09:00" max="17:00" required>

                <button type="submit">Book Appointment</button>
            </form>
        </div>
    </div>
</body>

</html>
