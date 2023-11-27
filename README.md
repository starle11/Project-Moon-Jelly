# Project-Moon-Jelly
Software engineering project

Here's the link for accessing the project setup on my account:
https://unixweb.kutztown.edu/~jcraf273/Prototype/homepage.php 

Don't forget that mylib.php is setup for my mysql database, if you want to try it on yours you need to redo it for your mysql account.
Here's the mysql commands for setting up the tables in the database in mysql:

+--------------+----------------------------------------------+--------------------------------------------------------------------------------+--------+
| flashcard_id | front_content                                | back_content                                                                   | set_id |
+--------------+----------------------------------------------+--------------------------------------------------------------------------------+--------+
|            3 | What is the capital of France?               | Paris France                                                                   |      1 |
|            4 | Who wrote Romeo and Juliet?                  | Shakespeare                                                                    |      1 |
|            5 | What is 1 + 1 = ?                            | 4                                                                              |      1 |
|            8 | What is 1 + 1 = ?                            | 2                                                                              |      1 |
|            9 | What is the capital of Spain?                | Madrid                                                                         |      2 |
|           10 | What year did the American Revolution begin? | 1775                                                                           |      2 |
|           11 | What is the process of photosynthesis?       | The process by which plants convert sunlight into energy to fuel their growth. |      2 |
+--------------+----------------------------------------------+--------------------------------------------------------------------------------+--------+

For the above flashcard table: 
CREATE TABLE flashcards (
    flashcard_id INT PRIMARY KEY,
    front_content VARCHAR(255),
    back_content VARCHAR(255),
    set_id INT
);

INSERT INTO flashcards (flashcard_id, front_content, back_content, set_id)
VALUES
    (3, 'What is the capital of France?', 'Paris France', 1),
    (4, 'Who wrote Romeo and Juliet?', 'Shakespeare', 1),
    (5, 'What is 1 + 1 = ?', '4', 1),
    (8, 'What is 1 + 1 = ?', '2', 1),
    (9, 'What is the capital of Spain?', 'Madrid', 2),
    (10, 'What year did the American Revolution begin?', '1775', 2),
    (11, 'What is the process of photosynthesis?', 'The process by which plants convert sunlight into energy to fuel their growth.', 2);

+---------+------------+--------------------------------------------------------------+------------------------+
| user_id | username   | password                                                     | email                  |
+---------+------------+--------------------------------------------------------------+------------------------+
|       1 | sampleuser | 1234                                                         | sample@example.com     |
|       2 | john_doe   | securepassword                                               | john.doe@example.com   |
|       3 | julia      | $2y$10$rWX0v1I/l1887qbaKUcEs.mK1RPP9YXx1088CXgiIb03fUxC0m8X2 | juliacraft16@gmail.com |
+---------+------------+--------------------------------------------------------------+------------------------+

For the above users table:
CREATE TABLE users (
    user_id INT PRIMARY KEY,
    username VARCHAR(255),
    password VARCHAR(255),
    email VARCHAR(255)
);

INSERT INTO users (user_id, username, password, email)
VALUES
    (1, 'sampleuser', '1234', 'sample@example.com'),
    (2, 'john_doe', 'securepassword', 'john.doe@example.com'),
    (3, 'julia', '$2y$10$rWX0v1I/l1887qbaKUcEs.mK1RPP9YXx1088CXgiIb03fUxC0m8X2', 'juliacraft16@gmail.com');

+--------+---------+-----------------------+
| set_id | user_id | set_name              |
+--------+---------+-----------------------+
|      1 |       1 | Geography and History |
|      2 |       1 | Math                  |
|      4 |       1 | Science and Math      |
|      5 |       2 | Science and Math      |
+--------+---------+-----------------------+

For the above sets table:
CREATE TABLE user_sets (
    set_id INT PRIMARY KEY,
    user_id INT,
    set_name VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

INSERT INTO user_sets (set_id, user_id, set_name)
VALUES
    (1, 1, 'Geography and History'),
    (2, 1, 'Math'),
    (4, 1, 'Science and Math'),
    (5, 2, 'Science and Math');


