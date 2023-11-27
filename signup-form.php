<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #EE8194;
            color: #fff;
            padding: 10px;
            text-align: left;
        }

        h1 {
            margin: 0;
        }

        .signup-form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h2 {
            color: #EE8194;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #EE8194;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #ff576c;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #EE8194;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
        }
    </style>
</head>

<body>

    <header>
        <h1>Moon Jelly</h1>
    </header>

    <div class="signup-form">
        <h2>Sign Up</h2>

        <?php
        session_start();

        // Check if the user is already logged in, redirect to homepage
        if (isset($_SESSION['user_id'])) {
            header("Location: homepage.php");
            exit();
        }

        // Check signup credentials
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include "mylib.php";
            $errmsg = db_connect();

            if ($errmsg != NULL) {
                echo "Error: $errmsg";
            } else {
                // Extract user input
                $username = $_POST['username'];
                $password = $_POST['password'];
                $email = $_POST['email'];

                // Check if the username already exists
                $checkUsernameQuery = "SELECT username FROM users WHERE username = ?";
                $checkUsernameStmt = $db->prepare($checkUsernameQuery);
                $checkUsernameStmt->bind_param('s', $username);
                $checkUsernameStmt->execute();
                $checkUsernameStmt->store_result();

                // Check if the email already exists
                $checkEmailQuery = "SELECT email FROM users WHERE email = ?";
                $checkEmailStmt = $db->prepare($checkEmailQuery);
                $checkEmailStmt->bind_param('s', $email);
                $checkEmailStmt->execute();
                $checkEmailStmt->store_result();

                if ($checkUsernameStmt->num_rows > 0) {
                    echo '<p class="error-message">Username already exists. Please choose a different username.</p>';
                } elseif ($checkEmailStmt->num_rows > 0) {
                    echo '<p class="error-message">Email already exists. Please use a different email address.</p>';
                } else {
                    // Insert new user into the 'users' table
                    $insertQuery = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
                    $insertStmt = $db->prepare($insertQuery);
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
                    $insertStmt->bind_param('sss', $username, $hashedPassword, $email);

                    if ($insertStmt->execute()) {
                        $_SESSION['user_id'] = $username;
                        header("Location: homepage.php");
                        exit();
                    } else {
                        echo '<p class="error-message">Error creating user. Please try again.</p>';
                    }

                    $insertStmt->close();
                }

                $checkUsernameStmt->close();
                $checkEmailStmt->close();
                $db->close();
            }
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Sign Up</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="login-form.php">Login</a>
        </div>
    </div>

</body>

</html>
