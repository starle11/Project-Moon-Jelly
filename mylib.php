<?php

/*
Group Name:    Moon Jelly
Name(s):       Joseph Nolan/Julia Craft/Katherine Ringeisen/Raymond Mateo
Major:         Software Development/CSC IT
Creation Date: Nov. 14, 2023
Due Date:      Dec. 11, 2023
Course:        CSC 354-020 - Fall 2023
Professor:     Dr. Tauqeer Hussain
SE Phase II:   Designing Prototype
File Name:     mylib.php
Purpose:       Database Connection Library
Resources:     - 
*/

function db_connect() {
    global $db;
    $db_host = 'localhost';
    $db_user = 'jcraf273';
    $db_pass = 'f!f2bAi3M';
    $db_name = 'jcraf273_db';

    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $errmsg = $db->connect_error;

    return $errmsg;
}
?>
