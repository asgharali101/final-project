<?php

require_once '../../connection.php';
session_start();
$currentEmail = $_SESSION["user"]["email"] ?? null;
if ($currentEmail == null) {
    header('location:../../index.php');
    exit;
}

$stmt = $conn->query("SELECT * FROM users where email='$currentEmail'");
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

// print_r($currentUser);
if ($currentUser["role_id"] != 1) {
    header("location:../../error.php");
}

$id = $_GET['id'];
$stmt = $conn->query("SELECT * from users where id ='$id'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($id) && $currentUser["role_id"] == 1) {
    unlink($users['image_path']);
    $delete = $conn->exec("DELETE FROM users  WHERE id=$id");
    header('location:../../../../user/index.php');
} else {
    header('location:../../../index.php');
}
