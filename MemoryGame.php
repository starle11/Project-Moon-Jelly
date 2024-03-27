<?php
/*
Group Name:    Moon Jelly
Name(s):       Joseph Nolan/Julia Craft/Katherine Ringeisen/Raymond Mateo
Major:         Software Development/CSC IT
Creation Date: March 6, 2024
Due Date:      May 6, 2024
Course:        CSC 354-020 - Fall 2023
Professor:     Dr. Tauqeer Hussain
SE Phase II:   Designing Prototype
File Name:     MemoryGame.php
Purpose:       Matching game using flashcard information continuation
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
    <title>Moon Jelly - Memory Matching Game</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        #moon-jelly a {
            text-decoration: none;
            color: #fff;
        }

        .game-container {
            max-width: 600px;
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
            min-width: 120px;
            min-height: 120px;
            background-color: #EE8194;
            color: #EE8194;
            font-size: 18px;
            text-align: center;
            margin: 5px;
            padding: 10px;
            line-height: 1.4;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease-in-out;
			transform: rotatey(180deg);
			
        }

        .card.selected {
			transform: rotatey(180deg);
            transform: scale(1.05); /* Make the card slightly bigger when selected */
            border: 3px solid black; /* Add a black border to the selected card */
			color: #fff;
        }


        .card.not-matched {
            background-color: #555; /* Change color to indicate that the cards don't match */
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

        // Display back content of each flashcard 
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

        // Check if the card has already been selected
        if (selectedCards.includes(card)) {
            return;
        }

        // Toggle visibility and store selected cards
		
        card.classList.toggle('hidden');
        card.classList.toggle('selected');
        selectedCards.push(card);
		
		

        // Check if two cards are selected
        if (selectedCards.length === 2) {
            checkMatch();
        }
    }

    // Function to check if the two selected cards match
    function checkMatch() {
        // Ensure there are exactly two selected cards
        if (selectedCards.length !== 2) {
            console.error('Invalid number of selected cards.');
            return;
        }

        const id1 = selectedCards[0].dataset.id;
        const id2 = selectedCards[1].dataset.id;

        // Ensure that the dataset IDs are present
        if (!id1 || !id2) {
            console.error('Missing dataset IDs.');
            return;
        }

        // Check if the IDs match
        if (id1 === id2) {
            setTimeout(() => {
                
                selectedCards.forEach(card => card.style.visibility = 'hidden');
                selectedCards = [];
            }, 500);
        } else {
            // Add a class to indicate that the cards don't match
            selectedCards.forEach(card => card.classList.add('not-matched'));
            
            // Reset the cards after a short delay
            setTimeout(() => {
                selectedCards.forEach(card => {
                    card.classList.remove('selected', 'hidden', 'not-matched');
                });
                selectedCards = [];
            }, 1000);
        }
    }
</script>

</body>
</html>
