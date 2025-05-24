<?php
// Include the database configuration file
include('db_config.php');

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Get the event ID from the data
$summit_event_id = $data['summit_event_id'];

// Check if event ID is set and valid
if (isset($summit_event_id) && !empty($summit_event_id)) {

    // Begin the database transaction
    $conn->begin_transaction();

    try {
        // Delete associated agenda, budget, and todos
        $conn->query("DELETE FROM summit_agenda WHERE summit_event_id = '$summit_event_id'");
        $conn->query("DELETE FROM summit_budget WHERE summit_event_id = '$summit_event_id'");
        $conn->query("DELETE FROM summit_todos WHERE summit_event_id = '$summit_event_id'");

        // Delete the event
        $sql_delete = "DELETE FROM summit_events WHERE summit_event_id = '$summit_event_id'";

        if ($conn->query($sql_delete) === TRUE) {
            // Commit the transaction if everything is successful
            $conn->commit();
            echo "Event and associated data deleted successfully!";
        } else {
            // Rollback the transaction if any query fails
            $conn->rollback();
            echo "Error: " . $conn->error;
        }
    } catch (Exception $e) {
        // Rollback the transaction in case of an exception
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

} else {
    echo "Invalid event ID.";
}

?>
