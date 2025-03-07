<?php

require_once '../connection.php';
$error = '';
session_start();

$priviousEmail = $_SESSION['user']['email'] ?? null;


$stmt = $conn->query("SELECT * from users where email ='$priviousEmail'");
$previousUser = $stmt->fetch(PDO::FETCH_ASSOC);

if ($priviousEmail == null) {
    header('location:../../index.html');
    exit;
}


$id = $_GET['id'] ?? null;
if (! isset($id) || $previousUser["role_id"] != 1) {
    header('location:../../../error.php');
    exit;
}

$stmt = $conn->query("SELECT * from users where id =$id");
$users = $stmt->fetch(PDO::FETCH_ASSOC);

$currentEmail = $users['email'] ?? null;

$rolestmt = $conn->query('SELECT * from roles');
$roles = $rolestmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submit']) && ! empty($_POST['email']) && ! empty($_POST['role_id']) && ! empty($_POST['date_of_birth'])) {
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

    $stmt = $conn->query("SELECT count(*) as count from users where email='$currentEmail' AND id != $id");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        $error = 'Email already be use' ?? null;
    } else {
        if (in_array($fileType, $allowedTypes)) {
            $filePath = '../../uploads/' . $filename;
            if (move_uploaded_file($_FILES['newImage']['tmp_name'], $filePath)) {
                if (! empty($user['image_path']) && file_exists($user['image_path'])) {
                    unlink($users['image_path']);
                }
            }
        }



        $addData = $conn->exec("UPDATE users SET role_id =$role_id, first_name='$firstName', last_name='$lastName', email='$email', password='$password' , date_of_birth='$date_of_birth', image_path='$filePath', address='$address'  where id=$id");
        header('location:../../../../user/index.php');
    }
}



?>



<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Admin One Tailwind CSS Admin Dashboard</title>

    <!-- Tailwind is included -->
    <link rel="stylesheet" href="css/main.css?v=1628755089081" />

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png" />
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#00b4b6" />

    <meta name="description" content="Admin One - free Tailwind dashboard" />

    <meta
        property="og:url"
        content="https://github.com/asgharali101" />
    <meta property="og:site_name" content="asghar.me" />
    <meta property="og:title" content="Admin One HTML" />
    <meta
        property="og:description"
        content="Admin One - free Tailwind dashboard" />

    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="1920" />
    <meta property="og:image:height" content="960" />

    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="Admin One HTML" />
    <meta
        property="twitter:description"
        content="Admin One - free Tailwind dashboard" />
    <meta
        property="twitter:image:src"
        content="https://justboil.me/uploads/one-tailwind/repository-preview-hi-res.png" />
    <meta property="twitter:image:width" content="1920" />
    <meta property="twitter:image:height" content="960" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script
        async
        src="https://www.googletagmanager.com/gtag/js?id=UA-130795909-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());
        gtag("config", "UA-130795909-1");
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <?php require_once '../particions/nav.php' ?>
    <?php require_once '../particions/sidebar.php' ?>
    <p id="message"><?php echo $error ?? null ?></p>
    <!-- profile -->
    <div id="app" class="">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-account-circle"></i></span>
                    Edit Profile
                </p>
            </header>
            <div class="card-content">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="field">
                        <div class="mx-auto w-[1rem] h-04">
                        </div>
                        <div class="w-48 h-48 mx-auto image">
                            <img
                                src="<?php echo (!empty($users['image_path'])
                                            ? $users['image_path']
                                            : 'https://ui-avatars.com/api/?name=' . urlencode($user['first_name'] ?? 'User')); ?>"

                                class="h-32 rounded-full w-36" />
                        </div>
                        <hr />
                        <label class="label">Avatar</label>
                        <div class="field-body">
                            <div class="field file">
                                <label class="upload control">
                                    <a class="button blue"> Upload </a>
                                    <input type="file" name="newImage" />
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="flex justify-between">
                        <div class="field">
                            <label class="label">First Name</label>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input
                                            type="text"
                                            autocomplete="on"
                                            name="first_name"
                                            value="<?= $users['first_name'] ?? null ?>"
                                            class="input"
                                            required />
                                    </div>
                                    <p class="help">Required. Your first name</p>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Last Name</label>
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input
                                            type="text"
                                            autocomplete="on"
                                            name="last_name"
                                            value="<?= $users['last_name'] ?? null ?>"
                                            class="input"
                                            required />
                                    </div>
                                    <p class="help">Required. Your last name</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">E-mail</label>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input
                                        type="email"
                                        autocomplete="on"
                                        name="email"
                                        value="<?= $users['email'] ?? null ?>"
                                        class="input"
                                        required />
                                </div>
                                <p class="help">Required. Your e-mail</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between field">
                        <div class="control">
                            <label class="label">role_id</label>
                            <select
                                class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md"
                                name="role_id"
                                id="role_id">
                                <?php if (! empty($roles)) {
                                ?>
                                    <?php foreach ($roles as $role) { ?>
                                        <option value="<?php echo $role['id'] ?? null; ?>"
                                            <?php echo (isset($users['role_id']) && $role['id'] === $users['role_id']) ? 'selected' : ''; ?>>
                                            <?php echo $role['role'] ?? 'Unknown'; ?>
                                        </option>
                                    <?php } ?>
                                <?php } else { ?>
                                    <option value="" disabled>No roles available</option>
                                <?php } ?>
                            </select>


                        </div>
                        <div class="control">
                            <label class="label">Date Of Birth</label>
                            <input
                                type="date"
                                name="date_of_birth"
                                value="<?php echo $users['date_of_birth'] ?>"
                                class="input is-static" />
                        </div>
                    </div>


                    <div class="field">
                        <label class="label">
                            <Address>Address</Address>
                        </label>
                        <div class="control">
                            <textarea required name="address" class="input is-static"><?= $users['address'] ?? null ?></textarea>

                        </div>
                    </div>


                    <hr />
                    <div class="field">
                        <div class="control">
                            <button type="submit" name="submit" class="button green">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="w-full">
        <?php require_once '../particions/footer.php' ?>

    </div>

    <!-- Scripts below are for demo only -->
    <script
        type="text/javascript"
        src="js/main.min.js?v=1628755089081"></script>

    <script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script type="text/javascript" src="js/chart.sample.min.js"></script>

    <script>
        setTimeout(() => {
            const messageDiv = document.getElementById('message');
            if (messageDiv) {
                messageDiv.style.display = 'none';
            }
        }, 10000);
    </script>

    <script>
        !(function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) :
                    n.queue.push(arguments);
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = "2.0";
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s);
        })(
            window,
            document,
            "script",
            "https://connect.facebook.net/en_US/fbevents.js"
        );
        fbq("init", "658339141622648");
        fbq("track", "PageView");
    </script>
    <noscript><img
            height="1"
            width="1"
            style="display: none"
            src="https://www.facebook.com/tr?id=658339141622648&ev=PageView&noscript=1" /></noscript>

    <!-- Icons below are for demo only. Feel free to use any icon pack. Docs: https://bulma.io/documentation/elements/icon/ -->
    <link
        rel="stylesheet"
        href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css" />
</body>

</html>