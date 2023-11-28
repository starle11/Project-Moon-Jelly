<?php
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

// Fetch the first flashcard for the selected set
$query = "SELECT flashcards.flashcard_id, flashcards.front_content, flashcards.back_content
          FROM flashcards
          WHERE flashcards.set_id = $set_id
          ORDER BY flashcards.flashcard_id ASC LIMIT 1";
$result = $db->query($query);

if ($result) {
    $flashcard = $result->fetch_assoc();
}

// Fetch the second flashcard for the selected set
$query = "SELECT flashcards.flashcard_id, flashcards.front_content, flashcards.back_content
          FROM flashcards
          WHERE flashcards.set_id = $set_id
          ORDER BY flashcards.flashcard_id ASC LIMIT 1 OFFSET 1";
$result = $db->query($query);

if ($result) {
    $flashcard2 = $result->fetch_assoc();
}

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moon Jelly - Multiple Choice Quiz</title>
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

        .quiz-container {
            width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .select-dropdown {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .question {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .answer {
            display: block;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        button {
            background-color: #EE8194;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
        }
    </style>
</head>
<body>

<header>
    <h1 id="moon-jelly"><a href="homepage.php">Moon Jelly</a></h1>
</header>

<div class="quiz-container">
    <h2>Multiple Choice Quiz</h2>

    <?php
    if (isset($flashcardSets) && !empty($flashcardSets)) {
        // Display flashcard sets dropdown
        echo '<form action="multiple_choice_quiz.php" method="get">';
        echo '<select class="select-dropdown" id="set-dropdown" name="set_id">';
        foreach ($flashcardSets as $flashcardSet) {
            $isSelected = ($flashcardSet['set_id'] == $set_id) ? 'selected' : '';
            echo '<option value="' . $flashcardSet['set_id'] . '" ' . $isSelected . '>' . $flashcardSet['set_name'] . '</option>';
        }
        echo '</select>';
        echo '<input type="submit" value="Start Quiz">';
        echo '</form>';
    }

    if (isset($flashcard) && isset($flashcard2)) {
        $question = $flashcard['front_content'];
        $correctAnswer = $flashcard['back_content'];
        $incorrectAnswer = $flashcard2['back_content'];

        echo '<div class="question">' . $question . '</div>';
        echo '<label class="answer"><input type="radio" name="question" value="correct"> ' . $correctAnswer . '</label>';
        echo '<label class="answer"><input type="radio" name="question" value="incorrect"> ' . $incorrectAnswer . '</label>';
        echo '<br>';
    } else {
        echo '<p>No flashcards available for this set.</p>';
    }
    ?>

    <button onclick="submitQuiz()">Submit Quiz</button>
</div>

<script>
    function submitQuiz() {
        // You can implement the logic to process the selected answer here
        window.location.href = 'multiple_choice_quiz_answers.php';
    }
</script>

</body>
</html>
