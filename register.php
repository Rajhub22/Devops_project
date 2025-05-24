<?php
include('db_config.php');

// Initialize error message and form variables
$error_message = "";
$username = $email = $password = $confirm_password = $phone_number = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $username = isset($_POST['username']) ? trim($_POST['username']) : "";
    $email = isset($_POST['email']) ? trim($_POST['email']) : "";
    $password = isset($_POST['password']) ? $_POST['password'] : "";
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : "";
    $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : "";

    // Validate input fields
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($phone_number)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone_number)) { // Validate for 10-digit phone number
        $error_message = "Phone number must be 10 digits.";
    } elseif (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password) || !preg_match("/[\W]/", $password)) {
        $error_message = "Password must be at least 8 characters long, include an uppercase letter, a number, and a special character.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statement to insert user data
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, phone_number) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $phone_number);

        if ($stmt->execute()) {
            // Redirect to login.html on success
            header("Location: login.html");
            exit();
        } else {
            $error_message = "Registration failed. Please try again later.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aura Amour Register Form</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            width: 100%;
            padding: 0 10px;
            margin: 0;
            font-family: 'Open Sans', sans-serif;
            background: #ffffff;
        }
        .form-container {
            width: 600px;
            height: auto;
            border-radius: 12px;
            padding: 50px;
            text-align: center;
            border: 2px solid #1b1919;
            background: #f9f9f9;
        }
        h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #000;
        }
        .input-field {
            position: relative;
            border-bottom: 2px solid #ccc;
            margin: 20px 0;
        }
        .input-field input {
            width: 100%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 18px;
            color: #000;
        }
        .input-field label {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-200%);
            color: #161515;
            font-size: 19px;
            pointer-events: none;
            transition: 0.2s ease;
        }
        .input-field input:focus ~ label,
        .input-field input:valid ~ label {
            top: 0;
            transform: translateY(-100%);
            font-size: 16px;
            color: #444;
        }
        .form-container button {
            background: #000;
            color: #fff;
            font-weight: 600;
            border: none;
            padding: 14px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 20px;
            border: 2px solid transparent;
            transition: 0.3s ease;
        }
        .form-container button:hover {
            background: #444;
            border-color: #000;
        }
        .form-footer {
            text-align: center;
            margin-top: 40px;
            color: #555;
            font-size: 16px;
        }
        .form-footer a {
            color: #000;
            text-decoration: none;
            font-size: 18px;
        }
        .form-footer a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form method="POST" action="" style="display: flex; flex-direction: column;">
            <div class="input-field">
                <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                <label>Enter your username</label>
            </div>
            <div class="input-field">
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                <label>Enter your email</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Enter your password</label>
            </div>
            <div class="input-field">
                <input type="password" name="confirm_password" required>
                <label>Confirm your password</label>
            </div>
            <div class="input-field">
                <input type="tel" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" pattern="[0-9]{10}" required>
                <label>Enter your phone number</label>
            </div>
            <button type="submit">Register</button>
        </form>
        <div class="form-footer">
            <p>Already have an account? <a href="login.html">Log in</a></p>
        </div>
    </div>
</body>
</html>
