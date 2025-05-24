<?php
require_once 'db_config.php';

header('Content-Type: application/json');

// Get the JSON data sent via AJAX
$data = json_decode(file_get_contents('php://input'), true);

// Check if the review_id is provided
if (isset($data['id'])) {
    $reviewId = $data['id'];

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM Ebefor_reviews WHERE review_id = ?");
    $stmt->bind_param("i", $reviewId);

    // Execute the delete query
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}

$conn->close();
?>
