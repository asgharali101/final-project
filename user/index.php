<?php
require_once '../connection.php';
session_start();


$priviousEmail = $_SESSION['user']['email'] ?? null;

if ($priviousEmail === null) {
    header('location:../../index.php');
}

$roleStmt = $conn->query("SELECT * from users WHERE email='$priviousEmail'");
$roles = $roleStmt->fetch(PDO::FETCH_ASSOC);

$role_id = $roles['role_id'] ?? null;

$adminStmt = $conn->query('SELECT * from users WHERE role_id=1');
$admins = $adminStmt->fetchAll(PDO::FETCH_ASSOC);

$teacherStmt = $conn->query('SELECT * from users WHERE role_id=2');
$teachers = $teacherStmt->fetchAll(PDO::FETCH_ASSOC);

$studentStmt = $conn->query('SELECT * from users WHERE role_id=3');
$students = $studentStmt->fetchAll(PDO::FETCH_ASSOC);

if ($role_id == 1) {
    $stmt = $conn->query('SELECT users.*,roles.role as role_name from users LEFT JOIN roles ON users.role_id=roles.id');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($role_id == 2) {
    $stmt = $conn->query('SELECT users.*,roles.role as role_name from users LEFT JOIN roles ON users.role_id=roles.id WHERE users.role_id!=1 ');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($role_id == 3) {
    $stmt = $conn->query("SELECT users.*,roles.role as role_name from users LEFT JOIN roles ON users.role_id=roles.id WHERE users.role_id=$role_id");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <div id="app">
        <?php
        require_once '../particions/nav.php';
        require_once '../particions/sidebar.php';

        ?>
        <section class="is-title-bar">
            <div
                class="flex flex-col items-center justify-between space-y-6 md:flex-row md:space-y-0">
                <ul>
                    <li>Admin</li>
                    <li>Dashboard</li>
                </ul>
                <a
                    href="https://asghar-dev.godaddysites.com/"
                    onclick=" alert('Coming soon'); return false"
                    target="_blank"
                    class="button blue">
                    <span class="icon"><i class="mdi mdi-credit-card-outline"></i></span>
                    <span>Premium Demo</span>
                </a>
            </div>
        </section>

        <section class="is-hero-bar">
            <div
                class="flex flex-col items-center justify-between space-y-6 md:flex-row md:space-y-0">
                <h1 class="title">Dashboard</h1>
                <button class="button light">Button</button>
            </div>
        </section>


        <?php if (isset($_SESSION['user'])) { ?>
            <section class="section main-section">
                <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
                    <div class="card">
                        <div class="card-content">
                            <div class="flex items-center justify-between">
                                <div class="widget-label">
                                    <h3>Admins</h3>
                                    <h1><?php echo count($admins) ?></h1>
                                </div>
                                <span class="text-green-500 icon widget-icon"><i class="mdi mdi-account-multiple mdi-48px"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="flex items-center justify-between">
                                <div class="widget-label">
                                    <h3>Teachers</h3>
                                    <h1><?php echo count($teachers) ?></h1>
                                </div>
                                <span class="text-blue-500 icon widget-icon"><i class="mdi mdi-teach mdi-48px"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content">
                            <div class="flex items-center justify-between">
                                <div class="widget-label">
                                    <h3>students</h3>
                                    <h1><?php echo count($students) ?></h1>
                                </div>
                                <span class="text-teal-500 icon widget-icon"><i class="mdi mdi-school-outline mdi-48px"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6 card">
                    <header class="card-header">
                        <p class="card-header-title">
                            <span class="icon"><i class="mdi mdi-finance"></i></span>
                            Performance
                        </p>
                        <a href="#" class="card-header-icon">
                            <span class="icon"><i class="mdi mdi-reload"></i></span>
                        </a>
                    </header>
                    <div class="card-content">
                        <div class="chart-area">
                            <div class="h-full">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div></div>
                                    </div>
                                </div>
                                <canvas
                                    id="big-line-chart"
                                    width="2992"
                                    height="1000"
                                    class="block chartjs-render-monitor"
                                    style="height: 400px; width: 1197px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="notification blue">
                    <div
                        class="flex flex-col items-center justify-between space-y-3 md:flex-row md:space-y-0">
                        <div>
                            <span class="icon"><i class="mdi mdi-buffer"></i></span>
                            <b>Responsive table</b>
                        </div>
                        <button
                            type="button"
                            class="button small textual --jb-notification-dismiss">
                            Dismiss
                        </button>
                    </div>
                </div>

            </section>
            <div id="sample-modal" class="modal">
                <div class="modal-background --jb-modal-close"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Sample modal</p>
                    </header>
                    <section class="modal-card-body">
                        <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
                        <p>This is sample modal</p>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button --jb-modal-close">Cancel</button>
                        <button class="button red --jb-modal-close">Confirm</button>
                    </footer>
                </div>
            </div>

            <div id="sample-modal-2" class="modal">
                <div class="modal-background --jb-modal-close"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Sample modal</p>
                    </header>
                    <section class="modal-card-body">
                        <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
                        <p>This is sample modal</p>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button --jb-modal-close">Cancel</button>
                        <button class="button blue --jb-modal-close">Confirm</button>
                    </footer>
                </div>
            </div>
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

    <!-- Scripts below are for demo only -->
    <script
        type="text/javascript"
        src="js/main.min.js?v=1628755089081"></script>

    <script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script type="text/javascript" src="js/chart.sample.min.js"></script>

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