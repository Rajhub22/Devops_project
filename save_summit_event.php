<?php
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Event Details
    $event_name = $_POST['event_name'];
    $event_start_date = $_POST['event_start_date'];
    $event_end_date = $_POST['event_end_date'];
    $event_description = $_POST['event_description'];
    $materials = $_POST['materials'];

    // Insert into summit_events
    $sql_event = "INSERT INTO summit_events (summit_event_name, summit_event_start_date, summit_event_end_date, summit_event_description, summit_materials) 
                  VALUES ('$event_name', '$event_start_date', '$event_end_date', '$event_description', '$materials')";

    if ($conn->query($sql_event) === TRUE) {
        $event_id = $conn->insert_id;

        // Insert into summit_agenda
        foreach ($_POST['session_title'] as $index => $title) {
            $start_time = $_POST['session_start_time'][$index];
            $end_time = $_POST['session_end_time'][$index];
            $speaker = $_POST['session_speaker'][$index];
            $sql_agenda = "INSERT INTO summit_agenda (summit_event_id, summit_session_title, summit_session_start_time, summit_session_end_time, summit_session_speaker) 
                           VALUES ('$event_id', '$title', '$start_time', '$end_time', '$speaker')";
            $conn->query($sql_agenda);
        }

        // Insert into summit_budget
        foreach ($_POST['budget_category'] as $index => $category) {
            $amount = $_POST['budget_amount'][$index];
            $sql_budget = "INSERT INTO summit_budget (summit_event_id, summit_category, summit_amount) 
                           VALUES ('$event_id', '$category', '$amount')";
            $conn->query($sql_budget);
        }

        // Insert into summit_todos
        foreach ($_POST['todo'] as $task) {
            $sql_todo = "INSERT INTO summit_todos (summit_event_id, summit_task) 
                         VALUES ('$event_id', '$task')";
            $conn->query($sql_todo);
        }

        echo "Event Saved Successfully!";
        header('Location: display_summit_events.php');
        exit;
    } else {
        echo "Error: " . $sql_event . "<br>" . $conn->error;
    }
}
?>
