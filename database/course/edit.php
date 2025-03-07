<?php

require_once '../../connection.php';
$error = '';
session_start();
$priviousEmail = $_SESSION['user']['email'] ?? null;

if ($priviousEmail == null) {
    header('location:../../index.html');
    exit;
}
$stmt = $conn->query("SELECT * from users where email ='$priviousEmail'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);

$role_id = $users["role_id"] ?? null;
$id = $_GET['id'] ?? null;

if (! $id || $users["role_id"] != 1) {
    header("location:../../error.php");
}


$stmt = $conn->query("SELECT * from courses where id =$id");
$courses = $stmt->fetch(PDO::FETCH_ASSOC);



$stmt = $conn->query("SELECT * from categories");
$allCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"] ?? null;
    $description = $_POST["description"] ?? null;
    $category_id = $_POST['category_id'] ?? null;

    $filePath = $courses["feature_image"] ?? null;

    $fileName = $_FILES["feature_image"]["name"] ?? null;
    $newName = sha1(time());
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION) ?? null;
    $allowedTypes = ["png", "jpeg", "jpg"];

    if (in_array($fileExtension, $allowedTypes)) {
        $filePath = "../../uploads/" . $newName . "." . $fileExtension;
        if (move_uploaded_file($_FILES["feature_image"]["tmp_name"], $filePath)) {
            if (file_exists($users["feature_image"]) && ! empty($users["feature_image"])) {
                unlink($courses["feature_image"]);
            }
        }
    }
    $addData = $conn->exec("UPDATE courses SET title ='$title', description='$description',feature_image='$filePath', category_id='$category_id', created_at=NOW()  where id=$id");
    header('location:../../../../user/courses.php');
} else {
    $error = " All fields are required. Please fill out the missing fields";
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
    <?php require_once("../../particions/nav.php") ?>
    <?php require_once("./sidebar.php") ?>
    <p id="message" class="text-red-500 "><?php echo $error ?? null ?></p>
    <!-- profile -->
    <div id="app" class="flex justify-center mt-6">
        <div class="px-auto card md:w-4/5">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="mdi mdi-school"></i></span>
                    Edit courses
                </p>
            </header>
            <div class="card-content">
                <form method="POST" class="flex flex-col space-y-4" action="" enctype="multipart/form-data">
                    <div class="control">
                        <label class="label">Course Name</label>
                        <input type="text" name="title" value="<?= $courses["title"] ?? null ?>" placeholder="Enter course name" class="input" />
                    </div>

                    <div class="control">
                        <label class="label">Course Description</label>
                        <textarea name="description" value="<?= $courses["description"] ?? null ?>" placeholder="Enter course description" class="textarea"><?= $courses["description"] ?? null ?></textarea>
                    </div>

                    <div class="flex items-center justify-start w-48 h-48 image">
                        <img
                            src="<?php echo $courses['feature_image'] ?? null ?>"
                            class="h-32 rounded-full w-36" />
                    </div>
                    <div class="control">
                        <label class="label">feature_image</label>
                        <input type="file" name="feature_image" class="input" />
                    </div>

                    <div class="">
                        <label class="label">Category</label>
                        <div class="select">
                            <select name="category_id">
                                <?php foreach ($allCategories as $category) { ?>
                                    <option <?php if ($category["id"] == $courses["category_id"]) { ?> selected <?php } ?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="mt-2 field">
                        <div class="control">
                            <button type="submit" name="submit" class="button green">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="w-full">
        <?php require_once '../../particions/footer.php' ?>

    </div>
    4
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