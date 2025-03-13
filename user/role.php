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

$roleStmt = $conn->query('SELECT * FROM roles');
$roles = $roleStmt->fetchAll(PDO::FETCH_ASSOC);

if ($role_id != 1) {
    header("location:../../error.php");
}

if (isset($_POST['role'])) {
    $errors = [];
    $role = $_POST['role'] ?? null;
    if (empty($_POST['role']) || strlen($_POST['role']) > 30) {
        $errors['role'] = 'role is required and must be less than 30 characters.';
    }
    if (empty($errors)) {
        $addData = $conn->exec("INSERT INTO roles(role) value('$role')");
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
    <!-- profile -->
    <div id="app" class="py-4" x-data="{showrole:false}">

        <?php if ($role_id == 1) { ?>

            <button @click="showrole = !showrole" class="mt-6 mb-4 ml-10 button green">
                Add role
            </button>

            <div class="mb-4 card" x-show="showrole" x-transition x-cloak @click.outside="showrole = false">
                <header class="card-header">
                    <p class="card-header-title">
                        <span class="icon"><i class="mdi mdi-account-circle"></i></span>
                        Add role
                    </p>
                </header>
                <div class="card-content">
                    <form method="POST" action="">

                        <div class="control">
                            <label class="label">New role</label>
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
                                    name="role"
                                    value="<?php echo $_POST["role"] ?? null ?>"
                                    placeholder="Enter role name"
                                    class="pl-10 input" />
                                <p class="text-red-500"><?php echo $errors["role"] ?? null ?></p>
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


        <?php if ($role_id == 1 || $role_id == 2) { ?>
            <section class="pt-0 section main-section">
                <div class="card has-table">
                    <header class="card-header">
                        <p class="card-header-title">
                            <span class="icon"><i class="mdi mdi-buffer"></i></span>
                            roles
                        </p>
                    </header>
                    <?php if (count($roles) != 0) { ?>
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
                                    <?php foreach ($roles as $role) { ?>
                                        <tr class="">
                                            <td class="px-4 py-2 border"><?= $role['id'] ?? '' ?></td>
                                            <td class="px-4 py-2 border"><?= $role['role'] ?? '' ?></td>
                                            <?php if ($role_id == 1) { ?>
                                                <td class="px-4 py-2 border actions-cell">
                                                    <div class="buttons">
                                                        <a href="../database/role/edit.php?id=<?= $role['id'] ?>"
                                                            class="button small green">
                                                            <span class="icon"><i class="mdi mdi-pencil"></i></span>
                                                        </a>
                                                        <a href="../database/role/delete.php?id=<?= $role['id'] ?>"
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
                                <p>No role found here…</p>
                            </div>
                        </div>
                    <?php } ?>
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