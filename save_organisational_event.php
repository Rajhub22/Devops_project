<?php
// Include the database configuration file
include('db_config.php'); // Ensure this file contains your database connection details

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and capture form data
    $event_name = $_POST['event_name1'];  // Event Name
    $event_date = $_POST['event_date1'];  // Event Date
    $event_description = $_POST['event_description1'];  // Event Description
    $materials = $_POST['materials'];  // Materials needed (can be a list)
    $todo = isset($_POST['todo1']) ? $_POST['todo1'] : '';  // To-Do list (single task, later we handle multiple tasks separately)

    // Budget details (multiple categories and amounts)
    $budget_categories = isset($_POST['budget_category']) ? $_POST['budget_category'] : [];
    $budget_amounts = isset($_POST['budget_amount']) ? $_POST['budget_amount'] : [];

    // Check if all required fields are filled
    if (empty($event_name) || empty($event_date) || empty($event_description) || empty($materials)) {
        echo "Error: Please fill all required fields.";
        exit;
    }

    // Insert event data into the Organisation table
    $stmt = $conn->prepare("INSERT INTO Organisation (event_name, event_date, event_description, materials, todo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $event_name, $event_date, $event_description, $materials, $todo);

    if ($stmt->execute()) {
        // Get the last inserted event id
        $event_id = $stmt->insert_id;

        // Insert each budget category and amount into the Budget1 table
        foreach ($budget_categories as $index => $category) {
            $amount = $budget_amounts[$index];

            // Insert budget data
            $budget_stmt = $conn->prepare("INSERT INTO Budget1 (event_id, category, amount) VALUES (?, ?, ?)");
            $budget_stmt->bind_param("isd", $event_id, $category, $amount);  // 'i' for integer, 's' for string, 'd' for decimal
            $budget_stmt->execute();
        }

        // Redirect to Display_organisational_Events.php after successful insertion
        header("Location: Display_organisational_Events.php");
        exit; // Ensure no further code is executed after redirection
    } else {
        // If insertion fails
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statements
    $stmt->close();
    $conn->close();
}
?>
