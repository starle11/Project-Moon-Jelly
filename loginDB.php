<?php
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
    <style>
        /* Your styles for loginDB.php go here */

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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-buttons {
            display: flex;
        }

        .header-buttons button {
            background-color: #fff;
            color: #EE8194;
            border: none;
            padding: 8px 16px;
            margin-right: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .header-buttons button:hover {
            background-color: #ddd;
        }

        .content-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #EE8194;
        }

        .error-message {
            color: red;
        }
    </style>
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
