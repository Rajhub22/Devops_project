<?php
// Include the database configuration file
include('db_config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Event Details
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_description = $_POST['event_description'];
    $materials = $_POST['materials'];
    
    // Insert event details into school_events table
    $sql_event = "INSERT INTO school_events (event_name, event_date, event_description, materials) 
                  VALUES ('$event_name', '$event_date', '$event_description', '$materials')";
    
    if ($conn->query($sql_event) === TRUE) {
        // Get the last inserted event_id
        $event_id = $conn->insert_id;

        // Insert budget details into school_budgets table
        if (!empty($_POST['budget_category']) && !empty($_POST['budget_amount'])) {
            $budget_categories = $_POST['budget_category'];
            $budget_amounts = $_POST['budget_amount'];

            for ($i = 0; $i < count($budget_categories); $i++) {
                $category = $budget_categories[$i];
                $amount = $budget_amounts[$i];

                $sql_budget = "INSERT INTO school_budgets (event_id, category, amount) 
                               VALUES ('$event_id', '$category', '$amount')";
                $conn->query($sql_budget);
            }
        }

        // Insert to-do list details into school_todos table
        if (!empty($_POST['todo'])) {
            $todos = $_POST['todo'];

            foreach ($todos as $task) {
                $sql_todo = "INSERT INTO school_todos (event_id, task) 
                             VALUES ('$event_id', '$task')";
                $conn->query($sql_todo);
            }
        }

        // Redirect to display_school_events.php
        header("Location: display_school_events.php");
        exit(); // Ensure no further code is executed after the redirect
    } else {
        echo "Error: " . $sql_event . "<br>" . $conn->error;
    }
}
?>
