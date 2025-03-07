<?php
require_once '../../connection.php';
ob_start();
session_start();
$priviousEmail = $_SESSION['user']['email'] ?? null;

if ($priviousEmail === null) {
    header('location:../../index.html');
    exit;
}
$stmt = $conn->query("SELECT * from users where email ='$priviousEmail'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);

if ($users["role_id"] != 1) {
    header("location:../../error.php");
}
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $category_id = $_POST['category_id'] ?? null;

    $fileName = $_FILES["feature_image"]["name"] ?? null;
    $newName = sha1(time());
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowedTypes = ["png", "jpeg", "jpg"];

    if (in_array($fileExtension, $allowedTypes)) {
        $filePath = "../../uploads/" . $newName . "." . $fileExtension;
        if (move_uploaded_file($_FILES["feature_image"]["tmp_name"], $filePath)) {
            $sql = $conn->exec("INSERT INTO courses (title, description, feature_image, category_id, created_at) 
                VALUES ('$title', '$description', '$filePath', '$category_id', NOW())");

            if ($sql) {
                $success = 'Course added successfully';
                header('location:../../user/courses.php');
            } else {
                $error = 'Failed to add';
            }
        }
    }
}

$categorystmt = $conn->query('SELECT * FROM categories');
$categories = $categorystmt->fetchAll(PDO::FETCH_ASSOC);
