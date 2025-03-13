<?php
require_once("../../connection.php");
session_start();
$currentEmail = $_SESSION["user"]["email"] ?? null;
if ($currentEmail == null) {
    header('location:../../index.php');
}
$stmt = $conn->query("SELECT * FROM users where email='$currentEmail'");
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

$id = $_GET["id"] ?? null;
$stmt = $conn->query("SELECT * FROM users where email='$currentEmail'");
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

if ($currentUser["role_id"] != 1 || ! $id) {
    header("location:../../error.php");
    exit;
}

if ($currentUser["role_id"] == 1 || $currentUser["role_id"] == 2) {

    $userStmt = $conn->query('SELECT users.*, roles.role as role_name FROM users JOIN roles ON users.role_id = roles.id');
    $users = $userStmt->fetchAll(PDO::FETCH_ASSOC);




    $courseStmt = $conn->query('SELECT * from courses');
    $courses = $courseStmt->fetchAll(PDO::FETCH_ASSOC);


    $stmt = $conn->query("SELECT * FROM topics WHERE id=$id");
    $currentTopic = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'])) {
        $title = $_POST['title'] ?? null;
        $description = $_POST['description'] ?? null;
        $content = $_POST['content'] ?? null;
        $course_id = $_POST['course_id'] ?? null;

        if (empty($_POST['title']) || strlen($_POST['title']) > 100) {
            $errors['title'] = 'title is required and must be less than 100 characters.';
        }

        if (empty($_POST['description']) || strlen($_POST['description']) > 3000) {
            $errors['description'] = 'description is required and must be less than 3000 characters.';
        }

        if (empty($_POST['content']) || strlen($_POST['content']) > 3000) {
            $errors['content'] = 'description is required and must be less than 3000 characters.';
        }

        if ($_FILES['attachment_path']['size'] > 2 * 1024 * 1024) {
            $errors['attachment_path'] = 'attachment size must be 2MB or less.';
        }

        if ($_FILES['video_path']['size'] > 10 * 1024 * 1024) {
            $errors['video_path'] = 'video size must be 10MB or less.';
        }

        $videoName = $_FILES["video_path"]["name"] ?? null;
        $attachmentName = $_FILES["attachment_path"]["name"] ?? null;

        $videoExtension = pathinfo($videoName, PATHINFO_EXTENSION);
        $attachmentExtension = strtolower(pathinfo($attachmentName, PATHINFO_EXTENSION));

        // print_r($videoExtension);
        // exit;
        $fileName = sha1(time());

        $videoPath = $currentTopic["video_path"];
        $videoAllowedTypes = ["mp4", "webm",];
        if (empty($errors)) {

            if (in_array($videoExtension, $videoAllowedTypes)) {
                if (isset($_FILES['video_path']) && $_FILES['video_path']['error'] == 0) {
                    $videoPath = '../../uploads/' . $fileName . "." . $videoExtension;
                    if (move_uploaded_file($_FILES['video_path']['tmp_name'], $videoPath)) {
                        unlink($currentTopic["video_path"]);
                    }
                }
            }

            $attachmentPath = $currentTopic["attachment_path"];
            $attachmentAllowedTypes = ["pdf", "csv", "xls", "xlsx", "jpeg", "jpg", "png", "gif", "svg", "webp"];

            if (! in_array($attachmentExtension, $attachmentAllowedTypes)) {
                if (isset($_FILES['attachment_path']) && $_FILES['attachment_path']['error'] == 0) {
                    $attachmentPath = '../../uploads/' . $fileName . "." . $attachmentExtension;
                    if (move_uploaded_file($_FILES['attachment_path']['tmp_name'], $attachmentPath)) {
                        unlink($currentTopic["attachment_path"]);
                    }
                }
            } else {
                $errors['attachment_path'] = 'attachment extension type must be pdf, csv, xls, xlsx, jpeg, jpg, png, gif, svg,webp';
            }

            // if (empty($errors)) {

            $query = $conn->exec("UPDATE topics SET title = '$title', description = '$description', content = '$content', video_path = '$videoPath', attachment_path = '$attachmentPath', created_at = NOW(), course_id = $course_id WHERE id = $id");
            if ($query) {
                header("location:../../../../user/topics.php");
            }
            // }
        }
    }

