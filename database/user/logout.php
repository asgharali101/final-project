<?php

session_start();

if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
    session_destroy();
    header('location:../../index.html');
    exit;
} else {
    echo 'No active session found. User already logged out.';
}
