<?php

require_once '../../connection.php';
$errors = [];
session_start();
$priviousEmail = $_SESSION['user']['email'] ?? null;
if ($priviousEmail === null) {
    header('location:../../index.html');
}

$stmt = $conn->query("SELECT * from users where email ='$priviousEmail'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);


$id = $_GET['id'] ?? null;
if (! $id  || $users["role_id"] != 1) {
    header("location:../../error.php");
    exit;
}

$stmt = $conn->query("SELECT * from roles where id =$id");
$roles = $stmt->fetch(PDO::FETCH_ASSOC);



if (isset($_POST['role'])) {
    $role = $_POST['role'] ?? null;
    if (empty($_POST['role']) || strlen($_POST['role']) > 30) {
        $errors['role'] = 'role is required and must be less than 30 characters.';
    }
    if (empty($errors)) {

        $addData = $conn->exec("UPDATE roles SET role ='$role'  where id=$id");
        header('location:../../../../user/role.php');
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
    <link rel="stylesheet" href="../../user/css/main.css?v=1628755089081" />

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png" />
    <link rel="icon" type="" sizes="16x16" href="../../uploads/A.png" />
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
        content="https://justboil.me/images/one-tailwind/repository-preview-hi-res.png" />
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
    <?php
    require_once("./nav.php");
    require_once("./sidebar.php");

    ?>
    <p id="message"><?php echo $error ?? null ?></p>
    <!-- profile -->
    <div class="flex items-center justify-center my-10">
        <div class="w-5/6 card">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-tag"></i></span>
                    Edit role
                </p>
            </header>
            <div class="card-content">
                <form action="" method="POST" enctype="multipart/form-data">

                    <div class="field">
                        <label class="label">role</label>
                        <div class="field-body">
                            <div class="field">
                                <div class="control">
                                    <input
                                        type="text"
                                        autocomplete="on"
                                        name="role"
                                        value="<?= $roles['role'] ?? null ?>"
                                        class="input"
                                        required />
                                    <p class="text-red-500" id="message"><?php echo $errors["role"] ?? null ?></p>

                                </div>
                                <p class="help">Required. Your roles</p>
                            </div>
                        </div>
                    </div>




                    <hr />
                    <div class="flex space-x-10 field">
                        <div class="control">
                            <button type="submit" name="submit" class="button green">Submit</button>
                        </div>
                        <div class="control">
                            <a href="../../user/role.php" class="button blue">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require_once("../../particions/footer.php");
    ?>

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