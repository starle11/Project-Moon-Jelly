<?php
session_start();
include('mylib.php');
db_connect();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect or handle accordingly (e.g., user not logged in)
    header("Location: login-form.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newSetName = $_POST['new_set_name'];
    $username = $_SESSION['user_id']; // Assuming 'user_id' in session is the username

    // Assuming you have a table named 'sets' with columns 'set_name' and 'user_id'
    // Also assuming you have a table named 'users' with columns 'user_id' and 'username'
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
