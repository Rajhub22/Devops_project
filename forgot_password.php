<?php
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Check if passwords match
    if ($new_password !== $confirm_new_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the new password before updating
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Prepare SQL query to update the password
    $sql = "UPDATE users SET password = '$hashed_new_password' WHERE username = '$username'";

    if ($conn->query($sql) === TRUE) {
        // Redirect to passwordchanged.html
        header("Location: passwordchanged.html");
        exit(); // Ensure no further code is executed
    } else {
        echo "Error updating password: " . $conn->error;
    }
}
?>
