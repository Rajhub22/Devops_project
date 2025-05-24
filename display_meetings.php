<?php
require_once 'db_config.php';

// Check if a delete request is made
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    // Delete the meeting from the database
    $delete_sql = "DELETE FROM Ebefor_meetings WHERE meeting_id = ?";
    if ($stmt = $conn->prepare($delete_sql)) {
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
        // Redirect back to the display page
        header("Location: display_meetings.php");
        exit;
    }
}

// Retrieve meetings from the database
$sql = "SELECT * FROM Ebefor_meetings ORDER BY meeting_datetime DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meetings</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: black;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: relative;
        }
        header .dashboard-link {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #fff;
            text-decoration: none;
            font-size: 1.1em;
        }
        header .dashboard-link:hover {
            text-decoration: underline;
        }
        .content {
            padding: 20px;
        }
        .meeting-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .meeting {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: transform 0.3s ease;
        }
        .meeting:hover {
            transform: scale(1.05);
        }
        .meeting h2 {
            color: #333;
            font-size: 1.6em;
            margin-bottom: 10px;
        }
        .meeting p {
            color: #555;
            font-size: 1em;
            margin: 5px 0;
        }
        .delete-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
            
        }
    </style>
</head>
<body>

    <header>
        <h1>Meeting Management</h1>
        <a href="Menu.html" class="dashboard-link">Dashboard</a>
    </header>

    <div class="content">
        <h2>Upcoming Meetings</h2>

        <?php if ($result->num_rows > 0): ?>
            <div class="meeting-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="meeting">
                        <h2><?php echo htmlspecialchars($row['meeting_title']); ?></h2>
                        <p><strong>Date & Time:</strong> <?php echo htmlspecialchars($row['meeting_datetime']); ?></p>
                        <p><strong>Timezone:</strong> <?php echo htmlspecialchars($row['meeting_timezone']); ?></p>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($row['meeting_description']); ?></p>
                        <p><strong>Type:</strong> <?php echo htmlspecialchars($row['meeting_type']); ?></p>
                        <p><strong>Priority:</strong> <?php echo htmlspecialchars($row['priority_level']); ?></p>
                        <p><strong>Reminder:</strong> <?php echo htmlspecialchars($row['reminder_method']); ?> at <?php echo htmlspecialchars($row['reminder_time']); ?></p>
                        <!-- Delete Button -->
                        <a href="display_meetings.php?delete_id=<?php echo $row['meeting_id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this meeting?')" class="delete-btn">
                            Delete
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No meetings found.</p>
        <?php endif; ?>

        <div class="btn-container">
        <a href="meetings.html" style="text-decoration: none; display: inline-block; margin-top: 20px;">
    <button style="background-color: black; color: white; padding: 12px 24px; border: none; border-radius: 5px; font-size: 1.1em; cursor: pointer; transition: background-color 0.3s ease;">
        Schedule a New Meeting
    </button>
</a>

        </div>

    </div>

</body>
</html>
