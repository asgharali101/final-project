<?php


$userEmail = $_SESSION["user"]["email"] ?? null;



$stmt = $conn->query("SELECT * FROM users where email='$userEmail'");
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title']) && $currentUser["role_id"] != 1) {
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $content = $_POST['content'] ?? null;
    $course_id = $_POST['course_id'] ?? null;

    if (empty($_POST['title']) || strlen($_POST['title']) > 100) {
        $errors['title'] = 'title is required and must be less than 100 characters.';
    }

    if (empty($_POST['description']) || strlen($_POST['description']) > 3000) {
        $errors['description'] = 'description is required and must be less than 3000 characters.';
    }

    if (empty($_POST['content']) || strlen($_POST['content']) > 3000) {
        $errors['content'] = 'description is required and must be less than 3000 characters.';
    }

    if ($_FILES['attachment_path']['size'] > 2 * 1024 * 1024) {
        $errors['attachment_path'] = 'attachment size must be 2MB or less.';
    }

    if ($_FILES['video_path']['size'] > 10 * 1024 * 1024) {
        $errors['video_path'] = 'video size must be 10MB or less.';
    }

    $videoName = $_FILES["video_path"]["name"] ?? null;
    $attachmentName = $_FILES["attachment_path"]["name"] ?? null;

    $videoExtension = pathinfo($videoName, PATHINFO_EXTENSION);
    $attachmentExtension = pathinfo($attachmentName, PATHINFO_EXTENSION);

    // print_r($videoExtension);
    // exit;
    $fileName = sha1(time());

    $videoPath = '';
    $videoAllowedTypes = ["mp4", "webm",];
    if (empty($errors)) {

        if (in_array($videoExtension, $videoAllowedTypes)) {
            if (isset($_FILES['video_path']) && $_FILES['video_path']['error'] == 0) {
                $videoPath = '../uploads/' . $fileName . "." . $videoExtension;
                move_uploaded_file($_FILES['video_path']['tmp_name'], $videoPath);
            }
        } else {
            $errors['video_path'] = 'video extension type must be mp4/webm .';
        }

        $attachmentPath = '';
        $attachmentAllowedTypes = ["pdf", "csv", "xls", "xlsx", "jpeg", "jpg", "png", "gif", "svg", "webp"];

        if (in_array($attachmentExtension, $attachmentAllowedTypes)) {
            if (isset($_FILES['attachment_path']) && $_FILES['attachment_path']['error'] == 0) {
                $attachmentPath = '../uploads/' . $fileName . "." . $attachmentExtension;
                move_uploaded_file($_FILES['attachment_path']['tmp_name'], $attachmentPath);
            }
        } else {
            $errors['attachment_path'] = 'attachment extension type must be pdf, csv, xls, xlsx, jpeg, jpg, png, gif, svg,webp';
        }

        if (empty($errors)) {
            $query = $conn->exec("INSERT INTO topics (title, description, content, video_path, attachment_path,created_at, course_id) 
            VALUES ('$title', '$description', '$content', '$videoPath', '$attachmentPath',now(), $course_id)");
            if ($query) {
                header("location:./topics.php");
            }
        }
    }
}
