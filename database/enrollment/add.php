<?php

$errors = [];

// require_once '../connection.php';

if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'] ?? null;
    $user_id = $_POST['user_id'] ?? null;
    $is_active = $_POST["is_active"] ?? null;

    $stmt = $conn->query("SELECT count(*) as count from enrollments where user_id=$user_id");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result["count"] > 0) {
        $errors["user_id"] = 'This user is already enrolled.';
    }

    if (empty($errors)) {
        $addData = $conn->exec("INSERT INTO enrollments(user_id, course_id, is_active, enrolled_at) value($user_id, $course_id, $is_active, now())");
        if ($addData) {
            header('location:../../../../user/enrollment.php');
            exit;
        }
    }
}
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p id='message' style='color: red;'>$error</p>";
    }
}
