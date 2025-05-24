<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "aura_amour"; // The database name you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Anniversary Data with pagination
$limit = 10; // Records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Handle delete request
if (isset($_GET['delete_anniversary'])) {
    $id = (int)$_GET['delete_anniversary']; // Get the id from URL

    // SQL query to delete the record
    $delete_sql = "DELETE FROM Anniversary WHERE id = $id";

    if ($conn->query($delete_sql) === TRUE) {
        // Redirect to the same page after successful deletion
        header("Location: " . $_SERVER['PHP_SELF'] . "?page=$page");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Retrieve data for the Anniversary table
$anniversary_sql = "SELECT * FROM Anniversary LIMIT $limit OFFSET $offset";
$anniversary_result = $conn->query($anniversary_sql);

// Calculate total pages for pagination
$total_anniversary_sql = "SELECT COUNT(*) as count FROM Anniversary";
$total_anniversary_result = $conn->query($total_anniversary_sql);
$total_anniversary = $total_anniversary_result->fetch_assoc()['count'];
$total_pages = ceil($total_anniversary / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anniversary Event Display</title>
    <style>
        .add-event-section {
    text-align: center;
    margin: 20px 0;
}

.add-event-btn {
    padding: 15px 30px;
    background-color: black;
    color: white;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    font-size: 1em;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-decoration: none;
    display: inline-block;
    transition: background 0.3s;
}

.add-event-btn:hover {
    background-color: #ffa502;
    color: #fff;
}

        /* Styling as before */
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

        /* Event Section */
        .event-section {
            padding: 50px 10%;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .event-section h1 {
            font-size: 2.5em;
            margin-bottom: 30px;
            color: #222;
        }

        /* Event Section Items (Anniversary Details) */
        .event-section-item {
            margin-bottom: 30px;
            background-color: #fafafa;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        .event-section-item h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }

        /* Table for Anniversary Data */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: black;
            color: #fff;
        }

        .add-row-btn {
            padding: 10px 20px;
            background-color: #f7b731;
            color: #333;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 15px;
        }

        .add-row-btn:hover {
            background-color: #ffa502;
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            padding: 10px 20px;
            margin: 0 5px;
            background-color: #f7b731;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .pagination a:hover {
            background-color: #ffa502;
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

        .delete-link {
            color: #e74c3c;
            font-size: 0.9em;
            text-decoration: none;
        }

        .delete-link:hover {
            color: #c0392b;
        }

        .menu-btn {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .menu-btn:hover {
            background-color: #f7b731;
            transform: translateY(-3px);
        }

        .menu-btn:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(255, 193, 7, 0.8);
        }

        a {
            text-decoration: none;
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

<div class="event-section">
    <h1>Anniversary Event Details</h1>

    <div class="event-section-item" id="anniversary">
        <h2>Anniversary Data</h2>
        <table>
            <tr>
                <th>Category</th>
                <th>Amount</th>
                <th>Materials</th>
                <th> Todo</th>
                <th>Action</th>
            </tr>
            <?php while($row = $anniversary_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo htmlspecialchars($row['amount']); ?></td>
                <td><?php echo htmlspecialchars($row['materials']); ?></td>
                <td><?php echo htmlspecialchars($row['todo']); ?></td>
                <td><a class="delete-link" href="?delete_anniversary=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Pagination for Anniversary -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>

</div>
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>">Previous</a>
    <?php endif; ?>
    <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>">Next</a>
    <?php endif; ?>
</div>

<!-- Add Event Button Section -->
<div class="add-event-section">
    <a href="anniversary.html" class="add-event-btn">Add New Anniversary Event</a>
</div>

<footer>
    <p>&copy; 2024 Anniversary Event Management</p>
</footer>

<footer>
    <p>&copy; 2024 Anniversary Event Management</p>
</footer>

</body>
</html>

<?php
// Close the connection
$conn->close();
?>
