<!DOCTYPE html>
<!--
Group Name:    Moon Jelly
Name(s):       Joseph Nolan/Julia Craft/Katherine Ringeisen/Raymond Mateo
Major:         Software Development/CSC IT
Creation Date: Nov. 27, 2023
Due Date:      Dec. 6, 2023
Course:        CSC 354-020 - Fall 2023
Professor:     Dr. Tauqeer Hussain
SE Phase II:   Designing Prototype
File Name:     login-form.php
Purpose:       Form to log into the website
Resources:     - 
-->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

    <style>
        .login-form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
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

        .signup-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .signup-link a {
            color: #EE8194;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>

<body>

    <header>
        <h1>Moon Jelly</h1>
    </header>

    <div class="login-form">
        <h2>Login</h2>

        <?php
        session_start();

        // Check if the user is already logged in, redirect to homepage
        if (isset($_SESSION['user_id'])) {
            header("Location: homepage.php");
            exit();
        }

        // Check login credentials
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include "mylib.php";
            $errmsg = db_connect();

            if ($errmsg != NULL) {
                echo "Error: $errmsg";
            } else {
                // Query to check username and password in the 'users' table
                $username = $_POST['username'];
                $password = $_POST['password'];

                $query = "SELECT username, password FROM users ";
                $res = $db->prepare($query);
                $res->bind_result($db_username, $db_password);
                $res->execute();
                $is_successful_login = false;

                if ($res) {
                    while ($res->fetch()) {
                        if ($username == $db_username && $password == $db_password) {
                            $is_successful_login = true;
                            break;
                        }
                    }
                    $res->close();
                }
                if ($is_successful_login) {
                    $_SESSION['user_id'] = $username;
                    header("Location: homepage.php");
                    exit();
                } else {
                    echo '<p style="color: red;">Invalid username or password.</p>';
                }
            }
        }
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <div class="signup-link">
            Don't have an account? <a href="signupDB.php">Sign up</a>
        </div>
    </div>

</body>

</html>
