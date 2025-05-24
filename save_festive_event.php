<?php
// Include database configuration
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $categories = $_POST['category'] ?? [];
    $amounts = $_POST['amount'] ?? [];
    $materials = $_POST['materials'] ?? [];
    $todo_list = $_POST['todo_list'] ?? [];

    // Check if categories and amounts are not empty
    if (!empty($categories) && !empty($amounts)) {
        $stmt = $conn->prepare("INSERT INTO festive_events (category, amount, materials, todo_list) VALUES (?, ?, ?, ?)");

        // Iterate through categories and amounts
        foreach ($categories as $index => $category) {
            $amount = $amounts[$index] ?? 0; // Default amount if not set
            $material = $materials[$index] ?? ""; // Default empty string for materials
            $todo = $todo_list[$index] ?? ""; // Default empty string for to-do list

            $stmt->bind_param("sdss", $category, $amount, $material, $todo);
            $stmt->execute();
        }

        $stmt->close();
        $conn->close();

        // Redirect to FestiveEventDisplay.php
        header("Location: FestiveEventDisplay.php");
        exit(); // Ensure no further script is executed
    } else {
        // Stay on the same page and display an error
        $error = "Please fill out all required fields.";
    }
}
?>
