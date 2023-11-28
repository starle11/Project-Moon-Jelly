<?php
session_start();

function logout() {
    session_unset();
    session_destroy();
    header("Location: homepage.php?logout=true");
    exit();
}

logout();
?>
