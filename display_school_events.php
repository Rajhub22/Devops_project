<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Events Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            position: relative; /* This will allow absolute positioning of the nav */
        }
        .header-title {
            font-size: 24px;
        }
        nav {
            position: absolute;
            top: 20px;
            right: 20px; /* Aligns the nav to the top right corner */
        }
        nav a {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 10px;
        }
        nav a:hover {
            background-color: #444;
        }
        .container {
            margin: 20px auto;
            padding: 20px;
            max-width: 800px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .event-section {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f4f4f9;
            position: relative;
        }
        .event-section h2 {
            margin-top: 0;
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #333;
            color: #fff;
        }
        .delete-btn {
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .delete-btn:hover {
            background-color: #cc0000;
        }
        .add-event-btn {
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1.2em;
            text-align: center;
            display: block;
            margin: 30px auto 0;
        }
        .add-event-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<header>
    <div class="header-title">
        School Events
    </div>
    <nav>
        <a href="Menu.html" class="button">Menu</a>
    </nav>
</header>
<div class="container">

<?php
// Include the database configuration file
include('db_config.php');

// Fetch all events
$sql_events = "SELECT * FROM school_events";
$result_events = $conn->query($sql_events);

if ($result_events->num_rows > 0) {
    // Display each event
    while ($event = $result_events->fetch_assoc()) {
        $event_id = $event['event_id'];

        echo "<div class='event-section'>";
        echo "<button class='delete-btn' onclick='deleteEvent($event_id)'>Delete</button>";
        echo "<h2>" . htmlspecialchars($event['event_name']) . "</h2>";
        echo "<p><strong>Date:</strong> " . htmlspecialchars($event['event_date']) . "</p>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($event['event_description']) . "</p>";
        echo "<p><strong>Materials:</strong> " . htmlspecialchars($event['materials']) . "</p>";

        // Fetch and display associated budgets
        $sql_budgets = "SELECT * FROM school_budgets WHERE event_id = $event_id";
        $result_budgets = $conn->query($sql_budgets);

        if ($result_budgets->num_rows > 0) {
            echo "<h3>Budget Details</h3>";
            echo "<table>";
            echo "<tr><th>Category</th><th>Amount</th></tr>";

            while ($budget = $result_budgets->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($budget['category']) . "</td>";
                echo "<td>₹" . number_format($budget['amount'], 2) . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p><strong>Budget:</strong> No budget data available.</p>";
        }

        // Fetch and display associated to-dos
        $sql_todos = "SELECT * FROM school_todos WHERE event_id = $event_id";
        $result_todos = $conn->query($sql_todos);

        if ($result_todos->num_rows > 0) {
            echo "<h3>To-Do List</h3>";
            echo "<ul>";

            while ($todo = $result_todos->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($todo['task']) . "</li>";
            }

            echo "</ul>";
        } else {
            echo "<p><strong>To-Do List:</strong> No tasks added.</p>";
        }

        echo "</div>"; // Close event-section
    }
} else {
    echo "<p>No events found.</p>";
}
?>

<!-- Add Event Button -->


</div>
<a href="school-events.html">
    <button class="add-event-btn">Add  Event</button>
</a>
<script>
// Delete event using JavaScript
function deleteEvent(eventId) {
    if (confirm("Are you sure you want to delete this event?")) {
        // Send a request to the delete_school_event.php file
        fetch('delete_school_event.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ event_id: eventId }),
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Show response from the server
            location.reload(); // Reload the page to show updated data
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
</script>

</body>
</html>
