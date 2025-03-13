<?php

$errors = [];
$priviousEmail = $_SESSION['user']['email'] ?? null;
// print_r($priviousEmail);
// exit;
if ($priviousEmail == null || isset($id)) {
    header('location:../index.php');
}
$stmt = $conn->query("SELECT * from users where email ='$priviousEmail'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);

$id = $users['id'];

if (! isset($id) || $id == null) {
    header('location:../index.php');
}
// print_r($id);
// exit;

if (isset($_POST['email'])) {
    $firstName = $_POST['first_name'] ?? null;
    $lastName = $_POST['last_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $users['password'] ?? null;
    $date_of_birth = $_POST['date_of_birth'] ?? null;
    $address = $_POST['address'] ?? null;
    $role_id = $_POST['role_id'] ?? null;


    if (empty($_POST['first_name']) || strlen($_POST['first_name']) > 20) {
        $errors['first_name'] = 'First name is required and must be less than 20 characters.';
    }

    if (empty($_POST['last_name']) || strlen($_POST['last_name']) > 20) {
        $errors['last_name'] = 'Last name is required and must be less than 20 characters.';
    }

    if (empty($_POST['email']) || strlen($_POST['email']) > 40) {
        $errors['email'] = 'Email is required and must be less than 40 characters.';
    }



    if (empty($_POST['address']) || strlen($_POST['address']) > 500) {
        $errors['address'] = 'address is required and must be less than 500 characters.';
    }


    // if (!DateTime::createFromFormat('d-m-Y', $date_of_birth)) {
    //     $errors['date_of_birth'] = 'Invalid date format';
    // }

    if ($_FILES['newImage']['size'] > 2 * 1024 * 1024) {
        $errors['newImage'] = 'Image size must be 2MB or less.';
    }



    $filename = $_FILES['newImage']['name'];
    $fileType = pathinfo($filename, PATHINFO_EXTENSION);
    $allowedTypes = ['png', 'jpeg', 'jpg'];
    $filePath = $users['image_path'];

    $stmt = $conn->query("SELECT * from users where email='$priviousEmail' AND id != $id");
    $result = $stmt->fetch(PDO::FETCH_OBJ);

    if (empty($errors)) {
        if ($result) {
            echo $errors["email"] = 'Email already be use' ?? null;
        } else {
            if (in_array($fileType, $allowedTypes)) {
                $filePath = '../uploads/' . $filename;
                if (move_uploaded_file($_FILES['newImage']['tmp_name'], $filePath)) {
                    if (! empty($user['image_path']) && file_exists($user['image_path'])) {
                        unlink($users['image_path']);
                    }
                }
            } else {
                $errors['newImage'] = 'Image extension type must be png, jpeg, jpg.';
            }

            $_SESSION['user'] = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'role_id' => $role_id,
            ];

            $addData = $conn->exec("UPDATE users SET role_id =$role_id, first_name='$firstName', last_name='$lastName', email='$email', password='$password' , date_of_birth='$date_of_birth', image_path='$filePath', address='$address'  where email='$priviousEmail'");
            header('location:./profile.php');
        }
    }
}
