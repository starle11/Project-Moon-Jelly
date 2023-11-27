<?php
include('mylib.php');
session_start();
db_connect();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header('Location: login-form.php');
    exit();
}

// The user is logged in, proceed with the rest of your code
$userId = $_SESSION['user_id'];

// Assuming you have a table named 'sets' with columns 'set_id', 'set_name', and 'user_id'
$query = "SELECT set_id, set_name FROM sets WHERE user_id = $userId";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moon Jelly - Flashcard Sets</title>
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
            padding: 20px;
            text-align: left;
            width: 100%;
            display: flex;
            align-items: center;
        }

        #moon-jelly a {
            text-decoration: none;
            color: #fff;
        }

        #moon-jelly {
            margin-right: auto;
        }

        .set-selection-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .select-dropdown {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1 id="moon-jelly"><a href="homepage.php">Moon Jelly</a></h1>
</header>

<div class="set-selection-container">
    <h2>Select Flashcard Set</h2>
    <select class="select-dropdown" id="set-dropdown" name="set_id">
        <?php
        if ($result) {
            if ($result->num_rows > 0) {
                // Output the sets in the dropdown
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['set_id'] . '">' . $row['set_name'] . '</option>';
                }
            } else {
                echo '<option value="">No sets found</option>';
            }
        } else {
            echo '<option value="">Error retrieving sets</option>';
        }
        ?>
    </select>
</div>

</body>
</html>
<?php
// Close the database connection
$db->close();
?>
