<?php

require_once '../../connection.php';
$error = '';
session_start();
$currentEmail = $_SESSION["user"]["email"] ?? null;
if ($currentEmail == null) {
    header('location:../../index.html');
}

$stmt = $conn->query("SELECT * FROM users where email='$currentEmail'");
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

$id = $_GET['id'] ?? null;

if ($currentUser["role_id"] != 1 || $id == null) {
    header("location:../../error.php");
}



$stmt = $conn->query("SELECT * from enrollments where id =$id");
$currentEnroll = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->query('SELECT * FROM users');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query('SELECT * FROM courses');
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);



if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'] ?? null;
    $user_id = $_POST['user_id'] ?? null;

    $addData = $conn->exec("UPDATE enrollments SET user_id =$user_id, course_id=$course_id,enrolled_at=now()  where id=$id");
    if ($addData) {
        header('location:../../../../user/enrollment.php');
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
    require_once("../../particions/nav.php");
    require_once("./sidebar.php");
    ?>
    <p id="message"><?php echo $error ?? null ?></p>

    <div class="mb-10 card">
        <header class="card-header">
            <p class="card-header-title">
                <span class="icon"><i class="mdi mdi-school"></i></span>
                Add Enrollment
            </p>
        </header>
        <div class=" card-content">
            <form method="POST" class="flex flex-col space-y-4" action="">
                <div class="">
                    <div class="select">
                        <div class="control">
                            <label class="label">Select Users</label>
                            <select name="user_id">
                                <?php foreach ($users as $user) { ?>
                                    <option <?php if ($currentEnroll["user_id"] == $user["id"]) { ?> selected <?php } ?> value="<?= $user['id'] ?>"><?= $user['first_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="">
                    <div class="select">
                        <div class="control">
                            <label class="label">Select Course</label>
                            <select name="course_id">
                                <?php foreach ($courses as $course) { ?>
                                    <option <?php if ($currentEnroll["course_id"] == $course["id"]) { ?> selected <?php } ?> value="<?= $course['id'] ?>"><?= $course['title'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                </div>

        </div>

        <div class="mt-2 field">
            <div class="control">
                <button type="submit" name="submit" class="button green">Submit</button>
            </div>
        </div>
        </form>
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