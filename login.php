<?php
// Suppress any PHP warnings or notices
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

include('db_config.php');
$error_message = ""; // Variable to store error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL query to fetch the user by email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Redirect to Menu.html
            header("Location: Menu.html");
            exit(); // Ensure no further code is executed
        } else {
            // Invalid password
            $error_message = "Invalid password!";
        }
    } else {
        // User not found
        $error_message = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aura Amour Login Form</title>
  <style>
    /* Styling for the form and layout */
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
      color: #121111;
      font-size: 20px;
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

    label[for="remember"] {
      color: #000000;
      font-size: 18px;
    }

    input[type="checkbox"] {
      transform: scale(1.2);
    }

    p {
      font-size: 19px;
      margin-left: 10px;
    }

    /* Error message styling */
    .error-message {
      color: red;
      font-size: 16px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <form action="login.php" method="POST" style="display: flex; flex-direction: column;">
      <h2>Login</h2>
      
      <div class="input-field">
        <input type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" required>
        <label>Enter your email</label>
      </div>

      <div class="input-field">
        <input type="password" name="password" required>
        <label>Enter your password</label>
      </div>

      <!-- Remember me option and Forgot password link -->
      <div style="display: flex; align-items: center; justify-content: space-between; margin: 35px 0; color: #555;">
        <label for="remember" style="display: flex; align-items: center;">
          <input type="checkbox" id="remember" style="accent-color: #000;">
          <p>Remember me</p>
        </label>
        <a href="Forgot.html"><p>Forgot password?</p></a>
      </div>

      <button type="submit">Log In</button>

      <!-- Display error message if login fails -->
      <?php if (!empty($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
      <?php endif; ?>
      
      <div class="form-footer">
        <p>Don't have an account? <a href="SignUp.html">SignUp</a></p>
      </div>
    </form>
  </div>
</body>
</html>
