<?php
include('db_config.php'); // Make sure this points to your DB connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and capture form data
    $categories = $_POST['category']; // Array of categories
    $amounts = $_POST['amount'];     // Array of amounts
    $materials = $_POST['materials']; // Materials textarea content
    $todo = $_POST['todo']; // To-do list items

    // Prepare SQL query to insert each category and amount pair
    $stmt = $conn->prepare("INSERT INTO Anniversary (category, amount, materials, todo) VALUES (?, ?, ?, ?)");

    for ($i = 0; $i < count($categories); $i++) {
        $category = $categories[$i];
        $amount = $amounts[$i];
        
        // Ensure that 'todo' is a string or null
        $todo_item = isset($todo[$i]) ? $todo[$i] : '';

        // Bind parameters for the insert statement
        $stmt->bind_param("sdss", $category, $amount, $materials, $todo_item); // "s" for string, "d" for decimal

        // Execute the statement
        $stmt->execute();
    }

    // Redirect to the DisplayAnniversaryPage.php after successful insertion
    header('Location: DisplayAnniversaryPage.php');
    exit();
}
?>
