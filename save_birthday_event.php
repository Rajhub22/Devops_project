<?php
// Connection to the database (Replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aura_amour";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind the statement for the BirthdayEvent table
$stmt = $conn->prepare("INSERT INTO BirthdayEvent (category, amount, todo_task, materials, contact_name, contact_phone) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sdssss", $category, $amount, $todo_task, $materials, $contact_name, $contact_phone);

// Loop through form data and insert into the BirthdayEvent table
foreach ($_POST['category'] as $key => $value) {
    $category = $value;
    $amount = $_POST['amount'][$key];
    $todo_task = $_POST['todo'][$key] ?? '';  // Assuming you handle the task separately
    $materials = $_POST['materials'] ?? '';  // Assuming this is a textarea
    $contact_name = "Event Planner";  // Example value, adjust as necessary
    $contact_phone = "123-456-7890";  // Example value, adjust as necessary

    $stmt->execute();
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Redirect to DisplayBirthdayEvents.php after successful insert
header("Location: DisplayBirthdayEvents.php");
exit();  // Make sure the script terminates after the redirect
?>
