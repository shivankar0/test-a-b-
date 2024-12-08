<?php
session_start();

// Check for query parameter
if (isset($_GET['home'])) {
    $home = $_GET['home']; // Fixed the parameter to 'home'
    if ($home === 'A' || $home === 'B') {
        $_SESSION['home'] = $home; // Corrected from '$version' to '$home'
        header("Location: home{$home}.html");
        exit();
    }
}

// Default random assignment
if (!isset($_SESSION['home'])) {
    $home = rand(0, 1) === 0 ? 'A' : 'B';
    $_SESSION['home'] = $home; // Corrected the assignment to use '$home'
}

header("Location: home{$_SESSION['home']}.html");
exit();
?>
