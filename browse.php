<?php
$conn = mysqli_connect("localhost", "root", "", "empire_living");
$result = mysqli_query($conn, "SELECT title, cost, square_feet, bedrooms, bathrooms, image FROM property");
?>

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
    <title>Empire Estate Sign Up</title>

    <header id="home">
        <div class="logo">
            <img src="images/EmpireLivingLogo-TransparentWhite.png" alt="Empire Living Logo">
            EMPIRE LIVING
        </div>
        <div class="side_buttons">
            <a href="home.html">Home</a>
            <a href="#">Rent</a>
            <a href="sell.php">Sell</a>

            <a href="logout.php">Logout</a>
        </div>
    </header>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;

            justify-content: center;
        }





        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            color: #333;
        }

        input {
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

        a button:hover {
            background-color: #004d99;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
            background-color: #5B6C7B;
        }

        /* Header */
        header {
            color: white;
            background-color: black;
            font-size: 24px;
            position: absolute;
            width: 100%;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: "Montserrat", sans-serif;
            font-weight: 600;
            z-index: 10;

        }

        header .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            color: white;
        }

        header .logo img {
            height: 40px;
            width: 40px;
            margin-right: 10px;
        }

        header .side_buttons {
            display: flex;
            align-items: center;
            height: 100%;
        }

        header .side_buttons a {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 0 20px;
            text-decoration: none;
            color: white;
            transition: background-color 0.3s ease, color 0.3s ease;
            cursor: pointer;
        }

        header .side_buttons a:hover {
            background-color: white;
            color: black;
        }

        .submit:hover {
            background-color: #0012;
            cursor: pointer;
        }

        .properties-container {
            margin-top: 50px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            /* distributes space evenly */
            gap: 30px;
            /* gap between rows */
            padding: 40px 20px;
        }

        .property-card {
            flex: 0 0 35%;
            /* 35% of the screen width */
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
        }


        .property-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
        }

        .property-info {
            margin-top: 15px;
        }

        .property-info h3 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .property-info p {
            margin: 4px 0;
            font-size: 14px;
        }

        @media (max-width: 900px) {
            .property-card {
                flex: 0 0 90%;
                /* nearly full width on mobile */
            }
        }
    </style>



<body>

    <header id="home">
        <div class="logo">
            <img src="images/EmpireLivingLogo-TransparentWhite.png" alt="Empire Living Logo">
            EMPIRE LIVING
        </div>
        <div class="side_buttons">
            <a href="#">Home</a>
            <a href="#">Rent</a>
            <a href="sell.php">Sell</a>
            <a href="#">Register / Sign In</a>
        </div>
    </header>

    <div class="properties-container">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="property-card">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" alt="Property Image">
                <br>
                <div class="property-info">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><strong>Price:</strong> $<?php echo number_format($row['cost']); ?></p>
                    <p><strong>Size:</strong> <?php echo $row['square_feet']; ?> sqft</p>
                    <p><strong>Bedrooms:</strong> <?php echo $row['bedrooms']; ?></p>
                    <p><strong>Bathrooms:</strong> <?php echo $row['bathrooms']; ?></p>
                </div>
            </div><br>

        <?php endwhile; ?>
    </div>
    <br>

</body>

</html>