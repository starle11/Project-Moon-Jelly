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
File Name:     flashcardsset.php
Purpose:       displays the sets of flashcards
Resources:     - 
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moon Jelly - Flashcard Sets</title>
    <link rel="stylesheet" href="styles.css">
        <style>

        #moon-jelly a {
            text-decoration: none;
            color: #fff;
        }

        .set-selection-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .select-dropdown,
        .add-set-btn,
        .remove-set-btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            background-color: #EE8194;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .add-set-input,
        .remove-set-input {
            width: 70%;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<header>
    <h1 id="moon-jelly"><a href="homepage.php">Moon Jelly</a></h1>
</header>

<div class="set-selection-container">
    <h2>Select Flashcard Set</h2>
    <form action="flashcards.php" method="get">
        <select class="select-dropdown" id="set-dropdown" name="set_id">
            <?php
            session_start();
            include('mylib.php');
            db_connect();

            // Check if the user is logged in
            if (!isset($_SESSION['user_id'])) {
                // The user is not logged in, handle accordingly
                echo '<option value="">User not logged in</option>';
            } else {
                $username = $_SESSION['user_id']; // Assuming 'user_id' in session is the username

                // Assuming you have a table named 'sets' with columns 'set_id', 'set_name', and 'user_id'
                $query = "SELECT sets.set_id, sets.set_name FROM sets 
                          JOIN users ON sets.user_id = users.user_id 
                          WHERE users.username = '$username'";

                $result = $db->query($query);

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
                    echo '<option value="">Error retrieving sets: ' . $db->error . '</option>';
                }
            }

            // Close the database connection
            $db->close();
            ?>
        </select>
        <input type="submit" value="Start Flashcards" class="add-set-btn">
    </form>

    <!-- Back to Flashcards button -->
    <form action="flashcards.php">
        <input type="submit" value="Back to Flashcards" class="add-set-btn">
    </form>

    <!-- Add a new set form -->
    <div class="add-set-form">
        <h2>Add a New Flashcard Set</h2>
        <form action="add_set.php" method="post">
            <label for="new-set-name">Set Name:</label>
            <input type="text" id="new-set-name" name="new_set_name" class="add-set-input" required>
            <input type="submit" value="Add Set" class="add-set-btn">
        </form>
    </div>

    <!-- Remove a set form with confirmation popup -->
    <div class="remove-set-form">
        <h2>Remove Flashcard Set</h2>
        <form action="remove_set.php" method="post" onsubmit="return confirm('Are you sure you want to remove this set?');">
            <label for="remove-set-id">Select Set to Remove:</label>
            <select id="remove-set-id" name="remove_set_id" class="remove-set-input" required>
                <?php
                // Output the sets in the dropdown for removal
                if ($result && $result->num_rows > 0) {
                    mysqli_data_seek($result, 0); // Reset result pointer to the beginning
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['set_id'] . '">' . $row['set_name'] . '</option>';
                    }
                }
                ?>
            </select>
            <input type="submit" value="Remove Set" class="remove-set-btn">
        </form>
    </div>
</div>

</body>
</html>
