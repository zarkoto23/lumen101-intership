<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1200)) {
    $_SESSION = array();
    session_destroy();

    header('Location: login.php?timeout=1');
    exit;
}

$_SESSION['last_activity'] = time();