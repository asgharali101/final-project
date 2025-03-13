<?php

$errors = [];
$priviousEmail = $_SESSION['user']['email'] ?? null;


$stmt = $conn->query("SELECT * from users where email ='$priviousEmail'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);
$currentEmail = $users["email"];
$id = $users['id'];
if ($priviousEmail == null) {
    header('location:../index.php');
}

if (! isset($id) || $id == null) {
    header('location:../index.php');
}


if (isset($_POST['email'])) {
    $firstName = $_POST['first_name'] ?? null;
    $lastName = $_POST['last_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $users['password'] ?? null;
    $date_of_birth = $_POST['date_of_birth'] ?? null;
    $address = $_POST['address'] ?? null;
    $role_id = $users["role_id"];
    $is_active = $users["is_active"];


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


    $date_of_birth_obj = DateTime::createFromFormat('Y-m-d', $date_of_birth);
    $today = new DateTime();
    $min_age_date = (new DateTime())->modify('-10 years');

    if (!$date_of_birth_obj || $date_of_birth_obj->format('Y-m-d') !== $date_of_birth) {
        $errors['date_of_birth'] = 'Invalid date format (use YYYY-MM-DD).';
    } elseif ($date_of_birth_obj > $today) {
        $errors['date_of_birth'] = 'Date of birth cannot be in the future.';
    } elseif ($date_of_birth_obj > $min_age_date) {
        $errors['date_of_birth'] = 'You must be at least 10 years old.';
    }

    if ($_FILES['newImage']['size'] > 2 * 1024 * 1024) {
        $errors['newImage'] = 'Image size must be 2MB or less.';
    }



    $filename = $_FILES['newImage']['name'];
    $fileType = pathinfo($filename, PATHINFO_EXTENSION);
    $allowedTypes = ['png', 'jpeg', 'jpg'];

    if (! empty($filename)) {
        if (! in_array(strtolower($fileType), $allowedTypes)) {
            $errors['newImage'] = 'Image extension type must be png, jpeg, jpg.';
        }
    } else {
        $filePath = $users['image_path'];
    }



    try {
        $stmt = $conn->query("SELECT count(*) as count from users where email='$currentEmail' AND id != $id");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result["count"] > 0) {
            $errors["email"] = 'Email already be use' ?? null;
        } else {
            if (empty($errors)) {
                if (! empty($filename)) {
                    $filePath = '../uploads/' . $filename;
                    if (move_uploaded_file($_FILES['newImage']['tmp_name'], $filePath)) {
                        if (! empty($user['image_path']) && file_exists($user['image_path'])) {
                            unlink($users['image_path']);
                        }
                    }
                }

                $addData = $conn->exec("UPDATE users SET role_id =$role_id, first_name='$firstName', last_name='$lastName', email='$email', password='$password', date_of_birth='$date_of_birth', image_path='$filePath', address='$address', is_active=$is_active  where email='$currentEmail'");
                header('location:./profile.php');
                $_SESSION['user'] = [
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'role_id' => $role_id,
                ];
            }
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $errors["email"] = 'Email already in use. Please choose another.';
        } else {
            $errors["database"] = 'An unexpected error occurred. Please try again.';
        }
    }
}
