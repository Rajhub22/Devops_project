<?php
require_once 'db_config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $review = $_POST['review'];

    // Insert data into the database
    $sql = "INSERT INTO Ebefor_reviews (name, email, review) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $review);

    if ($stmt->execute()) {
        // Redirect to Display_reviews.php after successful submission
        header("Location: Display_reviews.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
