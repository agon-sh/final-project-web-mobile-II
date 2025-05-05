<?php
session_start();

// Only staff can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
    header('Location: login.php');
    exit;
}

// Connect to DB
$conn = mysqli_connect('localhost', 'root', '', 'empire_living')
    or die('Connection error');

// Delete property
if (isset($_GET['delete_id'])) {
    $del = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM property WHERE property_id = $del");
    header('Location: staff_dashboard.php');
    exit;
}

// Update property
if (isset($_POST['update'])) {
    $id           = intval($_POST['property_id']);
    $user_id      = intval($_POST['user_id']);
    $title        = $_POST['title'];
    $location     = $_POST['location'];
    $address      = $_POST['address'];
    $cost         = intval($_POST['cost']);
    $sqft         = intval($_POST['square_feet']);
    $bedrooms     = intval($_POST['bedrooms']);
    $bathrooms    = intval($_POST['bathrooms']);
    $description  = $_POST['description'];

    $sql = "UPDATE property SET
        user_id = $user_id,
        title = '$title',
        location = '$location',
        address = '$address',
        cost = $cost,
        square_feet = $sqft,
        bedrooms = $bedrooms,
        bathrooms = $bathrooms,
        description = '$description'
      WHERE property_id = $id";
    mysqli_query($conn, $sql);
    header('Location: staff_dashboard.php');
    exit;
}

// Fetch edit record if requested
$edit = null;
if (isset($_GET['edit_id'])) {
    $e = intval($_GET['edit_id']);
    $res = mysqli_query($conn, "SELECT * FROM property WHERE property_id = $e");
    $edit = mysqli_fetch_assoc($res);
}

// Fetch all properties
$all = mysqli_query($conn, "SELECT property_id, user_id, title, location, cost FROM property");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Staff Dashboard</h2>

    <?php if ($edit): ?>
        <h3>Edit Property #<?php echo $edit['property_id']; ?></h3>
        <form method="post">
            <input type="hidden" name="property_id" value="<?php echo $edit['property_id']; ?>">
            <p>User ID: <input type="number" name="user_id" value="<?php echo $edit['user_id']; ?>"></p>
            <p>Title: <input type="text" name="title" value="<?php echo $edit['title']; ?>"></p>
            <p>Location: <input type="text" name="location" value="<?php echo $edit['location']; ?>"></p>
            <p>Address: <input type="text" name="address" value="<?php echo $edit['address']; ?>"></p>
            <p>Cost: <input type="number" name="cost" value="<?php echo $edit['cost']; ?>"></p>
            <p>Square Feet: <input type="number" name="square_feet" value="<?php echo $edit['square_feet']; ?>"></p>
            <p>Bedrooms: <input type="number" name="bedrooms" value="<?php echo $edit['bedrooms']; ?>"></p>
            <p>Bathrooms: <input type="number" name="bathrooms" value="<?php echo $edit['bathrooms']; ?>"></p>
            <p>Description:<br>
               <textarea name="description"><?php echo $edit['description']; ?></textarea>
            </p>
            <p>
                <input type="submit" name="update" value="Update">
                <a href="staff_dashboard.php">Cancel</a>
            </p>
        </form>
    <?php endif; ?>

    <h3>All Properties</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Title</th>
            <th>Location</th>
            <th>Cost</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($all)): ?>
        <tr>
            <td><?php echo $row['property_id']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['location']; ?></td>
            <td><?php echo $row['cost']; ?></td>
            <td>
                <a href="?edit_id=<?php echo $row['property_id']; ?>">Edit</a> |
                <a href="?delete_id=<?php echo $row['property_id']; ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<!--Made by: Dion Hajrullahu. I declare that this code is written by me and not by ai or any other software service mentioned in the guidelines.-->
