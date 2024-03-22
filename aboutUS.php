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
File Name:     homepage.php
Purpose:       is the websites homepage
Resources:     - 
*/
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
            background-color: #668CFF;
        }

        header {
            background-color: #668CFF
;
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
            color: #668CFF
;
            border: none;
            padding: 8px 16px;
            margin-right: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .header-buttons button.logout-button {
            background-color: #B96FD1;
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
			
           
        }

        h2 {
            color: #4b97ff;
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
			border-style: solid;
			border-color: #B3B3FF;

            
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
	<img src="simpleJelly2.gif" alt="image" width="50" height="50"> 
    <div class="header-buttons">

    <?php
    if (isset($_SESSION['user_id'])) {
        echo '<button class="logout-button" id="logoutButton">Logout</button>';
	echo '<button onclick="window.location.href=\'delete.php\'">Delete Account</button>';
    } else {
        echo '<button onclick="window.location.href=\'login-form.php\'">Login</button>';
        echo '<button onclick="window.location.href=\'signup-form.php\'">Sign Up</button>';
    }
    ?>
</div>

</header>

<section>
    <h2>The Moon Jelly Team:</h2>
    <div class="selection-container">
        <?php
        $selections = [
            ['id' => 1, 'img1' => '<img src="jdiscordIM.JPG" alt="julia">', 'title' => 'Julia Craft', 'description' => 'Julia is a senior computer science major at kutztown university',], 
            ['id' => 2, 'img1' => '<img src="rdiscordIM.JPG" alt="julia">','title' => 'Raymond Mateo', 'description' => 'Raymond is a senior computer science major at kutztown university'], 
			['id' => 3, 'img1' => '<img src="jndiscordIM.JPG" alt="julia">','title' => 'Joseph Nolan', 'description' => 'Joseph is a senior IT major at kutztown university'], 
			['id' => 4, 'img1' => '<img src="kdiscordIM.JPG" alt="julia">','title' => 'Katherine Ringeisen', 'description' => 'Katherine is a senior computer science major at kutztown university'],
        ];

        foreach ($selections as $select) {
			#echo '<img src="jdiscordIM.JPG" alt="julia">';

            echo '<div class="selection-card">';
            echo '<h3>' . $select['title'] . '</h3>';
			echo '<p>' . $select['img1'] . '</p>';

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

<script>
    document.getElementById('logoutButton').addEventListener('click', logout);
</script>


</body>
</html>
