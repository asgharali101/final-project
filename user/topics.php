<?php
require_once '../connection.php';
session_start();
$id = $_GET["id"] ?? null;
if ($id == null) {
    header("location:./courses.php");
}

$userEmail = $_SESSION['user']['email'] ?? null;

if ($userEmail == null) {
    header('location:../../index.html');
    exit;
}
$currentUser = $conn->query("SELECT * from users where email='$userEmail'")->fetch(PDO::FETCH_ASSOC);

$role_id = $currentUser["role_id"] ?? null;


$topicStmt = $conn->query("SELECT * from topics where course_id=$id");
$topics = $topicStmt->fetchAll(PDO::FETCH_ASSOC);

$courseStmt = $conn->query('SELECT * from courses');
$courses = $courseStmt->fetchAll(PDO::FETCH_ASSOC);


$Stmt = $conn->query("SELECT topics.*, courses.title as title_name FROM topics JOIN courses ON topics.course_id = courses.id where course_id=$id");
$topicsTitle = $Stmt->fetchAll(PDO::FETCH_ASSOC);

$currentTopic = null;
?>



<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Topics of course</title>

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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .hide-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>


</head>

<body class="p-0">
    <?php require_once("../particions/nav.php") ?>
    <?php require_once("../particions/sidebar.php") ?>

    <div class="lg:relative hide-scrollbar w-full md:flex lg:flex-row sm:flex-col-reverse  items-start bg-[#13171C] mt-9 pt-6 sm:px-4 lg:px-1">
        <aside class="  lg:ml-[15rem] mb-4 sm:w-full z-10 shadow-xl border-r-8 border-[#1C2432] js-video-episode-list  lg:w-[350px]  flex h-screen flex-col bg-gray-900 px-4  transition-transform duration-500 md:px-2   is-open overflow-auto">

            <header class="relative flex items-center justify-between flex-shrink-0 h-10 px-0 py-0 mt-2 mb-4 transition-colors duration-300 bg-transparent panel rounded-xl has-custom-bg md:h-8 gap-x-1">
                <div>
                    <a class="w-10 h-10 px-0 rounded-lg btn btn-base btn-secondary md:w-8 md:h-8" href="/series">
                        <span class="flex-shrink-0 h-full leading-none flex-center text-wrap">
                            <i class="text-white fas fa-film"></i>
                        </span>
                    </a>
                </div>
                <div class="">
                    <a class="inline-flex items-center h-full px-3 py-1 font-normal text-white rounded-lg shadow-xl bg-slate-800 " href="./courses.php">

                        < Back to Series
                            </a>
                </div>
                <div>
                    <button class="w-10 h-10 px-0 leading-none rounded-lg btn btn-base btn-secondary has-icon md:w-8 md:h-8" title="Tip: press the 's' key to open this search window.">
                        <span class="flex-shrink-0 h-full leading-none flex-center text-wrap">
                            <i class="text-white fas fa-search"></i>
                        </span>
                    </button>
                </div>
                <div>
                    <button class="w-10 h-10 px-0 rounded-lg btn btn-base btn-secondary md:w-8 md:h-8" title="Close Sidebar">
                        <span class="flex-shrink-0 h-full leading-none flex-center text-wrap">
                            <i class="text-white fas fa-times"></i>
                        </span>
                    </button>
                </div>
            </header>

            <h2 class="pb-4 mb-6 text-2xl font-bold text-white border-b border-gray-700">
                <?= $topicsTitle[0]['title_name'] ?? null ?>
            </h2>

            <ul id="episode-list" class="space-y-1 overflow-auto hide-scrollbar">
                <?php foreach ($topics as $index => $topic) {
                ?>
                    <li class="relative flex px-1 py-0 pr-4 transition-colors duration-300 rounded-md cursor-pointer panel hoverable bg-[#1C2432] hover:bg-[#29324A] has-custom-bg episode-list-item group items-center content-item-condensed is-tooling"
                        onclick="playVideo(<?= $index ?>, '<?= $topic['video_path'] ?>');">
                        <div class="flex items-center align-middle relative scale-[.67] font-bold">
                            <h2 class="items-center px-5 pt-3 text-2xl font-medium tracking-tight text-white bg-[#29324A] rounded-full circle h-14 w-14 bg-tooling">
                                <?= $topic['id']; ?>

                            </h2>
                        </div>
                        <div class="w-full text-blue-100 episode-list-details">
                            <div>
                                <div class="items-center justify-between">
                                    <h4 id="title-<?= $index ?>" class="flex items-center episode-list-title md:text-sm">
                                        <a class="clamp one-line md:text-[13px] font-medium leading-normal text-white hover:text-blue-400"
                                            title="<?= $topic['title'] ?>"
                                            style="letter-spacing: -0.07px;">
                                            <?= $topic['title'] ?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <div class="mt-auto flex w-full items-center gap-x-3 text-[11px] lg:mt-px group-hover:text-grey-600/75 text-grey-600/75">
                                <span><?= 'Episode:' . $topic['id']; ?></span>
                                <span class="inline-flex items-center mr-3">
                                    <svg width="9" viewBox="0 0 10 10" class="mr-1">
                                        <g fill="none" fill-rule="evenodd">
                                            <path class="fill-current" d="M5 2C2.25 2 0 4.25 0 7s2.25 5 5 5 5-2.25 5-5-2.25-5-5-5zm2.282 6.923L4.615 7.318v-3.01h.77v2.608l2.307 1.355-.41.652z"></path>
                                        </g>
                                    </svg>
                                    10m 59s
                                </span>
                            </div>
                            <?php if ($role_id == 1 || $role_id == 2) { ?>
                                <div class="flex justify-end space-x-3">
                                    <a href="../database/topics/edit.php?id=<?= $topic['id'] ?? null ?>" class="text-xs text-blue-500" data-target="sample-modal-2">Edit</a>
                                    <a href="../database/topics/delete.php?id=<?= $topic['id'] ?? null ?>" class="text-xs text-red-500" data-target="sample-modal">Delete</a>
                                </div>
                            <?php } ?>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </aside>


        <main class="flex-1 sm:w-full lg:w-[30%] p-6 md:pt-8 lg:pt-2 md:mt-0 sm:mt-16" x-data="{showTopics:false}">
            <h1 class="pb-2 text-lg font-bold text-right text-white">
                Episodes: <?= count($topics) ?>
            </h1>
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h1 class="mb-4 text-2xl font-bold text-gray-800">Video Player</h1>
                <div class="relative">
                    <video id="video-frame" width="100%" height="100%" class="object-cover rounded-lg shadow-lg" controls>
                        <source id="video-source" src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <p id="no-video" class="absolute inset-0 flex items-center justify-center text-lg text-gray-400" style="display: none;">
                        Select a topic to play the video.
                    </p>
                </div>
            </div>


            <?php if ($role_id == 1 || $role_id == 2) { ?>
                <button @click="showTopics = !showTopics" class="px-4 py-2 mt-6 mb-4 text-white bg-blue-600 rounded-lg shadow-md button hover:bg-blue-700">
                    Add Topics
                </button>


                <div x-show="showTopics" x-transition x-cloak @click.outside="showTopics = false" class="mt-6 bg-gray-900 rounded-lg shadow-lg">
                    <header class="p-4 border-b border-gray-300">
                        <h2 class="text-xl font-bold text-white">
                            <i class="mr-2 mdi mdi-book-open-page-variant"></i> Add Topics
                        </h2>
                    </header>
                    <div class="min-h-screen p-6 ">
                        <form method="POST" action="../database/topics/add.php" enctype="multipart/form-data" class="space-y-6">
                            <!-- Topic Title -->
                            <div>
                                <label for="title" class="block mb-2 font-semibold text-gray-300">Topic Title</label>
                                <input
                                    id="title"
                                    type="text"
                                    name="title"
                                    placeholder="Enter topic title"
                                    class="w-full p-3 text-gray-200 placeholder-gray-500 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                            </div>

                            <!-- Topic Description -->
                            <div>
                                <label for="description" class="block mb-2 font-semibold text-gray-300">Topic Description</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    placeholder="Enter topic description"
                                    class="w-full h-32 p-3 text-gray-200 placeholder-gray-500 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>

                            <!-- Topic Content -->
                            <div>
                                <label for="content" class="block mb-2 font-semibold text-gray-300">Topic Content</label>
                                <input
                                    id="content"
                                    type="text"
                                    name="content"
                                    placeholder="Enter content"
                                    class="w-full p-3 text-gray-200 placeholder-gray-500 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>

                            <!-- Video File -->
                            <div>
                                <label for="video_path" class="block mb-2 font-semibold text-gray-300">Video File</label>
                                <input
                                    id="video_path"
                                    type="file"
                                    name="video_path"
                                    class="w-full p-3 text-gray-200 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>

                            <!-- Attachment File -->
                            <div>
                                <label for="attachment_path" class="block mb-2 font-semibold text-gray-300">Attachment File</label>
                                <input
                                    id="attachment_path"
                                    type="file"
                                    name="attachment_path"
                                    class="w-full p-3 text-gray-200 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            </div>

                            <!-- Course Selection -->
                            <div>
                                <label for="course_id" class="block mb-2 font-semibold text-gray-300">Course</label>
                                <select
                                    id="course_id"
                                    name="course_id"
                                    class="w-full p-3 text-gray-200 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <?php foreach ($courses as $course) { ?>
                                        <option value="<?= $course['id'] ?>"><?= ($course['title']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" name="submit" class="w-full py-3 text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            <?php } ?>
        </main>

    </div>

    <div class="mt-2">
        <?php require_once '../particions/footer.php'; ?>
    </div>
    <script>
        function playVideo(index, videoPath) {
            // Update the video source
            const videoFrame = document.getElementById('video-frame');
            const videoSource = document.getElementById('video-source');
            videoSource.src = videoPath;
            videoFrame.load();

            // Remove active class from all titles
            document.querySelectorAll('.episode-list-title a').forEach((title) => {
                title.classList.remove('text-blue-400');
                title.classList.add('text-white');
            });

            // Add active class to the clicked title
            const activeTitle = document.getElementById(`title-${index}`).querySelector('a');
            activeTitle.classList.remove('text-white');
            activeTitle.classList.add('text-blue-400');

            // Show the play button and set up its click event
            const playButton = document.getElementById('play-button');
            playButton.style.display = 'block';
            playButton.onclick = () => {
                videoFrame.play();
                playButton.style.display = 'none'; // Hide the play button after starting
            };
        }
    </script>

    <script
        type="text/javascript"
        src="js/main.min.js?v=1628755089081"></script>

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