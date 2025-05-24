<?php
// Include the database configuration file
include('db_config.php');

// Handle AJAX request for deleting an event
if (isset($_POST['delete_event'])) {
    $event_id = $_POST['delete_event'];

    if (is_numeric($event_id)) {
        // Delete related budgets first
        $conn->query("DELETE FROM Budget1 WHERE event_id = $event_id");

        // Then delete the event from the Organisation table
        $conn->query("DELETE FROM Organisation WHERE event_id = $event_id");
        echo "success";
        exit;
    } else {
        echo "invalid_event_id";
        exit;
    }
}

// Handle AJAX request for deleting a budget
if (isset($_POST['delete_budget'])) {
    $budget_id = $_POST['delete_budget'];

    if (is_numeric($budget_id)) {
        $conn->query("DELETE FROM Budget1 WHERE budget_id = $budget_id");
        echo "success";
        exit;
    } else {
        echo "invalid_budget_id";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organisational Event Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #000;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 2em;
        }
        .content {
            padding: 20px;
        }
        .section {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .event-name-box {
            background-color: #333;
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            font-size: 1.5em;
            font-weight: bold;
            text-transform: uppercase;
        }
        .event-details {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #000;
            color: white;
        }
        table td {
            background-color: #f9f9f9;
        }
        .delete-button {
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: #e53935;
        }
        header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #000;
    color: #fff;
    padding: 15px 20px;
    font-size: 1.5em;
}

.header-title {
    font-size: 1.2em;
    font-weight: bold;
}

nav {
    display: flex;
    gap: 10px; /* Space between the buttons */
}

.button {
    text-decoration: none;
    color: #fff;
    background-color: #007BFF;
    padding: 5px 10px; /* Smaller padding */
    font-size: 0.8em;  /* Smaller font size */
    border: none;
    border-radius: 4px;
    transition: background-color 0.3s ease, color 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Subtle shadow */
}

.button:hover {
    background-color: #0056b3;
    color: #fff;
}
.add-event-button {
    padding: 10px 20px;
    background-color: black;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 1em;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-event-button:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
<header>
    <div class="header-title">
        Organisation's Events
    </div>
    <nav>
        <a href="Menu.html" class="button">Menu</a>
        
    </nav>
</header>



<div class="content">
    <!-- Event Display Section -->
    <div id="eventContainer">
        <?php
        // Fetch events from the Organisation table
        $result = $conn->query("SELECT * FROM Organisation");

        if ($result->num_rows > 0) {
            while ($event = $result->fetch_assoc()) {
                echo "<div class='section' data-event-id='" . $event['event_id'] . "'>";
                
                // Event Name inside a box
                echo "<div class='event-name-box'>" . $event['event_name'] . "</div><br>";
                
                // Event Details
                echo "<div class='event-details'>";
                echo "<div><strong>Date:</strong></div><div>" . $event['event_date'] . "</div>";
                echo "<div><strong>Description:</strong></div><div>" . $event['event_description'] . "</div>";
                echo "<div><strong>Materials:</strong></div><div>" . $event['materials'] . "</div>";
                echo "<div><strong>To-Do:</strong></div><div>" . $event['todo'] . "</div>";
                echo "</div>";
                
                // Delete Event Button
                echo "<button class='delete-button' onclick='deleteEvent(" . $event['event_id'] . ")'>Delete Event</button>";

                // Fetch associated budgets
                $budget_result = $conn->query("SELECT * FROM Budget1 WHERE event_id=" . $event['event_id']);
                if ($budget_result->num_rows > 0) {
                    echo "<h3>Budget:</h3>";
                    echo "<table>";
                    echo "<tr><th>Category</th><th>Amount</th><th>Action</th></tr>";
                    while ($budget = $budget_result->fetch_assoc()) {
                        echo "<tr data-budget-id='" . $budget['budget_id'] . "'>";
                        echo "<td>" . $budget['category'] . "</td>";
                        echo "<td>₹" . $budget['amount'] . "</td>";
                        echo "<td><button class='delete-button' onclick='deleteBudget(" . $budget['budget_id'] . ")'>Delete</button></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No budget information available for this event.</p>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>No events found.</p>";
        }
        ?>
    </div>

    <!-- Add Event Button -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="organisationalEvents.html">
            <button class="add-event-button">Add New Event</button>
        </a>
    </div>
</div>


<script>
    // Function to delete an event
    function deleteEvent(eventId) {
        if (confirm("Are you sure you want to delete this event?")) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "Display_organisational_Events.php", true); // Match your file name
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200 && xhr.responseText === "success") {
                    const eventSection = document.querySelector(`.section[data-event-id='${eventId}']`);
                    if (eventSection) eventSection.remove();
                } else {
                    alert("Failed to delete event.");
                }
            };
            xhr.send("delete_event=" + eventId);
        }
    }

    // Function to delete a budget
    function deleteBudget(budgetId) {
        if (confirm("Are you sure you want to delete this budget item?")) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "Display_organisational_Events.php", true); // Match your file name
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200 && xhr.responseText === "success") {
                    const budgetRow = document.querySelector(`tr[data-budget-id='${budgetId}']`);
                    if (budgetRow) budgetRow.remove();
                } else {
                    alert("Failed to delete budget.");
                }
            };
            xhr.send("delete_budget=" + budgetId);
        }
    }
</script>

</body>
</html>
