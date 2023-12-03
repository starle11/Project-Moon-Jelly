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
File Name:     add_set.php
Purpose:       adds a set to the directory
Resources:     - 
*/
session_start();
include('mylib.php');
db_connect();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect or handle accordingly
    header("Location: login-form.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newSetName = $_POST['new_set_name'];
    $username = $_SESSION['user_id']; // Assuming 'user_id' in session is the username

    $query = "INSERT INTO sets (set_name, user_id) 
              SELECT '$newSetName', users.user_id 
              FROM users 
              WHERE users.username = '$username'";

    if ($db->query($query)) {
        // Redirect back to flashcards.php upon successful set addition
        header("Location: flashcards.php");
        exit();
    } else {
        echo "Error adding set: " . $db->error;
    }
}

// Close the database connection
$db->close();
?>
