<?php
session_start();

require_once '../connection.php';
require_once '../database/enrollment/add.php';

$priviousEmail = $_SESSION['user']['email'] ?? null;
if ($priviousEmail == null) {
    header('location:../../index.html');
    exit;
}

$userStmt = $conn->query("SELECT * from users WHERE email='$priviousEmail'");
$CurrentUsers = $userStmt->fetch(PDO::FETCH_ASSOC);

$role_id = $CurrentUsers['role_id'] ?? null;
if ($role_id != 1) {
    header('location:../../error.php');
}

$stmt = $conn->query('SELECT * FROM users');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query('SELECT * FROM courses');
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

$status = $_GET['is_active'] ?? null;
if (isset($status)) {
    $stmt = $conn->query("SELECT
    enrollments.id, enrollments.is_active, enrollments.enrolled_at,
    users.first_name as first_name,
    users.role_id as role_id,  
    courses.title as course_title
FROM enrollments
LEFT JOIN users ON users.id = enrollments.user_id
LEFT JOIN courses ON courses.id = enrollments.course_id WHERE enrollments.is_active=$status");
    $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $conn->query('SELECT
    enrollments.id, enrollments.is_active, enrollments.enrolled_at,
    users.first_name as first_name,
    users.role_id as role_id,  
    courses.title as course_title
FROM enrollments
LEFT JOIN users ON users.id = enrollments.user_id
LEFT JOIN courses ON courses.id = enrollments.course_id');
    $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <div id="app" x-data="{showAddEnrollment:false}">
        <?php
        require_once '../particions/nav.php';
require_once '../particions/sidebar.php';
?>
        <?php
if ($role_id == 1) { ?>

            <div class="flex items-center justify-between">
                <div>
                    <button @click="showAddEnrollment = !showAddEnrollment" class="mt-6 mb-4 ml-10 button green">
                        Add Enrollment
                    </button>
                    <a href="./download-enroll.php" class="mt-6 mb-4 ml-10 button green">
                        Download enroll
                    </a>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="http://final-project.test/user/enrollment.php">
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

            </div>



            <div x-show="showAddEnrollment" x-transition x-cloak @click.outside="showAddEnrollment = false" class="mb-10 card">
                <header class="card-header">
                    <p class="card-header-title">
                        <span class="icon"><i class="mdi mdi-school"></i></span>
                        Add Enrollment
                    </p>
                </header>
                <div class=" card-content">
                    <form method="POST" class="flex flex-col space-y-4" action="" enctype="multipart/form-data">
                        <div class="">
                            <div class="select">
                                <div class="control">
                                    <label class="label">Select Users</label>
                                    <select name="user_id">
                                        <?php foreach ($users as $user) { ?>
                                            <option value="<?= $user['id'] ?>"><?= $user['first_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <p class="text-red-500" id="message"><?php echo $errors['user_id'] ?? null ?></p>
                                </div>
                            </div>

                        </div>

                        <div class="">
                            <div class="select">
                                <div class="control">
                                    <label class="label">Select Course</label>
                                    <select name="course_id">
                                        <?php foreach ($courses as $course) { ?>
                                            <option value="<?= $course['id'] ?>"><?= $course['title'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="control">
                            <label class="label">Role</label>
                            <input readonly type="text" name="role_id" value="<?php echo $current_role['role'];
    ?>" id="">
                        </div> -->

                        <div class="control">
                            <label class="label">Status</label>
                            <select
                                class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md"
                                name="is_active"
                                id="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
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
<?php } ?>

<?php if (count($enrollments) != 0 && $role_id == 1) { ?>

    <div class="mx-4 card-content">
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>Users</th>
                    <th>Role</th>
                    <th>Courses</th>
                    <th>Is_active</th>
                    <?php if ($role_id == 1) { ?>
                        <th class="text-right ">Actions</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enrollments as $enrollment) {
                    $user_role = $enrollment['role_id'] ?? null;
                    $stmt = $conn->query("SELECT * from roles WHERE id=$user_role");
                    $current_role = $stmt->fetch(PDO::FETCH_ASSOC);

                    ?>
                    <tr class="text-left sm:w-full">
                        <td><?= $enrollment['id'] ?? null ?></td>
                        <td><?= $enrollment['first_name'] ?? null ?></td>
                        <td><?= $current_role['role'];
                    ?></td>
                        <td><?= $enrollment['course_title'] ?? null ?></td>
                        <td>
                            <?php if ($enrollment['is_active'] == 1) { ?>
                                <span style="color: green; font-weight: bold;">
                                    ● Active
                                </span>
                            <?php } else { ?>
                                <span style="color: red; font-weight: bold;">
                                    ● Inactive
                                </span>
                            <?php } ?>
                        </td>


                        <?php if ($role_id == 1) { ?>
                            <td class="actions-cell">
                                <div class="buttons right nowrap">
                                    <a href="../database/enrollment/edit.php?id=<?= $enrollment['id'] ?? null ?>"
                                        class="button small green --jb-modal"
                                        data-target="sample-modal-2">
                                        <span class="icon"><i class="mdi mdi-eye"></i></span>
                                    </a>
                                    <a href="../database/enrollment/delete.php?id=<?= $enrollment['id'] ?? null ?>"
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