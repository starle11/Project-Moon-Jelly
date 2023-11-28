<?php
include('mylib.php');
session_start();

db_connect(); // Connect to the database

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            // Add a new flashcard
            $set_id = $_POST['set_id'];
            $front_content = $_POST['front_content'];
            $back_content = $_POST['back_content'];

            $insertFlashcardQuery = "INSERT INTO flashcards (set_id, front_content, back_content) 
                                     VALUES ($set_id, '$front_content', '$back_content')";
            $db->query($insertFlashcardQuery);
        } elseif ($action === 'edit') {
            // Edit an existing flashcard
            $flashcard_id = $_POST['flashcard_id'];
            $front_content = $_POST['front_content'];
            $back_content = $_POST['back_content'];

            $updateFlashcardQuery = "UPDATE flashcards 
                                     SET front_content = '$front_content', back_content = '$back_content' 
                                     WHERE flashcard_id = $flashcard_id";
            $db->query($updateFlashcardQuery);
        } elseif ($action === 'remove') {
            // Remove the selected flashcard
            $flashcard_id = $_POST['flashcard_id'];

            $removeFlashcardQuery = "DELETE FROM flashcards WHERE flashcard_id = $flashcard_id";
            $db->query($removeFlashcardQuery);
        }
    }
}

// Get the set_id from the URL or use a default value
$set_id = isset($_GET['set_id']) ? $_GET['set_id'] : 1;

// Fetch flashcards for the set
$query = "SELECT flashcards.flashcard_id, flashcards.front_content, flashcards.back_content
          FROM flashcards
          WHERE flashcards.set_id = $set_id";
$result = $db->query($query);

if ($result) {
    $flashcards = $result->fetch_all(MYSQLI_ASSOC);
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moon Jelly - Edit Flashcards</title>
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

        #flashcard-container {
            width: 600px;
            margin: 20px auto;
        }

        .flashcard {
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
        }

        .form-container {
            width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 20px;
        }

        button {
            background-color: #EE8194;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            margin-right: 10px; /* Add margin-right to create spacing between buttons */
        }

        .remove-button {
            background-color: #EE8194; /* Same color as the edit button */
        }
	.homepage-btn {
            background-color: #EE8194;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<header>
    <h1 id="moon-jelly"><a href="homepage.php">Moon Jelly</a></h1>
</header>

<div id="flashcard-container">
    <?php
    if (isset($flashcards) && !empty($flashcards)) {
        foreach ($flashcards as $flashcard) {
            echo '<div class="flashcard">
                    <div><strong>Front:</strong> ' . $flashcard['front_content'] . '</div>
                    <div><strong>Back:</strong> ' . $flashcard['back_content'] . '</div>
                    <form method="post" action="">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="flashcard_id" value="' . $flashcard['flashcard_id'] . '">
                        <button type="submit" class="remove-button" onclick="return confirm(\'Are you sure you want to remove this flashcard?\')">Remove</button>
                    </form>
                    <button onclick="editFlashcard(' . $flashcard['flashcard_id'] . ', \'' . $flashcard['front_content'] . '\', \'' . $flashcard['back_content'] . '\')">Edit</button>
                  </div>';
        }
    } else {
        echo '<p>No flashcards available for this set.</p>';
    }
    ?>
</div>

<div class="form-container">
    <h2>Add/Edit Flashcard</h2>
    <form method="post" action="">
        <input type="hidden" name="action" id="action" value="add">
        <input type="hidden" name="set_id" id="set_id" value="<?php echo $set_id; ?>">
        <input type="hidden" name="flashcard_id" id="flashcard_id" value="">
        <label for="front_content">Front Content:</label>
        <input type="text" name="front_content" id="front_content">
        <label for="back_content">Back Content:</label>
        <input type="text" name="back_content" id="back_content">
        <button type="submit">Add/Edit Flashcard</button>

        <!-- Homepage Button -->
        <a href="homepage.php" class="homepage-btn">Homepage</a>
    </form>
</div>

<script>
    function editFlashcard(flashcard_id, front_content, back_content) {
        // Populate the form with the existing flashcard content for editing
        document.getElementById('action').value = 'edit';
        document.getElementById('flashcard_id').value = flashcard_id;
        document.getElementById('front_content').value = front_content;
        document.getElementById('back_content').value = back_content;
    }
</script>

</body>
</html>
