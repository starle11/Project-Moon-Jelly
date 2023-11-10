<!DOCTYPE html>
<html>
<head>
    <title>Create Flashcards</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>Create Flashcards</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
        </ul>
    </nav>
    <main>
        <h2>Fill in the Flashcard Content</h2>
        <form method="post" action="process-flashcard.php">
            <div class="flashcard">
                <label for="front">Front Side:</label>
                <input type="text" name="front" id="front" required>
            </div>
            <div class="flashcard">
                <label for="back">Back Side:</label>
                <input type="text" name="back" id="back" required>
            </div>
            <div class="flashcard">
                <input type="submit" value="Create Flashcard">
            </div>
        </form>
    </main>
</body>
</html>