<?php
// Include the database configuration file
include('db_config.php');

// Get the POST data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['event_id'])) {
    $event_id = $data['event_id'];

    // Delete event from school_events
    $sql_delete_event = "DELETE FROM school_events WHERE event_id = $event_id";

    if ($conn->query($sql_delete_event) === TRUE) {
        // Also delete associated budgets and todos
        $conn->query("DELETE FROM school_budgets WHERE event_id = $event_id");
        $conn->query("DELETE FROM school_todos WHERE event_id = $event_id");

        echo "Event deleted successfully!";
    } else {
        echo "Error deleting event: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}
?>
