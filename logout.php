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
File Name:     logout.php
Purpose:       Logs the user out of the website
Resources:     - 
*/

session_start();
//function to logout
function logout() {
    session_unset();
    session_destroy();
    header("Location: homepage.php?logout=true");
    exit();
}

logout();
?>