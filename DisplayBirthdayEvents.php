<?php
// Connection to the database (Replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aura_amour";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete a record if the delete button is clicked
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare and execute delete statement
    $delete_stmt = $conn->prepare("DELETE FROM BirthdayEvent WHERE id = ?");
    $delete_stmt->bind_param("i", $delete_id);
    $delete_stmt->execute();
    $delete_stmt->close();

    // Redirect back to the page after deletion
    header("Location: DisplayBirthdayEvents.php");
    exit();
}

// Fetch all the records from the BirthdayEvent table
$sql = "SELECT * FROM BirthdayEvent";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Birthday Events</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f7f7f7;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Header Styles */
        header {
            background-color: #333;
            color: #fff;
            padding: 20px 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header .logo {
            font-size: 1.8em;
            font-weight: bold;
        }

        nav ul {
            display: flex;
            gap: 20px;
        }

        nav ul li a {
            color: #fff;
            font-size: 1em;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        nav ul li a:hover {
            background-color: #575757;
        }

        /* Event Section */
        .event-section {
            padding: 50px 10%;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .event-section h1 {
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #222;
        }

        /* Table for Event Data */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        /* Delete Button Styles */
        .delete-btn {
            padding: 5px 10px;
            background-color: #f44336;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }

        /* Add Button Styles */
        .add-btn-container {
            margin-top: 30px;
            text-align: center;
        }

        .add-btn {
            padding: 10px 20px;
            background-color: black;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .add-btn:hover {
            background-color: #45a049;
        }

        /* Footer Styles */
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">Aura & Amour</div>
    <nav>
        <ul>
            <li><a href="Menu.html">Menu</a></li>
            
        </ul>
    </nav>
</header>

<section class="event-section">
    <h1>Birthday Event List</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Category</th>
                <th>Amount</th>
                <th>To-Do Task</th>
                <th>Materials</th>
                <th>Action</th>
            </tr>
            
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo number_format($row['amount'], 2); ?></td>
                    <td><?php echo $row['todo_task']; ?></td>
                    <td><?php echo $row['materials']; ?></td>
                    <td>
                        <!-- Delete Button -->
                        <a href="DisplayBirthdayEvents.php?delete_id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No records found.</p>
    <?php endif; ?>

    <!-- Add Button -->
    <div class="add-btn-container">
        <a href="Birthday.html" class="add-btn">Add New Event</a>
    </div>
</section>

<footer>
    <p>© 2024 Aura & Amour | All Rights Reserved</p>
</footer>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
