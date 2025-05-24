<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summit Events Display</title>
    <style>
        /* Add your CSS here */
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
            position: relative;
        }
        .header-title {
            font-size: 24px;
        }
        nav {
            position: absolute;
            top: 20px;
            right: 20px;
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
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .add-event-btn:hover {
            background-color: #45a049;
        }
        .delete-button {
            background-color: black;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
        }
        .delete-button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
<header>
    <div class="header-title">
        Summit Events
    </div>
    <nav>
        <a href="Menu.html" class="button">Menu</a>
    </nav>
</header>
<div class="container">

<?php
// Include the database configuration file
include('db_config.php');

// Fetch all summit events
$sql_events = "SELECT * FROM summit_events";
$result_events = $conn->query($sql_events);

if ($result_events->num_rows > 0) {
    // Display each event
    while ($event = $result_events->fetch_assoc()) {
        $summit_event_id = $event['summit_event_id'];

        echo "<div class='event-section'>";
        echo "<button class='delete-btn' onclick='deleteEvent(" . $summit_event_id . ")'>Delete</button>";
        echo "<h2>" . htmlspecialchars($event['summit_event_name']) . "</h2>";
        echo "<p><strong>Start Date:</strong> " . htmlspecialchars($event['summit_event_start_date']) . "</p>";
        echo "<p><strong>End Date:</strong> " . htmlspecialchars($event['summit_event_end_date']) . "</p>";
        echo "<p><strong>Description:</strong> " . htmlspecialchars($event['summit_event_description']) . "</p>";
        echo "<p><strong>Materials:</strong> " . htmlspecialchars($event['summit_materials']) . "</p>";
        echo "</div>"; // Close event-section
    }
} else {
    echo "<p>No events found.</p>";
}
?>

<!-- Add Event Button -->
<a href="summits.html">
    <button class="add-event-btn">Add New Event</button>
</a>

</div>

<script>
// Delete event using JavaScript
function deleteEvent(eventId) {
    if (confirm("Are you sure you want to delete this event?")) {
        // Send a request to the delete_event.php file with the event ID
        fetch('delete_summit_event.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ summit_event_id: eventId }) // Send summit_event_id as JSON
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
