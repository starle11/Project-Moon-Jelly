<?php
/*
Group Name:    Moon Jelly
Name(s):       Joseph Nolan/Julia Craft/Katherine Ringeisen/Raymond Mateo
Major:         Software Development/CSC IT
Creation Date: Nov. 27, 2023
Due Date:      Dec. 6, 2023
Course:        CSC 354-020 - Fall 2023
Professor:     Dr. Tauqeer Hussain
SE Phase II:   Designing Prototype
File Name:     loginDB.php
Purpose:       backend to log a user into the website
Resources:     - 
*/

session_start();

/*POST Information From Login Form*/
$username = $_POST['username'];
$password = $_POST['password'];

/*Database Sign In*/
include "mylib.php";
$errmsg = db_connect();

if ($errmsg != NULL) {
    echo "Error: $errmsg";
} else {
    // Query to check username and password in the 'users' table
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
    $db->close();

    if ($is_successful_login) {
        $_SESSION['confirm'] = $_SESSION['confirm'] + 1;
        $_SESSION['user_id'] = $username; // Set the session variable for user ID
        $_SESSION['logged_in'] = true; // Set the session variable for logged-in status
        header("Location: homepage.php");
        exit();
    } else {
        // Display error message on the login form
        $error_message = "Username or password is incorrect. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Confirmation</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header>
        <h1>Login Confirmation</h1>
        <div class="header-buttons">
            <button onclick="window.location.href='homepage.php'">Home</button>
        </div>
    </header>

    <div class="content-container">
        <h2>Login Confirmation</h2>

        <?php
        // Display error message if set
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>
    </div>

</body>

</html>
