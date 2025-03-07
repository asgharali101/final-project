<?php

require_once '../../connection.php';
session_start();
$currentEmail = $_SESSION["user"]["email"] ?? null;
if ($currentEmail == null) {
    header('location:../../index.html');
    exit;
}
$stmt = $conn->query("SELECT * FROM users where email='$currentEmail'");
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentUser["role_id"] != 1) {
    header("location:../../error.php");
}

$id = $_GET['id'];
$stmt = $conn->query("SELECT * from topics where id =$id");
$topics = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($id)) {
    unlink($topics['video_path']);
    unlink($topics['attachment_path']);

    $delete = $conn->exec("DELETE FROM topics  WHERE id=$id");
    header('location:../../../../user/topics.php');
} else {
    header('location:../../../../user/topics.php');
}
