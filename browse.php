<?php
$conn = mysqli_connect("localhost", "root", "", "empire_living");
$result = mysqli_query($conn, "SELECT property_id, title, cost, square_feet, bedrooms, bathrooms, location, image FROM property");
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

    <style>
        /* Reset & Base */
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
            background-color: white;
        }

        /* Header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
            background-color: black;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-family: "Montserrat", sans-serif;
            font-weight: 600;
            color: white;
            padding: 0 20px;
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

        /* Intro box thing */
        .browse_intro {
            margin-top: 60px; /* offset for fixed header */
            padding: 60px 20px 0px 20px; /* top, right, bottom, left */
            text-align: center;
            color: #1D2731;
            font-family: "Playfair Display", serif;
        }

        .browse_intro h1 {
            font-size: 42px;
            margin-bottom: 10px;
        }

        .browse_intro p {
            font-size: 18px;
            font-family: "Poppins", sans-serif;
        }

        /* Property Card Grid */
        .preview_properties {
            margin-top: 70px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 20px 20px;
            padding: 40px 20px;
            background-color: #f1f3f5;
        }

        .property {
            position: relative;
            width: 400px;
            height: 300px;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .property:hover {
            cursor: pointer;
            transform: scale(1.05);
        }

        .property_img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .property_text {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0));
            color: white;
            padding: 20px;
        }

        .property_text h3 {
            margin-bottom: 8px;
            font-size: 22px;
        }

        .property_text p {
            margin: 4px 0;
            font-size: 16px;
        }
    </style>

<!-- Header -->
<header id="home">
    <div class="logo">
        <img src="images/EmpireLivingLogo-TransparentWhite.png" alt="Empire Living Logo">
        EMPIRE LIVING
    </div>
    <div class="side_buttons">
        <a href="home.html">Home</a>
        <a href="browse.php">Rent</a>
        <a href="sell.php">Sell</a>
        <a href="login.php">Register / Sign In</a>
    </div>
</header>

<body>
    <!-- Intro Box -->
    <section class="browse_intro">
        <h1>Explore Premium Listings</h1>
        <p>Find your dream space among the finest properties New York has to offer.</p>
    </section>
    
    <!-- Properties to view -->
    <div class="preview_properties">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="property" id="<?php echo $row['property_id']?>">
                <img class="property_img" src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>"
                    alt="Property Image">
                <div class="property_text">
                    <h3><?php echo $row['title'];?></h3>
                    <p><?php echo $row['location'];?></p>
                    <p>$<?php echo number_format($row['cost']); ?></p>
                    <p>
                        <?php echo $row['bedrooms'];?> Bed • 
                        <?php echo $row['bathrooms'];?> Bath •
                        <?php echo $row['square_feet'];?> sqft
                    </p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

</body>

</html>