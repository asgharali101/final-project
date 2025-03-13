<?php

require_once '../../connection.php';
session_start();
$priviousEmail = $_SESSION['user']['email'] ?? null;


if ($priviousEmail == null) {
    header('location:../../index.html');
}

$stmt = $conn->query("SELECT * from users where email ='$priviousEmail'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);

if ($users["role_id"] != 1) {
    header("location:../../error.php");
    exit;
}

$id = $_GET['id'];
$stmt = $conn->query("SELECT * from categories where id ='$id'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($id)) {
    $delete = $conn->exec("DELETE FROM categories  WHERE id=$id");
    header('location:../../../../user/category.php');
} else {
    header('location:../../../../user/category.php');
}
