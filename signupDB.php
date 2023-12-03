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
File Name:     signupDB.php
Purpose:       backend to sign up a new user
Resources:     - 
*/

session_start();

/*POST Information From Signup Form*/
$username = $_POST['username'];
$password = $_POST['password'];

/*Database Sign Up*/
include "mylib.php";
$errmsg = db_connect();

if ($errmsg != NULL) {
    echo "Error: $errmsg";
} else {
    // Check if the username already exists
    $checkUsernameQuery = "SELECT username FROM users WHERE username = ?";
    $checkUsernameStmt = $db->prepare($checkUsernameQuery);
    $checkUsernameStmt->bind_param('s', $username);
    $checkUsernameStmt->execute();
    $checkUsernameStmt->store_result();

    if ($checkUsernameStmt->num_rows > 0) {
        $error_message = "Username already exists. Please choose a different username.";
    } else {
        // Insert new user into the 'users' table
        $insertUserQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
        $insertUserStmt = $db->prepare($insertUserQuery);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $insertUserStmt->bind_param('ss', $username, $hashedPassword);

        if ($insertUserStmt->execute()) {
            $_SESSION['user_id'] = $username;
            $_SESSION['logged_in'] = true;
            header("Location: homepage.php");
            exit();
        } else {
            $error_message = "Error creating user. Please try again.";
        }
    }

    $checkUsernameStmt->close();
    $insertUserStmt->close();
    $db->close();

    if (isset($error_message)) {
        // Display error message on the signup form
        include "signup-form.php";
    }
}
?>
