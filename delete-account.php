<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: homepage.php"); // Redirect to homepage if not logged in
    exit();
}

// Connect to the database (replace the placeholder values with your actual database credentials)
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "dbname";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Prepare a SQL statement to delete the user account
$sql = "DELETE FROM users WHERE id = ?";

// Bind the parameters and execute the statement
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Check if the account was successfully deleted
    if ($stmt->affected_rows > 0) {
        // Unset and destroy the session
        session_unset();
        session_destroy();

        // Redirect to homepage with a success message
        header("Location: homepage.php?delete=success");
        exit();
    } else {
        // Redirect to homepage with an error message
        header("Location: homepage.php?delete=error");
        exit();
    }
} else {
    // Redirect to homepage with an error message
    header("Location: homepage.php?delete=error");
    exit();
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
