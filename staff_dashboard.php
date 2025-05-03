<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f9f9f9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        a.button {
            color: white;
            background-color: #c0392b;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
        }

        a.button:hover {
            background-color: #e74c3c;
        }
    </style>
</head>
<body>
<?php
session_start();

// Check if the user is a staff member
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'staff') {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "empire_living");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM property WHERE property_id = $delete_id");
    header("Location: staff_dashboard.php");
    exit();
}

// Get all properties
$result = mysqli_query($conn, "SELECT property_id, title, location, cost FROM property");
?>
    <h2>Welcome, Staff Member</h2>
<p>Below is a list of all properties in the system:</p>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Location</th>
        <th>Cost</th>
        <th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['property_id']; ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['location']); ?></td>
            <td>$<?php echo number_format($row['cost']); ?></td>
            <td><a class="button" href="staff_dashboard.php?delete_id=<?php echo $row['property_id']; ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>