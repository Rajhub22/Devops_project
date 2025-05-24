<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews</title>
    <style>
        /* Existing styles remain unchanged */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: black;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: relative;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        header .dashboard-link {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #fff;
            text-decoration: none;
            font-size: 1.1em;
        }
        header .dashboard-link:hover {
            text-decoration: underline;
        }
        .content {
            padding: 20px;
        }
        .review-container {
            background-color: #fff;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .review-container h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .review {
            background-color: #f9fbfd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            border: 1px solid #e0e7ff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }
        .review:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        .review-author {
            font-weight: bold;
            color: black;
            margin: 0 0 5px;
            font-size: 1.1em;
        }
        .review-email {
            font-size: 0.9em;
            color: #555;
            margin: 5px 0 15px;
        }
        .review-text {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            color: #333;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .review-date {
            font-size: 0.9em;
            color: #999;
            text-align: right;
        }
        .no-reviews {
            text-align: center;
            color: #888;
            font-size: 1.2em;
            margin-top: 20px;
        }
        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.9em;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: darkred;
        }
        .add-review-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .add-review-btn:hover {
            background-color: #333;
        }
        .add-review-btn a {
            text-decoration: none;
            color: white;
        }
    </style>
    <script>
        function deleteReview(reviewId) {
            if (confirm("Are you sure you want to delete this review?")) {
                // Send an AJAX request to delete the review
                fetch('delete_review.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: reviewId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Review deleted successfully.");
                        location.reload(); // Reload the page to update the review list
                    } else {
                        alert("Failed to delete the review.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                });
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>Aura & Amour</h1>
        <a href="Menu.html" class="dashboard-link">Menu</a>
    </header>
    <div class="content">
        <div class="review-container">
            <h2>Customers Review</h2>
            <?php
            require_once 'db_config.php';

            // Retrieve reviews from the database
            $sql = "SELECT * FROM Ebefor_reviews ORDER BY submission_date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='review'>";
                    echo "<p class='review-author'>" . htmlspecialchars($row['name']) . "</p>";
                    echo "<p class='review-email'>(" . htmlspecialchars($row['email']) . ")</p>";
                    echo "<div class='review-text'>" . nl2br(htmlspecialchars($row['review'])) . "</div>";
                    echo "<p class='review-date'>Submitted on: " . htmlspecialchars($row['submission_date']) . "</p>";
                    echo "<button class='delete-btn' onclick='deleteReview(" . $row['review_id'] . ")'>Delete</button>";
                    echo "</div>";
                }
            } else {
                echo "<p class='no-reviews'>No reviews found.</p>";
            }
            ?>
            <!-- Add Review Button -->
            <button class="add-review-btn"><a href="reviews.html">Add Review</a></button>
        </div>
    </div>
</body>
</html>
