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
    $removeSetId = $_POST['remove_set_id'];
    $username = $_SESSION['user_id']; // Assuming 'user_id' in session is the username

    // Assuming you have a table named 'sets' with columns 'set_id', 'set_name', and 'user_id'
    // Also assuming you have a table named 'users' with columns 'user_id' and 'username'
    $query = "DELETE FROM sets 
              WHERE set_id = $removeSetId AND user_id = (SELECT user_id FROM users WHERE username = '$username')";

    if ($db->query($query)) {
        echo "Set removed successfully!";
        
        // Redirect back to flashcards.php after successful set removal
        header("Location: flashcards.php");
        exit();
    } else {
        echo "Error removing set: " . $db->error;
    }
}

// Close the database connection
$db->close();
?>
