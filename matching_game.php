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
File Name:     matching_game.php
Purpose:       Matching game using flashcard information
Resources:     - 
*/

include('mylib.php');
session_start();

db_connect(); // Connect to the database

// Fetch available flashcard sets for the user
if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['user_id'];

    $query = "SELECT sets.set_id, sets.set_name FROM sets 
              JOIN users ON sets.user_id = users.user_id 
              WHERE users.username = '$username'";
    $result = $db->query($query);

    if ($result) {
        $flashcardSets = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Get the selected set_id from the form or use the first set as default
$set_id = isset($_GET['set_id']) ? $_GET['set_id'] : (isset($flashcardSets[0]['set_id']) ? $flashcardSets[0]['set_id'] : 1);

// Fetch flashcards for the selected set
$query = "SELECT flashcards.flashcard_id, flashcards.front_content, flashcards.back_content
          FROM flashcards
          WHERE flashcards.set_id = $set_id
          ORDER BY flashcards.flashcard_id ASC";
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
    <title>Moon Jelly - Matching Game</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        #moon-jelly a {
            text-decoration: none;
            color: #fff;
        }

        .game-container {
            width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            width: 120px;
            height: 120px;
            background-color: #EE8194;
            color: #fff;
            font-size: 18px;
            text-align: center;
            margin: 5px;
            line-height: 120px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header>
    <h1 id="moon-jelly"><a href="homepage.php">Moon Jelly</a></h1>
</header>

<div class="game-container">
    <?php
    if (isset($flashcards) && !empty($flashcards)) {
        // Shuffle the flashcards to mix them up
        shuffle($flashcards);

        // Display front content of each flashcard
        foreach ($flashcards as $flashcard) {
            echo '<div class="card front" onclick="selectCard(this)" data-id="' . $flashcard['flashcard_id'] . '">' . $flashcard['front_content'] . '</div>';
        }

        // Display back content of each flashcard (hidden initially)
        foreach ($flashcards as $flashcard) {
            echo '<div class="card back hidden" onclick="selectCard(this)" data-id="' . $flashcard['flashcard_id'] . '">' . $flashcard['back_content'] . '</div>';
        }
    } else {
        echo '<p>No flashcards available for this set.</p>';
    }
    ?>
</div>

<script>
    let selectedCards = [];

    // Function to handle card selection
    function selectCard(card) {
        // Prevent selecting more than two cards
        if (selectedCards.length >= 2) {
            return;
        }

        // Toggle visibility and store selected cards
        card.classList.toggle('hidden');
        selectedCards.push(card);

        // Check if two cards are selected
        if (selectedCards.length === 2) {
            checkMatch();
        }
    }

    // Function to check if the two selected cards match
    function checkMatch() {
        const id1 = selectedCards[0].dataset.id;
        const id2 = selectedCards[1].dataset.id;

        if (id1 === id2) {
            setTimeout(() => {
                alert('Congratulations! You found a match!');
                selectedCards.forEach(card => card.style.visibility = 'hidden');
                selectedCards = [];
            }, 500);
        } else {
            setTimeout(() => {
                selectedCards.forEach(card => card.classList.add('hidden'));
                selectedCards = [];
            }, 500);
        }
    }
</script>

</body>
</html>
