<?php
require_once 'db_config.php';

// Initialize an empty reviews array
$reviews = [];

try {
    // Query to fetch reviews
    $sql = "SELECT * FROM Ebefor_reviews ORDER BY submission_date DESC";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Query Error: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reviews[] = [
                'name' => htmlspecialchars($row['name']),
                'email' => htmlspecialchars($row['email']),
                'review' => nl2br(htmlspecialchars($row['review'])),
                'submission_date' => htmlspecialchars($row['submission_date'])
            ];
        }
    }

    echo json_encode($reviews);
} catch (Exception $e) {
    http_response_code(500); // Send a 500 status code for errors
    echo json_encode(['error' => $e->getMessage()]);
}

$conn->close();
?>
