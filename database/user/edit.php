<?php

require_once '../../connection.php';
$error = '';
session_start();
$priviousEmail = $_SESSION['user']['email'] ?? null;
if ($priviousEmail == null) {
    header('location:../../index.php');
}
$stmt = $conn->query("SELECT * from users where email ='$priviousEmail'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);


$id = $users['id'];

if (! isset($id) || $id == null) {
    header("location:../../error.php");
    exit;
}

if (isset($_POST['email'])) {
    $firstName = $_POST['first_name'] ?? null;
    $lastName = $_POST['last_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $users['password'] ?? null;
    $date_of_birth = $_POST['date_of_birth'] ?? null;
    $address = $_POST['address'] ?? null;
    $role_id = $_POST['role_id'] ?? null;

    $filename = $_FILES['newImage']['name'];
    $fileType = pathinfo($filename, PATHINFO_EXTENSION);
    $allowedTypes = ['png', 'jpeg', 'jpg'];
    $filePath = $users['image_path'];

    $stmt = $conn->query("SELECT * from users where email='$priviousEmail' AND id != $id");
    $result = $stmt->fetch(PDO::FETCH_OBJ);

    if ($result) {
        echo $error = 'Email already be use' ?? null;
    } else {
        if (in_array($fileType, $allowedTypes)) {
            $filePath = '../../uploads/' . $filename;
            if (move_uploaded_file($_FILES['newImage']['tmp_name'], $filePath)) {
                if (! empty($user['image_path']) && file_exists($user['image_path'])) {
                    unlink($users['image_path']);
                }
            }
        }

        $_SESSION['user'] = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'role_id' => $role_id,
        ];

        $addData = $conn->exec("UPDATE users SET role_id =$role_id, first_name='$firstName', last_name='$lastName', email='$email', password='$password' , date_of_birth='$date_of_birth', image_path='$filePath', address='$address'  where email='$priviousEmail'");
        header('location:../../../../user/profile.php');
    }
} else {
    header('location:../../../../user/profile.php');
}
