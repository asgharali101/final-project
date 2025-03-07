<?php

require_once '../../connection.php';
$error = '';
session_start();
$priviousEmail = $_SESSION['user']['email'] ?? null;
if ($priviousEmail == null) {
    header('location:../../index.html');
    exit;
}

$stmt = $conn->query("SELECT * from users where email ='$priviousEmail'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);


if ($users["role_id"] != 1) {
    header("location:../../error.php");
}

if (isset($_POST['category'])) {
    $category = $_POST['category'] ?? null;
    $addData = $conn->exec("INSERT INTO categories(name) value('$category')");
    header('location:../../../../user/category.php');
}
