<?php
require_once '../connection.php';
session_start();


$priviousEmail = $_SESSION['user']['email'] ?? null;

if ($priviousEmail === null) {
    header('location:../../index.html');
    exit;
}
$userStmt = $conn->query("SELECT * from users WHERE email='$priviousEmail'");
$CurrentUsers = $userStmt->fetch(PDO::FETCH_ASSOC);

$role_id = $CurrentUsers['role_id'] ?? null;

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
    $stmt = $conn->query("SELECT users.*,roles.role as role_name from users LEFT JOIN roles ON users.role_id=roles.id WHERE users.email='$priviousEmail'");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>

<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Users - Admin One Tailwind CSS Admin Dashboard</title>

    <!-- Tailwind is included -->
    <link rel="stylesheet" href="css/main.css?v=1628755089081" />

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon-16x16.png">

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
    <div id="app">
        <?php
        require_once '../particions/nav.php';
        require_once '../particions/sidebar.php';

        ?>
        </section>


        <?php
        if (count($users) > 0) { ?>
            <section class="section main-section">
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

                <div class="card has-table">
                    <header class=" card-header">
                        <p class="card-header-title">
                            <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
                            <?php
                            echo $users[0]["role_name"];
                            ?>
                        </p>
                        <?php if ($role_id == 1) { ?>
                            <form action="./download-data.php">
                                <button class="px-4 py-2 mx-2 mt-6 mb-4 text-white rounded-lg shadow-md button green">
                                    Download data
                                </button>
                            </form>
                        <?php } ?>
                    </header>
                    <?php if (count($users) != 0) { ?>
                        <div class="card-content">
                            <table>
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>profile</th>
                                        <th>First</th>
                                        <th>Last</th>
                                        <th class="pl-5">Email</th>
                                        <th>role</th>
                                        <th>Birth</th>
                                        <th>Address</th>
                                        <?php if ($role_id == 1) { ?>
                                            <th class="pl-8">Actions</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) { ?>
                                        <tr>
                                            <td><?= $user['id'] ?? null ?></td>
                                            <td class="">
                                                <img class="w-8 h-8 rounded-full"
                                                    src="<?php echo (!empty($user['image_path'])
                                                                ? $user['image_path']
                                                                : 'https://ui-avatars.com/api/?name=' . urlencode($user['first_name'] ?? 'User')); ?>"
                                                    alt="Avatar">
                                            </td>

                                            <td><?= $user['first_name'] ?? null ?></td>
                                            <td><?= $user['last_name'] ?? null ?></td>
                                            <td><?= $user['email'] ?? null ?></td>
                                            <td><?= $user['role_name'] ?? '' ?></td>
                                            <td><?= $user['date_of_birth'] ?? null ?></td>
                                            <td><?= $user['address'] ?? null ?></td>
                                            <?php if ($role_id == 1) { ?>
                                                <td class="actions-cell">
                                                    <div class="buttons right nowrap">
                                                        <a href="./edit.php?id=<?= $user['id'] ?? null ?>"
                                                            class="button small green --jb-modal"
                                                            data-target="sample-modal-2">
                                                            <span class="icon"><i class="mdi mdi-eye"></i></span>
                                                        </a>
                                                        <a href="../database/user/delete.php?id=<?= $user['id'] ?? null ?>"
                                                            class="button small red --jb-modal"
                                                            data-target="sample-modal">
                                                            <span class="icon"><i class="mdi mdi-trash-can"></i></span>
                                                        </a>
                                                    </div>
                                                </td>
                                            <?php } ?>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="table-pagination">
                                <div class="flex items-center justify-between">
                                    <div class="buttons">
                                        <button type="button" class="button active">1</button>
                                        <button type="button" class="button">2</button>
                                        <button type="button" class="button">3</button>
                                    </div>
                                    <small>Page 1 of 3</small>
                                </div>
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