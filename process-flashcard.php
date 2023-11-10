<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user input from the form
    $frontSide = $_POST["front"];
    $backSide = $_POST["back"];

    // Create a string to represent the flashcard data
    $flashcardData = $frontSide . " - " . $backSide . "\n";

    // Specify the file path where you want to store the flashcard data
    $file = "flashcards.txt";
	echo $file
    // Append the flashcard data to the text file
    if (file_put_contents($file, $flashcardData, FILE_APPEND)) {
        echo "Flashcard created and saved successfully!";
    } else {
        echo "Error saving flashcard.";
    }
}
?>