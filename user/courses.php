<?php

session_start();
require_once '../connection.php';
require_once '../database/course/add.php';


$priviousEmail = $_SESSION['user']['email'] ?? null;

if ($priviousEmail === null) {
    header('location:../../index.html');
    exit;
}

$userStmt = $conn->query("SELECT users.*, roles.role as role_name
FROM users
JOIN roles ON users.role_id = roles.id
WHERE email='$priviousEmail'");
$users = $userStmt->fetch(PDO::FETCH_ASSOC);


$role_id = $users['role_id'] ?? null;
$user_id = $users['id'] ?? null;


if ($role_id == 3) {
    $courseStmt = $conn->query(
        "SELECT courses.*, categories.name as category_name, COUNT(topics.id) as topic_count
        FROM courses
        JOIN categories ON courses.category_id = categories.id
        JOIN enrollments ON courses.id = enrollments.course_id
        LEFT JOIN topics ON courses.id = topics.course_id
        WHERE enrollments.user_id = $user_id
        GROUP BY courses.id"
    );
} else {
    $courseStmt = $conn->query(
        "SELECT courses.*, categories.name as category_name, COUNT(topics.id) as topic_count
        FROM courses
        JOIN categories ON courses.category_id = categories.id
        LEFT JOIN topics ON courses.id = topics.course_id
        GROUP BY courses.id"
    );
}

$courses = $courseStmt->fetchAll(PDO::FETCH_ASSOC);


$categoriesStmt = $conn->query('SELECT * from categories');
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);


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
        content="https://justboil.me/images/one-tailwind/repository-preview-hi-res.png" />
    <meta property="twitter:image:width" content="1920" />
    <meta property="twitter:image:height" content="960" />
    <link href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <?php require_once '../particions/nav.php' ?>
    <?php require_once '../particions/sidebar.php' ?>
    <div id="app" class="" x-data="{ showAddCourse: false }">
        <?php
        if ($role_id == 1) { ?>

            <button @click="showAddCourse = !showAddCourse" class="mt-6 mb-4 ml-10 button green">
                Add Course
            </button>

            <div x-show="showAddCourse" x-transition x-cloak @click.outside="showAddCourse = false" class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        <span class="icon"><i class="mdi mdi-school"></i></span>
                        Add courses
                    </p>
                </header>
                <div class=" card-content">
                    <form method="POST" class="flex flex-col space-y-4" action="" enctype="multipart/form-data">
                        <div class="control">
                            <label class="label">Course Name</label>
                            <input required type="text" name="title" value="<?php echo $_POST["title"] ?? null ?>" placeholder="Enter course name" class="input" />
                            <p class="text-red-500" id="message"><?php echo $errors["title"] ?? null ?></p>

                        </div>

                        <div class="control">
                            <label class="label">feature_image</label>
                            <input type="file" name="feature_image" class="input" />
                            <p class="text-red-500" id="message"><?php echo $errors["feature_image"] ?? null ?></p>

                        </div>

                        <div class="control">
                            <label class="label">Course Description</label>
                            <textarea name="description" placeholder="Enter course description" class="textarea"><?php echo $_POST["description"] ?? null ?></textarea>
                            <p class="text-red-500" id="message"><?php echo $errors["description"] ?? null ?></p>

                        </div>

                        <div class="">
                            <label class="label">Category</label>
                            <div class="select">
                                <select name="category_id">
                                    <?php foreach ($categories as $category) { ?>
                                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="mt-2 field">
                            <div class="control">
                                <button type="submit" name="submit" @click="showAddCourse = true" class="button green">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>

        <?php if (isset($courses) && $role_id == 1 || $role_id == 2) { ?>
            <section class="pt-6 section main-section bg-gray-50">
                <div class="container px-4 mx-auto">
                    <!-- Grid Layout -->
                    <div class="grid gap-6 sm:grid-cols-1 lg:grid-cols-2">
                        <?php foreach ($courses as $course) {
                            $course_id = $course['id'];
                            $enrollmentStmt = $conn->query("SELECT COUNT(*) AS student_count FROM enrollments WHERE course_id = $course_id");
                            $enrollments = $enrollmentStmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                            <!-- Course Card -->
                            <div class="p-4 transition-all bg-white border border-gray-200 rounded-lg shadow-lg hover:scale-100 hover:shadow-xl">
                                <!-- Course Image -->
                                <div class="relative overflow-hidden rounded-lg aspect-w-16 aspect-h-9">
                                    <a href="./topics.php?id=<?php echo $course["id"] ?? null ?>">
                                        <img src="<?= $course['feature_image'] ?? 'https://via.placeholder.com/300x200' ?>"
                                            class="object-cover w-full h-64 rounded-lg"
                                            alt="Course thumbnail">
                                    </a>
                                    <!-- Category Badge -->
                                    <span class="absolute px-3 py-1 text-xs font-bold text-gray-800 bg-white border border-gray-300 rounded-full shadow-md top-3 left-3">
                                        <?= $course['category_name'] ?? 'Uncategorized' ?>
                                    </span>
                                </div>

                                <!-- Course Content -->
                                <div class="">

                                    <!-- Info Section -->
                                    <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
                                        <!-- cate -->
                                        <span class="px-5 py-1 font-medium border border-gray-300 rounded-full ">
                                            <?= $course["category_name"] ?? null ?>
                                            <?php $course_id = $course["id"]; ?>
                                        </span>
                                        <!-- Price -->
                                        <span class="text-lg font-bold text-blue-700">
                                            <?= $course['price'] ?? 'Free' ?>
                                        </span>

                                    </div>

                                    <!-- Title -->
                                    <h6 class="py-2 text-lg font-bold text-gray-900 transition hover:text-blue-600 hover:text-primary">
                                        <a href="./topics.php?id=<?php echo $course["id"] ?? null ?>"
                                            class="line-clamp-2" aria-label="Course title">
                                            <?= $course['title'] ?? 'Untitled Course' ?>
                                        </a>
                                    </h6>

                                    <div class="flex items-center gap-2 mt-3">
                                        <div class="flex items-center gap-0.5 text-secondary">
                                            <!-- Star Icons -->
                                            <span><i class="text-yellow-400 ri-star-fill"></i></span>
                                            <span><i class="text-yellow-400 ri-star-fill"></i></span>
                                            <span><i class="text-yellow-400 ri-star-fill"></i></span>
                                            <span><i class="text-yellow-400 ri-star-fill"></i></span>
                                            <span><i class="text-gray-300 ri-star-line"></i></span>
                                        </div>
                                        <p class="area-description text-sm !leading-none text-gray-600 ">(10 Rating)</p>
                                    </div>


                                    <p class="mb-2 border-b"></p>
                                    <div class="flex items-center justify-between space-x-4 text-gray-600 ">
                                        <!-- Duration -->
                                        <div class="flex items-center">
                                            <i class="mr-1 text-base ri-time-line"></i>
                                            <span><?= $course['duration'] ?? 'N/A' ?></span>
                                        </div>
                                        <!-- Lessons -->
                                        <div class="flex items-center gap-x-3">
                                            <div class="flex items-center">
                                                <i class="mr-1 text-base ri-book-line"></i>
                                                <span><?= $course['topic_count'] . " Episodes" ?? '0 Lessons' ?></span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="mr-1 text-base ri-book-line"></i>
                                                <span><?= $enrollments["student_count"] . " Students" ?? '0 Lessons' ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Action Buttons (for Admins) -->
                                    <?php if ($role_id == 1) { ?>
                                        <div class="flex justify-between">
                                            <!-- Edit -->
                                            <a href="../database/course/edit.php?id=<?= $course['id'] ?>"
                                                class="text-blue-500 transition hover:text-blue-600">
                                                Edit
                                            </a>
                                            <!-- Delete -->
                                            <a href="../database/course/delete.php?id=<?= $course['id'] ?>"
                                                class="text-red-500 transition hover:text-red-600">
                                                Delete
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <!-- End Course Card -->
                        <?php } ?>
                    </div>
                </div>
            </section>

        <?php } else { ?>
            <div class="card empty">
                <div class="card-content">
                    <div>
                        <span class="icon large"><i class="mdi mdi-emoticon-sad mdi-48px"></i></span>
                    </div>
                    <p>Nothing's here…</p>
                </div>
            </div>
        <?php } ?>
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