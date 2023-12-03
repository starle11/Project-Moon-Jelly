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
File Name:     multiple_choice_quiz_answers.php
Purpose:       displays the answers to the quiz in multiple choice
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

// Get the selected set_id from the form
$set_id = isset($_POST['set_id']) ? $_POST['set_id'] : (isset($flashcardSets[0]['set_id']) ? $flashcardSets[0]['set_id'] : 1);

// Fetch the first flashcard for the selected set
$query = "SELECT flashcards.flashcard_id, flashcards.front_content, flashcards.back_content
          FROM flashcards
          WHERE flashcards.set_id = $set_id
          ORDER BY flashcards.flashcard_id ASC LIMIT 1";
$result = $db->query($query);

if ($result) {
    $flashcard = $result->fetch_assoc();
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moon Jelly - Quiz Answers</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1 id="moon-jelly"><a href="homepage.php">Moon Jelly</a></h1>
</header>

<div class="quiz-answers-container">
    <h2>Quiz Answers</h2>

    <?php
    if (isset($flashcardSets) && !empty($flashcardSets)) {
        // Display flashcard sets dropdown
        echo '<form action="multiple_choice_quiz_answers.php" method="post">';
        echo '<select class="select-dropdown" id="set-dropdown" name="set_id">';
        foreach ($flashcardSets as $flashcardSet) {
            $isSelected = ($flashcardSet['set_id'] == $set_id) ? 'selected' : '';
            echo '<option value="' . $flashcardSet['set_id'] . '" ' . $isSelected . '>' . $flashcardSet['set_name'] . '</option>';
        }
        echo '</select>';
        echo '<input type="submit" value="Show Answers">';
        echo '</form>';
    }

    if (isset($flashcard)) {
        $question = $flashcard['front_content'];
        $correctAnswer = $flashcard['back_content'];

        echo '<div class="question">' . $question . '</div>';
        
        // Display the correct answer
        echo '<div class="correct-answer">Correct Answer: ' . $correctAnswer . '</div>';
    } else {
        echo '<p>No flashcards available for this set.</p>';
    }
    ?>

    <button onclick="goBack()">Back</button>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>

</body>
</html>