?>
    <!DOCTYPE html>
    <html lang="en" class="">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="" sizes="16x16" href="../../uploads/A.png" />

        <title>Topics of course</title>

        <link rel="stylesheet" href="../../user/css/main.css?v=1628755089081" />

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
        <div id="app">
            <div class="card ">
                <header class="card-header">
                    <p class="card-header-title">
                        <span class="icon"><i class="mdi mdi-book-open-page-variant"></i></span>
                        Edit Topics
                    </p>
                </header>
                <div class="card-content">
                    <form method="POST" class="max-w-2xl p-6 mx-auto space-y-6 bg-white rounded-lg shadow-lg" action="" enctype="multipart/form-data">

                        <div class="flex flex-col">
                            <label for="title" class="text-lg font-semibold text-gray-700">Topic Title</label>
                            <input
                                id="title"
                                type="text"
                                name="title"
                                value="<?= $currentTopic['title'] ?? null; ?>"
                                placeholder="Enter topic title"
                                class="p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required />
                            <p class="text-red-500" id="message"><?php echo $errors["title"] ?? null ?></p>

                        </div>

                        <div class="flex flex-col">
                            <label for="description" class="text-lg font-semibold text-gray-700">Topic Description</label>
                            <textarea
                                id="description"
                                name="description"
                                placeholder="Enter topic description"
                                class="h-32 p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"><?= $currentTopic['description'] ?? null; ?></textarea>
                            <p class="text-red-500" id="message"><?php echo $errors["description"] ?? null ?></p>

                        </div>

                        <!-- Topic Content -->
                        <div class="flex flex-col">
                            <label for="content" class="text-lg font-semibold text-gray-700">Topic Content</label>
                            <input
                                id="content"
                                type="text"
                                name="content"
                                value="<?= $currentTopic['content'] ?? null; ?>"
                                placeholder="Enter content"
                                class="p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <p class="text-red-500" id="message"><?php echo $errors["content"] ?? null ?></p>

                        </div>

                        <!-- Video File Upload -->
                        <div class="flex flex-col">
                            <label for="video_path" class="text-lg font-semibold text-gray-700">Video File</label>
                            <input
                                id="video_path"
                                type="file"
                                name="video_path"
                                class="p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <p class="text-red-500" id="message"><?php echo $errors["video_path"] ?? null ?></p>

                            <video width="700" controls class="py-2 rounded-lg">
                                <source src="<?= $currentTopic["video_path"] ?>" type="video/mp4">

                            </video>
                        </div>

                        <!-- Attachment File Upload -->
                        <div class="flex flex-col">
                            <label for="attachment_path" class="text-lg font-semibold text-gray-700">Attachment File</label>
                            <input
                                id="attachment_path"
                                type="file"
                                name="attachment_path"
                                class="p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <p class="text-red-500" id="message"><?php echo $errors["attachment_path"] ?? null ?></p>

                            <img class="w-full h-64 rounded-lg" src="<?php echo $currentTopic["attachment_path"] ?? null ?>" alt="">
                        </div>

                        <!-- Course ID Selection -->
                        <div class="flex flex-col">
                            <label for="course_id" class="text-lg font-semibold text-gray-700">Course</label>
                            <select
                                id="course_id"
                                name="course_id"
                                class="p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <?php foreach ($courses as $course) { ?>
                                    <option value="<?= $course['id'] ?>"><?= $course['title'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button type="submit" name="submit" class="w-full py-3 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Submit
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>


        <!-- Scripts below are for demo only -->
        <script
            type="text/javascript"
            src="js/main.min.js?v=1628755089081"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
        <script type="text/javascript" src="js/chart.sample.min.js">

        </script>

        <script>
            setTimeout(() => {
                const messageDiv = document.getElementById('message');
                if (messageDiv) {
                    messageDiv.style.display = 'none';
                }
            }, 10000);
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
<?php } else {
    header("location:../../../../user/topics.php");
} ?>