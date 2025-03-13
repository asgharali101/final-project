<?php
$priviousEmail = $_SESSION['user']['email'] ?? null;

if ($priviousEmail === null) {
    header('location:../index.html');
    exit;
}
$stmt = $conn->query("SELECT * from users where email ='$priviousEmail'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);

// if ($users["role_id"] != 1) {
//     header("location:../../error.php");
// }
$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $users["role_id"] == 1) {
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $category_id = $_POST['category_id'] ?? null;
    $is_active = $_POST["is_active"] ?? 0;

    if (empty($_POST['title']) || strlen($_POST['title']) > 100) {
        $errors['title'] = 'title is required and must be less than 100 characters.';
    }

    if (empty($_POST['description']) || strlen($_POST['description']) > 3000) {
        $errors['description'] = 'description is required and must be less than 3000 characters.';
    }

    if ($_FILES['feature_image']['size'] > 2 * 1024 * 1024) {
        $errors['feature_image'] = 'Image size must be 2MB or less.';
    }
    $fileName = $_FILES["feature_image"]["name"] ?? null;
    $newName = sha1(time());
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowedTypes = ["png", "jpeg", "jpg"];

    if (! in_array($fileExtension, $allowedTypes)) {
        $errors['feature_image'] = 'Image type must be PNG, JPEG, JPG.';
    }

    if (empty($errors)) {
        $filePath = "../uploads/" . $newName . "." . $fileExtension;
        if (move_uploaded_file($_FILES["feature_image"]["tmp_name"], $filePath)) {
            $sql = $conn->exec("INSERT INTO courses (title, description, feature_image, category_id, created_at, is_active) 
                VALUES ('$title', '$description', '$filePath', '$category_id', NOW(), $is_active)");

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
