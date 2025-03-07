<?php

session_start();
require_once '../connection.php';

$priviousEmail = $_SESSION['user']['email'] ?? null;

if ($priviousEmail === null) {
    header('location:../../index.html');
    exit;
}
$userStmt = $conn->query("SELECT users.*, roles.role as role_name FROM users JOIN roles ON users.role_id = roles.id WHERE email='$priviousEmail'");
$users = $userStmt->fetch(PDO::FETCH_ASSOC);

$role_id = $users['role_id'] ?? null;

$categoryStmt = $conn->query('SELECT * FROM categories');
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);


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

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body>
    <?php require_once '../particions/nav.php' ?>
    <?php require_once '../particions/sidebar.php' ?>
    <!-- profile -->
    <div id="app" class="py-4" x-data="{showCategory:false}">

        <?php if ($role_id == 1) { ?>

            <button @click="showCategory = !showCategory" class="mt-6 mb-4 ml-10 button green">
                Add Category
            </button>

            <div class="mb-4 card" x-show="showCategory" x-transition x-cloak @click.outside="showCategory = false">
                <header class="card-header">
                    <p class="card-header-title">
                        <span class="icon"><i class="mdi mdi-account-circle"></i></span>
                        Add Category
                    </p>
                </header>
                <div class="card-content">
                    <form method="POST" action="../database/category/add.php">

                        <div class="control">
                            <label class="label">New Category</label>
                            <div class="relative">
                                <!-- Icon -->
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M5 2a2 2 0 00-2 2v1a2 2 0 002 2h10a2 2 0 002-2V4a2 2 0 00-2-2H5zM4 8a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2H4zm2 2h4v4H6v-4z" />
                                    </svg>
                                </span>
                                <!-- Input Field -->
                                <input
                                    type="text"
                                    name="category"
                                    value="<?php echo $_POST["category"] ?? null ?>"
                                    placeholder="Enter category name"
                                    class="pl-10 input" />
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
        <?php } ?>


        <section class="pt-0 section main-section">
            <div class="card has-table">
                <header class="card-header">
                    <p class="card-header-title">
                        <span class="icon"><i class="mdi mdi-buffer"></i></span>
                        Categories
                    </p>
                </header>
                <?php if (count($categories) != 0) { ?>
                    <div class="overflow-x-auto ">
                        <table class="w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">ID</th>
                                    <th class="px-4 py-2">Name</th>
                                    <?php if ($role_id == 1) { ?>
                                        <th class="px-4 py-2 text-left">Actions</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category) { ?>
                                    <tr class="">
                                        <td class="px-4 py-2 border"><?= $category['id'] ?? '' ?></td>
                                        <td class="px-4 py-2 border"><?= $category['name'] ?? '' ?></td>
                                        <?php if ($role_id == 1) { ?>
                                            <td class="px-4 py-2 border actions-cell">
                                                <div class="buttons">
                                                    <a href="../database/category/edit.php?id=<?= $category['id'] ?>"
                                                        class="button small green">
                                                        <span class="icon"><i class="mdi mdi-pencil"></i></span>
                                                    </a>
                                                    <a href="../database/category/delete.php?id=<?= $category['id'] ?>"
                                                        class="button small red">
                                                        <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                                                    </a>
                                                </div>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="card empty">
                        <div class="card-content">
                            <div>
                                <span class="icon large"><i class="mdi mdi-emoticon-sad mdi-48px"></i></span>
                            </div>
                            <p>No category found here…</p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>

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