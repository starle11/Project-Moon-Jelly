<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moon Jelly</title>
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
            padding: 10px;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-buttons {
            display: flex;
        }

        .header-buttons button {
            background-color: #fff;
            color: #EE8194;
            border: none;
            padding: 8px 16px;
            margin-right: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .header-buttons button.logout-button {
            background-color: #EE8194;
            color: #fff;
        }

        .header-buttons button:hover {
            background-color: #ddd;
        }

        section {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #EE8194;
        }

        .selection-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .selection-card {
            width: 48%;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: box-shadow 0.3s;
        }

        .selection-card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .selection-card a {
            text-decoration: none;
            color: #333;
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .confirmation-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .popup-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>Moon Jelly</h1>
    <div class="header-buttons">
        <?php
        if (isset($_SESSION['user_id'])) {
            echo '<button class="logout-button" onclick="logout()">Logout</button>';
        } else {
            echo '<button onclick="window.location.href=\'login-form.php\'">Login</button>';
            echo '<button onclick="window.location.href=\'signup-form.php\'">Sign Up</button>';
        }
        ?>
    </div>
</header>

<section>
    <h2>Available Selections:</h2>
    <div class="selection-container">
        <?php
        $selections = [
            ['id' => 1, 'title' => 'Flashcards', 'description' => 'Create your own unique flashcards.', 'link' => 'flashcards.php'],
            ['id' => 2, 'title' => 'Practice Quizzes', 'description' => 'Take one of our Practice Quizzes.', 'link' => 'practicequizzes.php'],
        ];

        foreach ($selections as $select) {
            echo '<div class="selection-card">';
            echo '<a href="' . (isset($_SESSION['user_id']) ? $select['link'] . '?user_id=' . $_SESSION['user_id'] : '#') . '">';
            echo '<h3>' . $select['title'] . '</h3>';
            echo '<p>' . $select['description'] . '</p>';
            echo '</a>';
            echo '</div>';
        }
        ?>
    </div>
</section>

<div class="confirmation-popup" id="confirmationPopup">
    <p id="confirmationMessage"></p>
    <div class="popup-buttons">
        <button onclick="window.location.href='login-form.php'">Login</button>
        <button onclick="window.location.href='signupDB.php'">Sign Up</button>
        <button onclick="closePopup('confirmationPopup')">Cancel</button>
    </div>
</div>

<script>
    function openPopup(popupId) {
        document.getElementById(popupId).style.display = 'block';
    }

    function closePopup(popupId) {
        document.getElementById(popupId).style.display = 'none';
    }

    function openConfirmationPopup(message) {
        document.getElementById('confirmationMessage').innerHTML = message;
        openPopup('confirmationPopup');
    }

    function logout() {
        window.location.href = 'logout.php';
    }
</script>

</body>
</html>
