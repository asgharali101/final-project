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

$status = $_GET['is_active'] ?? 1;
$searchBox = $_GET['search'] ?? ''; // Get the search term from the query string

if ($role_id == 1) {
    $query = "SELECT users.*, roles.role as role_name 
              FROM users 
              LEFT JOIN roles ON users.role_id = roles.id 
              WHERE is_active = $status";

    if (! empty($searchBox)) {
        $query .= " AND (users.email LIKE '%$searchBox%' OR users.first_name LIKE '%$searchBox%')";
    }

    $stmt = $conn->query($query);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($role_id == 2) {
    $query = 'SELECT users.*, roles.role as role_name 
              FROM users 
              LEFT JOIN roles ON users.role_id = roles.id 
              WHERE users.role_id != 1';

    if (! empty($searchBox)) {
        $query .= " AND (users.email LIKE '%$searchBox%' OR users.first_name LIKE '%$searchBox%')";
    }

    $stmt = $conn->query($query);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $users = [];
}
//  elseif ($role_id == 3) {
//     $stmt = $conn->query("SELECT users.*,roles.role as role_name from users LEFT JOIN roles ON users.role_id=roles.id WHERE users.email='$priviousEmail'");
//     $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// }

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
        </section>


        <?php
if ($role_id != null) { ?>
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
                <div class="items-center justify-between lg:flex ">
                    <!-- Toggle Buttons -->
                    <?php
                        if ($role_id == 1) { ?>
                        <div class="flex items-center space-x-3">
                            <a href="http://final-project.test/user/users.php">
                                <button class="px-4 py-2 font-bold text-white transition bg-blue-500 rounded-full shadow-lg hover:bg-blue-600">All</button>
                            </a>
                            <div class="p-4 space-y-4 rounded-lg">
                                <form method="GET">
                                    <label for="toggle" class="flex items-center cursor-pointer">
                                        <div class="mr-3 font-bold text-gray-700">Inactive</div>

                                        <!-- Toggle Switch -->
                                        <div class="relative">
                                            <!-- Hidden input for default inactive state -->
                                            <input type="hidden" name="is_active" value="0">

                                            <input
                                                type="checkbox"
                                                id="toggle"
                                                name="is_active"
                                                value="1"
                                                class="sr-only"
                                                onchange="this.form.submit()"
                                                <?php echo (isset($_GET['is_active']) && $_GET['is_active'] == 1) ? 'checked' : ''; ?>>

                                            <div class="block w-14 h-8 rounded-full 
                                                <?php echo (isset($_GET['is_active']) && $_GET['is_active'] == 1) ? 'bg-green-500' : 'bg-red-500'; ?>">
                                            </div>
                                            <div class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full transition-transform duration-300 transform 
                                                      <?php echo (isset($_GET['is_active']) && $_GET['is_active'] == 1) ? 'translate-x-6' : ''; ?>">
                                            </div>
                                        </div>

                                        <div class="ml-3 font-bold text-gray-700">Active</div>
                                    </label>
                                </form>
                            </div>


                        </div>
                    <?php } ?>

                    <div class="relative w-full max-w-md mx-auto">
                        <form action="" method="get" class="flex items-center">
                            <div class="relative w-full">
                                <input
                                    type="search"
                                    name="search"
                                    placeholder="Search here..."
                                    class="w-full py-3 pl-12 pr-4 text-gray-700 placeholder-gray-400 transition-all duration-300 bg-white border-2 border-blue-500 shadow-xl rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-400 focus:border-transparent hover:shadow-blue-300" />
                                <div class="absolute text-blue-500 transform -translate-y-1/2 left-4 top-1/2 animate-bounce">
                                    <i class="text-2xl mdi mdi-magnify"></i>
                                </div>
                            </div>
                            <button
                                type="submit"
                                class="px-6 py-3 ml-3 font-semibold text-white transition-all duration-300 bg-blue-500 shadow-lg rounded-2xl hover:bg-blue-600 hover:shadow-blue-300">
                                Search
                            </button>
                        </form>
                    </div>
                </div>



                <!-- Let me know if you want me to add icons or any animations! -->

                <div class="card has-table">
                    <header class=" card-header">
                        <p class="card-header-title">
                            <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
                            <?php
                    echo $users[0]['role_name'] ?? null;
    ?>
                        </p>
                        <?php if ($role_id == 1) { ?>
                            <div class="flex items-center space-x-9">
                                <form action="./download-data.php">
                                    <button class="px-4 py-2 mx-2 mt-6 mb-4 text-white rounded-lg shadow-md button green">
                                        Download data
                                    </button>
                                </form>
                                <a href="../database/user/adduser.php" class="px-4 py-2 mx-2 mt-6 mb-4 text-white rounded-lg shadow-md button green">Add User</a>
                            </div>
                        <?php } ?>
                    </header>
                    <?php if ($users != null) { ?>
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
                                                    src="<?php echo ! empty($user['image_path'])
                                        ? $user['image_path']
                                        : 'https://ui-avatars.com/api/?name='.urlencode($user['first_name'] ?? 'User'); ?>"
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
                            <!-- <div class="table-pagination">
                                <div class="flex items-center justify-between">
                                    <div class="buttons">
                                        <button type="button" class="button active">1</button>
                                        <button type="button" class="button">2</button>
                                        <button type="button" class="button">3</button>
                                    </div>
                                    <small>Page 1 of 3</small>
                                </div>
                            </div> -->
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