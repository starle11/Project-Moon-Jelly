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
File Name:     flashcards.php
Purpose:       displays the flashcards
Resources:     - 
*/

session_start();

// Check if the user_id is passed in the URL
if (isset($_GET['user_id'])) {
    $_SESSION['user_id'] = $_GET['user_id'];
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle the case when the user is not logged in
    header("Location: login-form.php");
    exit();
}

// Rest of your code
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moon Jelly - Flashcards</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
        #moon-jelly a {
            text-decoration: none;
            color: #fff;
        }

        #moon-jelly {
            margin-right: auto;
        }

        #flashcard-container {
            width: 600px;
            height: 300px;
            perspective: 1000px;
            margin: 100px auto;
        }

        #flashcard {
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            cursor: pointer;
            background-color: #fff; /* Set card background color to white */
            outline: 2px solid #ccc; /* Grey outline */
        }

        #flashcard .front,
        #flashcard .back {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            font-size: 24px;
            position: absolute;
            backface-visibility: hidden;
            width: 100%;
            height: 100%;
            padding: 20px;
            transform-origin: center center;
        }

        #flashcard .front {
            background-color: #fff; /* Set card background color to white */
            outline: 2px solid #ccc; /* Grey outline */
            color: #000000;
            transform: rotateX(0deg);
        }

        #flashcard .back {
            background-color: #fff; /* Set card background color to white */
            outline: 2px solid #ccc; /* Grey outline */
            color: #000000;
            transform: rotateX(180deg);
        }

        #flip-btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .btn {
            background-color: #EE8194;
            color: #fff;
            border: none;
            padding: 20px;
            border-radius: 8px;
            cursor: pointer;
            margin: 0 10px;
            font-size: 18px;
        }
    </style>

<body>

<header>
    <h1 id="moon-jelly"><a href="homepage.php">Moon Jelly</a></h1>
</header>

<div id="flashcard-container">
    <?php
    include('mylib.php');
    session_start();

    db_connect(); // Connect to the database

    // Get the set_id from the URL or use a default value
    $set_id = isset($_GET['set_id']) ? $_GET['set_id'] : 1;

    // Assuming you have a table named 'flashcards' with columns 'front_content' and 'back_content'
    $query = "SELECT flashcards.front_content, flashcards.back_content
              FROM flashcards
              WHERE flashcards.set_id = $set_id";
    $result = $db->query($query);

    if ($result) {
        $flashcards = array(); // Array to store flashcard content

        while ($row = $result->fetch_assoc()) {
            $flashcards[] = array(
                'front_content' => $row['front_content'],
                'back_content' => $row['back_content']
            );
        }

        // Output the first flashcard
        echo '<div id="flashcard" onclick="flipCard()">
                <div class="front">
                    <div>' . $flashcards[0]['front_content'] . '</div>
                </div>
                <div class="back">
                    <div>' . $flashcards[0]['back_content'] . '</div>
                </div>
              </div>';
    }

    $db->close(); // Close the database connection
    ?>
</div>

<div id="flip-btn-container">
    <button class="btn" id="prev-btn" onclick="prevCard()">Previous</button>
    <button class="btn" id="next-btn" onclick="nextCard()">Next</button>
    <button class="btn" id="flip-btn" onclick="flipCard()">Flip</button>
    <button class="btn" id="edit-btn" onclick="editCard()">Edit</button>
    <button class="btn" id="select-sets-btn" onclick="selectSets()">Select/Add Sets</button>
</div>

<script>
    var currentCardIndex = 0;
    var isFlipped = false;
    var flashcards = <?php echo json_encode($flashcards); ?>;

    function showCard(index) {
        var flashcard = document.getElementById('flashcard');
        flashcard.innerHTML = '<div class="front"><div>' + flashcards[index].front_content + '</div></div>' +
                              '<div class="back"><div>' + flashcards[index].back_content + '</div></div>';
        isFlipped = false;
    }

    function prevCard() {
        currentCardIndex = (currentCardIndex - 1 + flashcards.length) % flashcards.length;
        showCard(currentCardIndex);
    }

    function nextCard() {
        currentCardIndex = (currentCardIndex + 1) % flashcards.length;
        showCard(currentCardIndex);
    }

    function flipCard() {
        var flashcard = document.getElementById('flashcard');
        flashcard.style.transform = isFlipped ? 'rotateX(0deg)' : 'rotateX(180deg)';
        isFlipped = !isFlipped;
    }

    function editCard() {
        // Redirect to flashcardsedit.php with the set_id parameter
        window.location.href = 'flashcardsedit.php?set_id=' + <?php echo $set_id; ?>;
    }

    function selectSets() {
    // Redirect to flashcardssets.php with user_id parameter
    window.location.href = 'flashcardssets.php';
}
</script>

</body>
</html>