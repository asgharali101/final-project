<?php
require_once("../../connection.php");
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'])) {
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $content = $_POST['content'] ?? null;
    $course_id = $_POST['course_id'] ?? null;

    $videoName = $_FILES["video_path"]["name"] ?? null;
    $attachmentName = $_FILES["attachment_path"]["name"] ?? null;

    $videoExtension = pathinfo($videoName, PATHINFO_EXTENSION);
    $attachmentExtension = pathinfo($attachmentName, PATHINFO_EXTENSION);

    // print_r($videoExtension);
    // exit;
    $fileName = sha1(time());

    $videoPath = '';
    $videoAllowedTypes = ["mp4", "webm",];
    if (in_array($videoExtension, $videoAllowedTypes)) {
        if (isset($_FILES['video_path']) && $_FILES['video_path']['error'] == 0) {
            $videoPath = '../../uploads/' . $fileName . "." . $videoExtension;
            move_uploaded_file($_FILES['video_path']['tmp_name'], $videoPath);
        }
    }

    $attachmentPath = '';
    $attachmentAllowedTypes = ["pdf", "csv", "xls", "xlsx", "jpeg", "jpg", "png", "gif", "svg", "webp"];

    if (in_array($attachmentExtension, $attachmentAllowedTypes)) {
        if (isset($_FILES['attachment_path']) && $_FILES['attachment_path']['error'] == 0) {
            $attachmentPath = '../../uploads/' . $fileName . "." . $attachmentExtension;
            move_uploaded_file($_FILES['attachment_path']['tmp_name'], $attachmentPath);
        }
    }


    $query = $conn->exec("INSERT INTO topics (title, description, content, video_path, attachment_path,created_at, course_id) 
            VALUES ('$title', '$description', '$content', '$videoPath', '$attachmentPath',now(), $course_id)");
    if ($query) {
        header("location:../../../../user/topics.php");
    }
}
