<?php

require_once '../../connection.php';
session_start();
$currentEmail = $_SESSION["user"]["email"] ?? null;
if ($currentEmail == null) {
    header('location:../../index.html');
}
$stmt = $conn->query("SELECT * FROM users where email='$currentEmail'");
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentUser["role_id"] != 1) {
    header("location:../../error.php");
    exit;
}

$id = $_GET['id'];

if (isset($id)) {
    $delete = $conn->exec("DELETE FROM enrollments  WHERE id=$id");
    header('location:../../../../user/enrollment.php');
} else {
    header('location:../../../../user/enrollment.php');
}
