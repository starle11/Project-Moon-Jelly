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
File Name:     practicequizzes.php
Purpose:       displays the practice quizzes
Resources:     - 
*/

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moon Jelly - Practice Quizzes</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        #moon-jelly a {
            text-decoration: none;
            color: #fff;
        }

        #moon-jelly {
            margin-right: auto;
        }

        .quiz-links-container {
            width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .quiz-link {
            display: block;
            margin-bottom: 20px;
            font-size: 18px;
            color: #fff;
            text-decoration: none;
            padding: 10px;
            border-radius: 8px;
            background-color: #EE8194;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .quiz-link:hover {
            background-color: #CD5C78;
        }
    </style>
</head>
<body>

<header>
    <h1 id="moon-jelly"><a href="homepage.php">Moon Jelly</a></h1>
</header>

<div class="quiz-links-container">
    <h2>Practice Quizzes</h2>
    <a href="multiple_choice_quiz.php" class="quiz-link">Multiple Choice Quiz</a>
    <a href="#" class="quiz-link" onclick="showComingSoonPopup('Fill in the Blank Quiz')">Fill in the Blank Quiz</a>
    <a href="#" class="quiz-link" onclick="showComingSoonPopup('Spelling Quiz')">Spelling Quiz</a>
</div>

<script>
	//displays coming soon for future development
    function showComingSoonPopup(quizName) {
        alert(quizName + ' - Coming soon!');
    }
</script>

</body>
</html>