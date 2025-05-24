<?php
require_once 'db_config.php';

// Fetch reviews from the database
$sql = "SELECT * FROM Ebefor_reviews ORDER BY submission_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through the results and display each review
    while ($row = $result->fetch_assoc()) {
        echo "<div class='review'>";
        echo "<p class='author'>" . htmlspecialchars($row['name']) . " (" . htmlspecialchars($row['email']) . ")</p>";
        echo "<p>" . nl2br(htmlspecialchars($row['review'])) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No reviews yet.</p>";
}

$conn->close();
?>
