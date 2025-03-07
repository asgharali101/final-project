<?php

require_once '../../connection.php';
$error = '';
session_start();
$currentEmail = $_SESSION["user"]["email"] ?? null;
if ($currentEmail == null) {
    header('location:../../index.html');
    exit;
}

$stmt = $conn->query("SELECT * FROM users where email='$currentEmail'");
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentUser["role_id"] !== 1) {
    header("location:../../error.php");
}


if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'] ?? null;
    $user_id = $_POST['user_id'] ?? null;

    $addData = $conn->exec("INSERT INTO enrollments(user_id,course_id,enrolled_at) value($user_id,$course_id,now())");
    if ($addData) {
        header('location:../../../../user/enrollment.php');
    }
}
