<?php
require_once './connection.php';
session_start();

$priviousEmail = $_SESSION['user']['email'] ?? null;

$courseStmt = $conn->query('SELECT * from courses');
$allCourses = $courseStmt->fetchAll(PDO::FETCH_ASSOC);

$userStmt = $conn->query("SELECT users.*, roles.role as role_name FROM users JOIN roles ON users.role_id = roles.id WHERE email='$priviousEmail'");
$users = $userStmt->fetch(PDO::FETCH_ASSOC);

$role_id = $users['role_id'] ?? null;
$user_id = $users['id'] ?? null;

$courseStmt = $conn->query(
    "SELECT courses.*, categories.name as category_name,  COUNT(topics.id) as topic_count
        FROM courses
        JOIN categories ON courses.category_id = categories.id
        LEFT JOIN topics ON courses.id = topics.course_id
        GROUP BY courses.id "
);

$courses = $courseStmt->fetchAll(PDO::FETCH_ASSOC);

$sql = $conn->query('SELECT categories.*, COUNT(courses.id) AS course_count 
        FROM categories
        LEFT JOIN courses ON categories.id = courses.category_id
        GROUP BY categories.id');

$categories = $sql->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT enrollments.*,
 users.first_name as first_name,
 users.last_name as last_name,
 users.image_path as profile_image,
 courses.title as course_title
 FROM enrollments
 LEFT JOIN users ON enrollments.user_id=users.id
 LEFT JOIN courses ON enrollments.course_id=courses.id  where users.role_id = 2 GROUP BY enrollments.id
 ");
$teacherEnrolls = $stmt->fetchALL(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" class="group" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Ali Edu</title>
    <meta name="description" content="web development agency">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="YUCtNVCcqCgR5CLiVKgCJZbPniH2JTCRYZWfRuLz">
    <link rel="shortcut icon" type="image/x-icon" href="uploads/3.png">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap">
    <link rel="stylesheet" href="css/toastr.min.css">
    <link rel="stylesheet" href="css/swiper-bundle.min.css">
    <script src="js/lozad.min.js"></script>
    <link rel="stylesheet" href="css/output.min.css">
    <script type="text/javascript" class="flasher-js" nonce="">
        (function(window, document) {
            const merge = (first, second) => {
                if (Array.isArray(first) && Array.isArray(second)) {
                    return [...first, ...second.filter(item => !first.includes(item))];
                }

                if (typeof first === 'object' && typeof second === 'object') {
                    for (const [key, value] of Object.entries(second)) {
                        first[key] = key in first ? {
                            ...first[key],
                            ...value
                        } : value;
                    }
                    return first;
                }

                return undefined;
            };

            const mergeOptions = (...options) => {
                const result = {};

                options.forEach(option => {
                    Object.entries(option).forEach(([key, value]) => {
                        result[key] = key in result ? merge(result[key], value) : value;
                    });
                });

                return result;
            };

            const renderCallback = (options) => {
                if (!window.flasher) {
                    throw new Error('Flasher is not loaded');
                }

                window.flasher.render(options);
            };

            const render = (options) => {
                if (options instanceof Event) {
                    options = options.detail;
                }

                if (['interactive', 'complete'].includes(document.readyState)) {
                    renderCallback(options);
                } else {
                    document.addEventListener('DOMContentLoaded', () => renderCallback(options));
                }
            };

            const addScriptAndRender = (options) => {
                const mainScript = '/vendor/flasher/flasher.min.js?id=838b3702a4b7635679d0399778803fd1';

                if (window.flasher || !mainScript || document.querySelector('script[src="' + mainScript + '"]')) {
                    render(options);
                } else {
                    const tag = document.createElement('script');
                    tag.src = mainScript;
                    tag.type = 'text/javascript';
                    tag.setAttribute('nonce', '3efc436cf038f66bbae59e74f0f9c6b7');
                    tag.onload = () => render(options);

                    document.head.appendChild(tag);
                }
            };

            const addRenderListener = () => {
                if (1 === document.querySelectorAll('script.flasher-js').length) {
                    document.addEventListener('flasher:render', render);
                }


            };

            const options = [];
            options.push({
                "envelopes": [],
                "scripts": [],
                "styles": [],
                "options": [],
                "context": {
                    "envelopes_only": false,
                    "csp_script_nonce": "3efc436cf038f66bbae59e74f0f9c6b7",
                    "csp_style_nonce": "d94b8dbf3ef0f10aa6870c9fddb9f7f1"
                }
            });
            /** {--FLASHER_REPLACE_ME--} **/
            addScriptAndRender(mergeOptions(...options));
            addRenderListener();
        })(window, document);
    </script>
    <script src="js/flasher.min.js" type="text/javascript" nonce=""></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="">
    <div class="pre-loader-wrapper">
        <div class="loader">
            <div class="orb"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
    </div>

    <div>
        <?php require_once("./header.php") ?>
    </div>

    <main>
        <!-- START BANNER AREA -->
        <div class="relative pt-24 pb-48 overflow-hidden bg-primary-50 xl:pt-40 xl:pb-80">
            <div class="container">
                <div class="swiper banner-slider">
                    <div class="swiper-wrapper">
                        <!-- SINGLE SLIDER ITEM -->
                        <div class="swiper-slide">
                            <div class="grid grid-cols-12 gap-7">
                                <div class="col-span-full lg:col-span-7">
                                    <div class="area-subtitle subtitle-outline">Best Education Tutor</div>
                                    <h1 class="mt-2 area-title title-lg xl:mt-4">
                                        Here is Your Course Chart for
                                        <span class="title-highlight-one">Success</span>
                                    </h1>
                                    <p class="mt-2 area-description desc-lg xl:mt-5 sm:pr-20 rtl:sm:pr-0 rtl:sm:pl-20">
                                        Discover expertly crafted courses designed to empower your skills and transform
                                        your career. Start learning today!</p>
                                    <a href="" aria-label="Hero call to action"
                                        class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium mt-7">
                                        Get Started Now
                                        <span class="hidden md:block">
                                            <i
                                                class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="hidden col-span-full lg:col-span-5 lg:block">
                                    <div class="bg-white border-[12px] border-heading rounded-[20px] overflow-hidden">
                                        <img src="images/lms-QFOTadKS.webp" alt="Hero image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- SINGLE SLIDER ITEM -->
                        <div class="swiper-slide">
                            <div class="grid grid-cols-12 gap-7">
                                <div class="col-span-full lg:col-span-7">
                                    <div class="area-subtitle subtitle-outline">Learn Grow Achieve</div>
                                    <h1 class="mt-2 area-title title-lg xl:mt-4">
                                        Your Gateway to Endless
                                        <span class="title-highlight-one">Learning</span>
                                    </h1>
                                    <p class="mt-2 area-description desc-lg xl:mt-5 sm:pr-20 rtl:sm:pr-0 rtl:sm:pl-20">
                                        Discover expertly crafted courses designed to empower your skills and transform
                                        your career. Start learning today!</p>
                                    <a href="#" aria-label="Hero call to action"
                                        class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium mt-7">
                                        Get Started Now
                                        <span class="hidden md:block">
                                            <i
                                                class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                                        </span>
                                    </a>
                                </div>
                                <div class="hidden col-span-full lg:col-span-5 lg:block">
                                    <div class="bg-white border-[12px] border-heading rounded-[20px] overflow-hidden">
                                        <img src="images/lms-nes5kFSm.webp" alt="Hero image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SWIPER PAGINATION -->
            <div
                class="banner-slider-pagination swiper-custom-pagination absolute w-full !bottom-24 xl:!bottom-36 z-10">
            </div>
            <!-- SOCIAL MEDIA -->


            <div
                class="px-3 py-2 border border-white rounded-full hidden min-[1536px]:flex items-center gap-4 w-max text-orientation-mixed writing-mode absolute left-4 top-1/2 !-translate-y-1/2 z-10">
                <div class="font-bold leading-none text-heading dark:text-white"> Follow Us -</div>
                <ul class="flex items-center gap-2">
                    <li class="">
                        <a href="https://www.linkedin.com/"
                            class="bg-white size-10 rounded-50 text-heading dark:text-white flex-center hover:bg-primary hover:text-white custom-transition"
                            aria-label="Social media link">
                            <i class="ri-linkedin-fill"></i>
                        </a>
                    </li>
                    <li class="">
                        <a href="https://x.com/?lang=en"
                            class="bg-white size-10 rounded-50 text-heading dark:text-white flex-center hover:bg-primary hover:text-white custom-transition"
                            aria-label="Social media link">
                            <i class="ri-twitter-x-line"></i>
                        </a>
                    </li>
                    <li class="">
                        <a href="https://www.facebook.com/"
                            class="bg-white size-10 rounded-50 text-heading dark:text-white flex-center hover:bg-primary hover:text-white custom-transition"
                            aria-label="Social media link">
                            <i class="ri-facebook-fill"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- POSITIONAL ELEMENTS -->
            <ul>
                <!-- TOP LEFT -->
                <li class="block size-[550px] rounded-50 bg-[#1AEBC5]/15 blur-[200px] absolute -top-[20%] -left-[10%]">
                </li>
                <!-- BOTTOM CENTER -->
                <li
                    class="block size-[550px] rounded-50 bg-[#F98272]/15 blur-[200px] absolute -bottom-[30%] left-1/2 -translate-x-1/2">
                </li>
                <!-- TOP RIGHT -->
                <li class="block size-[550px] rounded-50 bg-[#5F3EED]/20 blur-[200px] absolute -top-[20%] -right-[10%]">
                </li>
            </ul>
            <!-- WAVE ANIMATION -->
            <div class="absolute bottom-0 left-0 right-0 w-full">
                <img data-src="https://edulab.hivetheme.com/lms/frontend/assets/images/banner/wave.png" class="w-full"
                    alt="wave">
            </div>
        </div>
        <!-- END BANNER AREA -->

        <!-- START CATEGORY AREA -->
        <div class=" bg-white pt-10 xl:pt-0 pb-10 sm:pb-24 lg:pb-[70px]">
            <div class="container swiper popular-courses-slider">
                <!-- HEADER -->
                <div class="grid items-center grid-cols-12 gap-4">
                    <div class="col-span-full md:col-span-7 xl:col-span-6 md:pr-20">
                        <div class="area-subtitle">Top Category</div>
                        <h2 class="mt-2 area-title">
                            Optimize Your Brain for Peak
                            <span class="title-highlight-one">Performance</span>
                        </h2>
                    </div>
                    <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                        <a href="./user/category.php" title="View All Category" aria-label="View All Category"
                            class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium text-[16px] md:text-[18px]">
                            View All Category
                            <span class="hidden md:block">
                                <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <!-- SWIPER BODY -->
                <div class="mt-10 lg:mt-[60px] swiper-wrapper">
                    <?php foreach ($categories as $category) { ?>
                        <div class="swiper-slide">
                            <div class="shadow bg-primary-50 rounded-[15px] px-6 py-8 flex-center flex-col border border-transparent hover:border-primary hover:shadow-md custom-transition h-full group/category">
                                <div class="mb-4 flex-center size-12">
                                    <!-- Category Icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="47" viewBox="0 0 52 51" fill="none">
                                        <path d="M2 12.8684H50M2 38.1316H50..." stroke="#111827" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <h6 class="area-title text-[18px] text-center font-semibold  group-hover/category:text-primary custom-transition">
                                    <?= $category["name"] ?>
                                </h6>
                                <p class="mt-1 text-sm font-normal text-center area-description opacity-80 group-hover/category:opacity-100 custom-transition">
                                    <?= $category["course_count"] ?> Course Available
                                </p>

                            </div>
                        </div>
                    <?php } ?>
                </div>



            </div>
        </div>
        <!-- END CATEGORY AREA -->

        <!-- START POPULAR COURSE AREA -->
        <div class="relative bg-primary-50 py-16 sm:py-24 lg:py-[80px]">
            <div class="container">
                <!-- HEADER -->
                <div class="grid items-center grid-cols-12 gap-4 pb-14">
                    <div class="col-span-full md:col-span-7 xl:col-span-6 md:pr-20">
                        <div class="area-subtitle">
                            Popular Course
                        </div>
                        <h2 class="mt-2 area-title">
                            See Our Popular
                            <span class="title-highlight-one">
                                Courses
                            </span>
                        </h2>
                    </div>

                    <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                        <a href="./user/courses.php" title="View all course"
                            class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium text-[16px] md:text-[18px]"
                            aria-label="View all course">
                            View all course
                            <span class="hidden md:block">
                                <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <!-- BODY -->
                <div class="container mx-auto swiper popular-courses-slider">
                    <!-- Grid Layout -->
                    <div class=" swiper-wrapper">
                        <?php foreach ($courses as $course) {
                            $course_id = $course['id'];
                            $enrollmentStmt = $conn->query("SELECT COUNT(*) AS student_count FROM enrollments WHERE course_id = $course_id");
                            $enrollments = $enrollmentStmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                            <!-- Course Card -->
                            <div class="p-4 transition-all bg-white border border-gray-200 rounded-lg swiper-slide hover:scale-105 ">
                                <!-- Course Image -->
                                <div class="relative overflow-hidden rounded-lg aspect-w-16 aspect-h-9">
                                    <img src="<?= $course['feature_image'] ?? 'https://via.placeholder.com/300x200' ?>"
                                        class="object-cover w-full h-40 rounded-lg"
                                        alt="Course thumbnail">
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
                                    <h6 class="area-title font-bold !text-xl group-hover/course:text-primary pt-3 pb-3 leading-9 text-black transition hover:text-blue-600 hover:text-primary">
                                        <a href="./topics.php?id=<?php echo $course["id"] ?? null ?>"
                                            class="line-clamp-2" aria-label="Course title">
                                            <?= $course['title'] ?? 'Untitled Course' ?>
                                        </a>
                                    </h6>

                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center gap-0.5 text-secondary">
                                            <!-- Star Icons -->
                                            <span><i class="text-yellow-400 ri-star-fill"></i></span>
                                            <span><i class="text-yellow-400 ri-star-fill"></i></span>
                                            <span><i class="text-yellow-400 ri-star-fill"></i></span>
                                            <span><i class="text-yellow-400 ri-star-fill"></i></span>
                                            <span><i class="text-gray-300 ri-star-line"></i></span>
                                        </div>
                                        <p class="area-description text-xs !leading-none text-gray-500 ">(10 Rating)</p>
                                    </div>


                                    <p class="my-2 border-b"></p>
                                    <div class="flex items-center justify-between space-x-4 text-gray-600 ">
                                        <!-- Duration -->
                                        <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                            <i class="mr-1 text-base ri-time-line"></i>
                                            <span><?= $course['duration'] ?? 'N/A' ?></span>
                                        </div>
                                        <!-- Lessons -->
                                        <div class="flex items-center gap-x-3">
                                            <div class="flex items-center gap-1 area-description text-sm text-gray-500 !leading-none shrink-0">
                                                <i class="mr-1 text-base ri-book-line"></i>
                                                <span><?= $course['topic_count'] . " Lessons" ?? '0 Lessons' ?></span>
                                            </div>
                                            <div class="flex items-center gap-1 area-description text-sm text-gray-500 !leading-none shrink-0">
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
            </div>
            <!-- SWIPER PAGINATION -->
        </div>
        <!-- END POPULAR COURSE AREA -->

        <!-- START TESTIMONIAL AREA -->
        <div class="bg-white pt-10 sm:pt-24 lg:pt-[120px]">
            <div class="container">
                <!-- HEADER -->
                <div class="grid items-center grid-cols-12 gap-4">
                    <div class="col-span-full text-center max-w-[594px] mx-auto">
                        <div class="area-subtitle">
                            Testimonials
                        </div>
                        <h2 class="mt-2 area-title">
                            Edulab Received More than
                            <span class="title-highlight-one">9 +</span>
                            Reviews
                        </h2>
                    </div>
                </div>
                <!-- BODY -->
                <div class="swiper testimonial-slider xl:mt-[60px]">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div
                                class="flex flex-col items-center h-full xl:flex-row rtl:xl:flex-row-reverse group/testimonial">
                                <div
                                    class="flex-center size-24 rounded-50 border border-primary p-1.5 overflow-hidden shrink-0 xl:translate-x-12 translate-y-12 xl:translate-y-0">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/testimonials/lms-YzEEwRgb.webp"
                                        alt="Testimonial image"
                                        class="object-cover size-full rounded-50 group-hover/testimonial:scale-110 custom-transition">
                                </div>
                                <div
                                    class="h-full bg-primary-50 rounded-2xl p-[80px_30px_30px] xl:p-[50px_30px_50px_80px] grow">
                                    <div class="flex items-center gap-0.5 text-secondary">
                                        <i class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i>
                                    </div>
                                    <div class="mt-5 area-description line-clamp-3">
                                        <p>The gamification elements, like earning badges and completing challenges,
                                            kept me motivated to achieve my goals. The detailed analytics were another
                                            bonus—they helped me understand my strengths and areas for improvement.</p>
                                    </div>
                                    <div class="flex justify-between mt-10">
                                        <div class="shrink-0 grow">
                                            <h6 class="area-title text-lg !leading-none">
                                                Ava Thompson</h6>
                                            <p class="area-description !leading-none mt-1.5">
                                                UI/UX Designer
                                            </p>
                                        </div>
                                        <img data-src="https://edulab.hivetheme.com/lms/frontend/assets/images/icons/quote.svg"
                                            alt="Quote icon" class="shrink-0 animate-bounce">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="flex flex-col items-center h-full xl:flex-row rtl:xl:flex-row-reverse group/testimonial">
                                <div
                                    class="flex-center size-24 rounded-50 border border-primary p-1.5 overflow-hidden shrink-0 xl:translate-x-12 translate-y-12 xl:translate-y-0">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/testimonials/lms-tzWtFUBy.webp"
                                        alt="Testimonial image"
                                        class="object-cover size-full rounded-50 group-hover/testimonial:scale-110 custom-transition">
                                </div>
                                <div
                                    class="h-full bg-primary-50 rounded-2xl p-[80px_30px_30px] xl:p-[50px_30px_50px_80px] grow">
                                    <div class="flex items-center gap-0.5 text-secondary">
                                        <i class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-line text-inherit"></i>
                                    </div>
                                    <div class="mt-5 area-description line-clamp-3">
                                        <p>El curso proporcionó conocimientos profundos y enfoques innovadores para el
                                            diseño. Fue un punto de inflexión en el flujo de trabajo de mi equipo.</p>
                                    </div>
                                    <div class="flex justify-between mt-10">
                                        <div class="shrink-0 grow">
                                            <h6 class="area-title text-lg !leading-none">
                                                William Scott</h6>
                                            <p class="area-description !leading-none mt-1.5">
                                                Director creativo
                                            </p>
                                        </div>
                                        <img data-src="https://edulab.hivetheme.com/lms/frontend/assets/images/icons/quote.svg"
                                            alt="Quote icon" class="shrink-0 animate-bounce">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="flex flex-col items-center h-full xl:flex-row rtl:xl:flex-row-reverse group/testimonial">
                                <div
                                    class="flex-center size-24 rounded-50 border border-primary p-1.5 overflow-hidden shrink-0 xl:translate-x-12 translate-y-12 xl:translate-y-0">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/testimonials/lms-LP6uifF5.webp"
                                        alt="Testimonial image"
                                        class="object-cover size-full rounded-50 group-hover/testimonial:scale-110 custom-transition">
                                </div>
                                <div
                                    class="h-full bg-primary-50 rounded-2xl p-[80px_30px_30px] xl:p-[50px_30px_50px_80px] grow">
                                    <div class="flex items-center gap-0.5 text-secondary">
                                        <i class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-half-fill text-inherit"></i>
                                    </div>
                                    <div class="mt-5 area-description line-clamp-3">
                                        <p>I’ve gained skills and knowledge that I can immediately apply in real life.
                                            It’s not just about completing courses; it’s about truly growing as a
                                            learner. I’m so grateful for the support and resources this platform
                                            provides—it’s made a world of difference in my educational journey</p>
                                    </div>
                                    <div class="flex justify-between mt-10">
                                        <div class="shrink-0 grow">
                                            <h6 class="area-title text-lg !leading-none">
                                                Ethan Robinson</h6>
                                            <p class="area-description !leading-none mt-1.5">
                                                Junior App Developer
                                            </p>
                                        </div>
                                        <img data-src="https://edulab.hivetheme.com/lms/frontend/assets/images/icons/quote.svg"
                                            alt="Quote icon" class="shrink-0 animate-bounce">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="flex flex-col items-center h-full xl:flex-row rtl:xl:flex-row-reverse group/testimonial">
                                <div
                                    class="flex-center size-24 rounded-50 border border-primary p-1.5 overflow-hidden shrink-0 xl:translate-x-12 translate-y-12 xl:translate-y-0">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/testimonials/lms-Mz49pLE7.webp"
                                        alt="Testimonial image"
                                        class="object-cover size-full rounded-50 group-hover/testimonial:scale-110 custom-transition">
                                </div>
                                <div
                                    class="h-full bg-primary-50 rounded-2xl p-[80px_30px_30px] xl:p-[50px_30px_50px_80px] grow">
                                    <div class="flex items-center gap-0.5 text-secondary">
                                        <i class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i>
                                    </div>
                                    <div class="mt-5 area-description line-clamp-3">
                                        <p>One of the things I love most about this how flexible it is. I can access my
                                            courses anytime and on any device, which fits perfectly into my busy
                                            schedule. Whether I’m at home or on the go, I never miss an opportunity to
                                            learn.</p>
                                    </div>
                                    <div class="flex justify-between mt-10">
                                        <div class="shrink-0 grow">
                                            <h6 class="area-title text-lg !leading-none">
                                                Noah Williams</h6>
                                            <p class="area-description !leading-none mt-1.5">
                                                Full-Stack Developer
                                            </p>
                                        </div>
                                        <img data-src="https://edulab.hivetheme.com/lms/frontend/assets/images/icons/quote.svg"
                                            alt="Quote icon" class="shrink-0 animate-bounce">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="flex flex-col items-center h-full xl:flex-row rtl:xl:flex-row-reverse group/testimonial">
                                <div
                                    class="flex-center size-24 rounded-50 border border-primary p-1.5 overflow-hidden shrink-0 xl:translate-x-12 translate-y-12 xl:translate-y-0">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/testimonials/lms-2ptcGu4d.webp"
                                        alt="Testimonial image"
                                        class="object-cover size-full rounded-50 group-hover/testimonial:scale-110 custom-transition">
                                </div>
                                <div
                                    class="h-full bg-primary-50 rounded-2xl p-[80px_30px_30px] xl:p-[50px_30px_50px_80px] grow">
                                    <div class="flex items-center gap-0.5 text-secondary">
                                        <i class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i>
                                    </div>
                                    <div class="mt-5 area-description line-clamp-3">
                                        <p>The content delivery is seamless, with a mix of videos, quizzes, and
                                            assignments that keep things interesting. I also appreciate the interactive
                                            features like discussion boards and group activities, which allow me to
                                            collaborate with other learners and feel part of a community.</p>
                                    </div>
                                    <div class="flex justify-between mt-10">
                                        <div class="shrink-0 grow">
                                            <h6 class="area-title text-lg !leading-none">
                                                Liam Martinez</h6>
                                            <p class="area-description !leading-none mt-1.5">
                                                Lead Developer
                                            </p>
                                        </div>
                                        <img data-src="https://edulab.hivetheme.com/lms/frontend/assets/images/icons/quote.svg"
                                            alt="Quote icon" class="shrink-0 animate-bounce">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="flex flex-col items-center h-full xl:flex-row rtl:xl:flex-row-reverse group/testimonial">
                                <div
                                    class="flex-center size-24 rounded-50 border border-primary p-1.5 overflow-hidden shrink-0 xl:translate-x-12 translate-y-12 xl:translate-y-0">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/testimonials/lms-57sGF46I.webp"
                                        alt="Testimonial image"
                                        class="object-cover size-full rounded-50 group-hover/testimonial:scale-110 custom-transition">
                                </div>
                                <div
                                    class="h-full bg-primary-50 rounded-2xl p-[80px_30px_30px] xl:p-[50px_30px_50px_80px] grow">
                                    <div class="flex items-center gap-0.5 text-secondary">
                                        <i class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-line text-inherit"></i>
                                    </div>
                                    <div class="mt-5 area-description line-clamp-3">
                                        <p>Practical and insightful! The knowledge I gained here has directly impacted
                                            my ability to deliver better results for my clients.</p>
                                    </div>
                                    <div class="flex justify-between mt-10">
                                        <div class="shrink-0 grow">
                                            <h6 class="area-title text-lg !leading-none">
                                                Olivia Brown</h6>
                                            <p class="area-description !leading-none mt-1.5">
                                                Digital Marketer
                                            </p>
                                        </div>
                                        <img data-src="https://edulab.hivetheme.com/lms/frontend/assets/images/icons/quote.svg"
                                            alt="Quote icon" class="shrink-0 animate-bounce">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="flex flex-col items-center h-full xl:flex-row rtl:xl:flex-row-reverse group/testimonial">
                                <div
                                    class="flex-center size-24 rounded-50 border border-primary p-1.5 overflow-hidden shrink-0 xl:translate-x-12 translate-y-12 xl:translate-y-0">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/testimonials/lms-MCmsOWRT.webp"
                                        alt="Testimonial image"
                                        class="object-cover size-full rounded-50 group-hover/testimonial:scale-110 custom-transition">
                                </div>
                                <div
                                    class="h-full bg-primary-50 rounded-2xl p-[80px_30px_30px] xl:p-[50px_30px_50px_80px] grow">
                                    <div class="flex items-center gap-0.5 text-secondary">
                                        <i class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-line text-inherit"></i>
                                    </div>
                                    <div class="mt-5 area-description line-clamp-3">
                                        <p>The best investment I’ve made in my career. The personalized feedback and
                                            professional-level projects gave me a competitive edge</p>
                                    </div>
                                    <div class="flex justify-between mt-10">
                                        <div class="shrink-0 grow">
                                            <h6 class="area-title text-lg !leading-none">
                                                Mia Anderson</h6>
                                            <p class="area-description !leading-none mt-1.5">
                                                Design Consultant
                                            </p>
                                        </div>
                                        <img data-src="https://edulab.hivetheme.com/lms/frontend/assets/images/icons/quote.svg"
                                            alt="Quote icon" class="shrink-0 animate-bounce">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="flex flex-col items-center h-full xl:flex-row rtl:xl:flex-row-reverse group/testimonial">
                                <div
                                    class="flex-center size-24 rounded-50 border border-primary p-1.5 overflow-hidden shrink-0 xl:translate-x-12 translate-y-12 xl:translate-y-0">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/testimonials/lms-V9IneIek.webp"
                                        alt="Testimonial image"
                                        class="object-cover size-full rounded-50 group-hover/testimonial:scale-110 custom-transition">
                                </div>
                                <div
                                    class="h-full bg-primary-50 rounded-2xl p-[80px_30px_30px] xl:p-[50px_30px_50px_80px] grow">
                                    <div class="flex items-center gap-0.5 text-secondary">
                                        <i class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i>
                                    </div>
                                    <div class="mt-5 area-description line-clamp-3">
                                        <p>One of the things I love most about this how flexible it is. I can access my
                                            courses anytime and on any device, which fits perfectly into my busy
                                            schedule. Whether I’m at home or on the go, I never miss an opportunity to
                                            learn.</p>
                                    </div>
                                    <div class="flex justify-between mt-10">
                                        <div class="shrink-0 grow">
                                            <h6 class="area-title text-lg !leading-none">
                                                Sophia Patel</h6>
                                            <p class="area-description !leading-none mt-1.5">
                                                Marketing Specialist
                                            </p>
                                        </div>
                                        <img data-src="https://edulab.hivetheme.com/lms/frontend/assets/images/icons/quote.svg"
                                            alt="Quote icon" class="shrink-0 animate-bounce">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="flex flex-col items-center h-full xl:flex-row rtl:xl:flex-row-reverse group/testimonial">
                                <div
                                    class="flex-center size-24 rounded-50 border border-primary p-1.5 overflow-hidden shrink-0 xl:translate-x-12 translate-y-12 xl:translate-y-0">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/testimonials/lms-uwKObBQR.webp"
                                        alt="Testimonial image"
                                        class="object-cover size-full rounded-50 group-hover/testimonial:scale-110 custom-transition">
                                </div>
                                <div
                                    class="h-full bg-primary-50 rounded-2xl p-[80px_30px_30px] xl:p-[50px_30px_50px_80px] grow">
                                    <div class="flex items-center gap-0.5 text-secondary">
                                        <i class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i><i
                                            class="ri-star-fill text-inherit"></i>
                                    </div>
                                    <div class="mt-5 area-description line-clamp-3">
                                        <p>One of the things I love most about this how flexible it is. I can access my
                                            courses anytime and on any device, which fits perfectly into my busy
                                            schedule. Whether I’m at home or on the go, I never miss an opportunity to
                                            learn.</p>
                                    </div>
                                    <div class="flex justify-between mt-10">
                                        <div class="shrink-0 grow">
                                            <h6 class="area-title text-lg !leading-none">
                                                Emma Johnson</h6>
                                            <p class="area-description !leading-none mt-1.5">
                                                Senior Product Manager
                                            </p>
                                        </div>
                                        <img data-src="https://edulab.hivetheme.com/lms/frontend/assets/images/icons/quote.svg"
                                            alt="Quote icon" class="shrink-0 animate-bounce">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- SWIPER PAGINATION -->
                <div class="flex-center mt-10 lg:mt-[60px]">
                    <div class="testimonial-pagination swiper-custom-pagination"></div>
                </div>
            </div>
        </div>
        <!-- END TESTIMONIAL AREA -->

        <!-- START COUNTER AREA -->
        <!-- counter -->
        <div class="container max-w-[1600px] my-16 sm:my-24 lg:my-[120px]">
            <div class="bg-primary px-10 py-[60px] rounded-[20px]">
                <div
                    class="grid grid-cols-12 divide-y lg:divide-y-0 lg:divide-x rtl:lg:divide-x-reverse divide-white/15">
                    <div
                        class="col-span-full lg:col-span-3 [&:not(:first-child)]:pt-4 [&:not(:first-child)]:lg:pt-0 [&:not(:first-child)]:lg:pl-4 [&:not(:first-child)]:mt-4 [&:not(:first-child)]:lg:mt-0 [&:not(:first-child)]:lg:ml-4">
                        <div class="flex-center flex-col gap-3.5">
                            <div class="text-lg font-bold leading-none text-white">
                                Course
                            </div>
                            <h6 class="text-white text-[54px] font-extrabold leading-none">
                                15+
                            </h6>
                        </div>
                    </div>
                    <div
                        class="col-span-full lg:col-span-3 [&:not(:first-child)]:pt-4 [&:not(:first-child)]:lg:pt-0 [&:not(:first-child)]:lg:pl-4 [&:not(:first-child)]:mt-4 [&:not(:first-child)]:lg:mt-0 [&:not(:first-child)]:lg:ml-4">
                        <div class="flex-center flex-col gap-3.5">
                            <div class="text-lg font-bold leading-none text-white">
                                Years Experience
                            </div>
                            <h6 class="text-white text-[54px] font-extrabold leading-none">
                                25+
                            </h6>
                        </div>
                    </div>
                    <div
                        class="col-span-full lg:col-span-3 [&:not(:first-child)]:pt-4 [&:not(:first-child)]:lg:pt-0 [&:not(:first-child)]:lg:pl-4 [&:not(:first-child)]:mt-4 [&:not(:first-child)]:lg:mt-0 [&:not(:first-child)]:lg:ml-4">
                        <div class="flex-center flex-col gap-3.5">
                            <div class="text-lg font-bold leading-none text-white">
                                Expert Tutors
                            </div>
                            <h6 class="text-white text-[54px] font-extrabold leading-none">
                                13+
                            </h6>
                        </div>
                    </div>
                    <div
                        class="col-span-full lg:col-span-3 [&:not(:first-child)]:pt-4 [&:not(:first-child)]:lg:pt-0 [&:not(:first-child)]:lg:pl-4 [&:not(:first-child)]:mt-4 [&:not(:first-child)]:lg:mt-0 [&:not(:first-child)]:lg:ml-4">
                        <div class="flex-center flex-col gap-3.5">
                            <div class="text-lg font-bold leading-none text-white">
                                Satisfied Students
                            </div>
                            <h6 class="text-white text-[54px] font-extrabold leading-none">
                                19+
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END COUNTER AREA -->

        <!-- START UPCOMING COURSE AREA -->
        <div class="bg-primary-50 py-16 sm:py-24 lg:py-[120px]">
            <div class="container">
                <!-- HEADER -->
                <div class="grid items-center grid-cols-12 gap-4">
                    <div class="col-span-full text-center max-w-[594px] mx-auto">
                        <div class="area-subtitle">
                            Upcoming Courses
                        </div>
                        <h2 class="mt-2 area-title">
                            Our Upcoming
                            <span class="title-highlight-one">
                                Courses
                            </span>
                        </h2>
                    </div>
                </div>
                <!-- BODY -->
                <div class="swiper up-coming-courses-slider mt-10 lg:mt-[60px]">
                    <div class="swiper-wrapper">

                        <!-- COURSE CARD -->
                        <?php foreach ($courses as $course) {
                            $course_id = $course['id'];
                            $enrollmentStmt = $conn->query("SELECT COUNT(*) AS student_count FROM enrollments WHERE course_id = $course_id");
                            $enrollments = $enrollmentStmt->fetch(PDO::FETCH_ASSOC); ?>
                            <div
                                class="swiper-slide col-span-full md:col-span-6 xl:col-span-4 group-data-[card-layout=list]:!col-span-full">
                                <div
                                    class="flex flex-col bg-white rounded-2xl h-full p-5 group-data-[card-layout=list]:flex-row [&.card-border]:border [&.card-border]:border-border [&.card-border]:hover:shadow-md custom-transition group/course ">
                                    <!-- COURSE THUMBNAIL -->
                                    <div class="relative overflow-hidden aspect-video rounded-xl">
                                        <img data-src="<?php echo $course["feature_image"] ?? null ?>"
                                            class="w-full h-64 duration-300 hover:text-primary course-grid-thumb-img group-hover/topCourse:scale-110"
                                            alt="Course thumbnail">
                                        <!-- badge -->
                                        <span
                                            class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 left-4 rtl:left-auto rtl:right-4 z-10">Expert
                                        </span>
                                    </div>
                                    <!-- COURSE CONTENT -->
                                    <div class="mt-6 group-data-[card-layout=list]:mt-0 group-data-[card-layout=list]:ml-6">
                                        <div class="flex-center-between">
                                            <div class="rounded-full badge badge-heading-outline b-outline shrink-0">
                                                <?php echo $course["category_name"] ?? null ?></div>
                                            <div
                                                class="text-primary text-xl !leading-none font-bold text-right shrink-0 flex items-center gap-1.5">
                                                <span>Free</span>
                                            </div>
                                        </div>
                                        <h6 class="area-title font-bold !text-xl group-hover/course:text-primary pt-3 pb-3 leading-9 text-black transition hover:text-blue-600 hover:text-primary">
                                            <a href="./topics.php?id=<?php echo $course["id"] ?? null ?>"
                                                class=" line-clamp-2" aria-label="Course title">
                                                <?= $course['title'] ?? 'Untitled Course' ?>
                                            </a>
                                        </h6>


                                        <div class="gap-2 pt-4 mt-6 border-t flex-center-between border-heading/10">
                                            <div
                                                class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                                <i class="ri-time-line"></i>
                                                <span>3h</span>
                                            </div>
                                            <div class="flex items-center gap-4 shrink-0">

                                                <div
                                                    class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                                    <i class="ri-book-line"></i>
                                                    <span><?php echo $course["topic_count"] ?> Lessons </span>
                                                </div>
                                                <div class="flex items-center gap-1 area-description text-sm text-gray-500 !leading-none shrink-0">
                                                    <i class="mr-1 text-base ri-book-line"></i>
                                                    <span><?= $enrollments["student_count"] . " Students" ?? '0 Lessons' ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- COURSE CARD -->
                        <div
                            class="swiper-slide col-span-full md:col-span-6 xl:col-span-4 group-data-[card-layout=list]:!col-span-full">
                            <div
                                class="flex flex-col bg-white rounded-2xl h-full p-5 group-data-[card-layout=list]:flex-row [&.card-border]:border [&.card-border]:border-border [&.card-border]:hover:shadow-md custom-transition group/course ">
                                <!-- COURSE THUMBNAIL -->
                                <div class="relative overflow-hidden aspect-video rounded-xl">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/courses/thumbnails/lms-J1UijeFL.webp"
                                        class="w-full duration-300 course-grid-thumb-img group-hover/topCourse:scale-110"
                                        alt="Course thumbnail">
                                    <!-- badge -->
                                    <span
                                        class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 left-4 rtl:left-auto rtl:right-4 z-10">Intermediate
                                    </span>
                                </div>
                                <!-- COURSE CONTENT -->
                                <div class="mt-6 group-data-[card-layout=list]:mt-0 group-data-[card-layout=list]:ml-6">
                                    <div class="flex-center-between">
                                        <div class="rounded-full badge badge-heading-outline b-outline shrink-0">
                                            Tech</div>
                                        <div
                                            class="text-primary text-xl !leading-none font-bold text-right shrink-0 flex items-center gap-1.5">
                                            <span>Free</span>
                                        </div>
                                    </div>
                                    <h6
                                        class="area-title font-bold !text-xl mt-3 group-hover/course:text-primary custom-transition">
                                        <a href="#"
                                            class="line-clamp-2" aria-label="Course title">App Development with Flutter
                                            and react native</a>
                                    </h6>


                                    <div class="gap-2 pt-4 mt-6 border-t flex-center-between border-heading/10">
                                        <div
                                            class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                            <i class="ri-time-line"></i>
                                            <span>2h</span>
                                        </div>
                                        <div class="flex items-center gap-4 shrink-0">
                                            <div
                                                class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                                <i class="ri-book-line"></i>
                                                <span>4 Lessons </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COURSE CARD -->
                        <div
                            class="swiper-slide col-span-full md:col-span-6 xl:col-span-4 group-data-[card-layout=list]:!col-span-full">
                            <div
                                class="flex flex-col bg-white rounded-2xl h-full p-5 group-data-[card-layout=list]:flex-row [&.card-border]:border [&.card-border]:border-border [&.card-border]:hover:shadow-md custom-transition group/course ">
                                <!-- COURSE THUMBNAIL -->
                                <div class="relative overflow-hidden aspect-video rounded-xl">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/courses/thumbnails/lms-qzbF1cvq.webp"
                                        class="w-full duration-300 course-grid-thumb-img group-hover/topCourse:scale-110"
                                        alt="Course thumbnail">
                                    <!-- badge -->
                                    <span
                                        class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 left-4 rtl:left-auto rtl:right-4 z-10">Intermediate
                                    </span>
                                </div>
                                <!-- COURSE CONTENT -->
                                <div class="mt-6 group-data-[card-layout=list]:mt-0 group-data-[card-layout=list]:ml-6">
                                    <div class="flex-center-between">
                                        <div class="rounded-full badge badge-heading-outline b-outline shrink-0">
                                            Tech</div>
                                        <div
                                            class="text-primary text-xl !leading-none font-bold text-right shrink-0 flex items-center gap-1.5">
                                            <span>Free</span>
                                        </div>
                                    </div>
                                    <h6
                                        class="area-title font-bold !text-xl mt-3 group-hover/course:text-primary custom-transition">
                                        <a href="#"
                                            class="line-clamp-2" aria-label="Course title">Build a Blockchain and a
                                            Cryptocurrency from Scratch</a>
                                    </h6>


                                    <div class="gap-2 pt-4 mt-6 border-t flex-center-between border-heading/10">
                                        <div
                                            class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                            <i class="ri-time-line"></i>
                                            <span>00:05:00</span>
                                        </div>
                                        <div class="flex items-center gap-4 shrink-0">
                                            <div
                                                class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                                <i class="ri-book-line"></i>
                                                <span>4 Lessons </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COURSE CARD -->
                        <div
                            class="swiper-slide col-span-full md:col-span-6 xl:col-span-4 group-data-[card-layout=list]:!col-span-full">
                            <div
                                class="flex flex-col bg-white rounded-2xl h-full p-5 group-data-[card-layout=list]:flex-row [&.card-border]:border [&.card-border]:border-border [&.card-border]:hover:shadow-md custom-transition group/course ">
                                <!-- COURSE THUMBNAIL -->
                                <div class="relative overflow-hidden aspect-video rounded-xl">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/courses/thumbnails/lms-3szF5xcY.webp"
                                        class="w-full duration-300 course-grid-thumb-img group-hover/topCourse:scale-110"
                                        alt="Course thumbnail">
                                    <!-- badge -->
                                    <span
                                        class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 left-4 rtl:left-auto rtl:right-4 z-10">Advanced
                                    </span>
                                </div>
                                <!-- COURSE CONTENT -->
                                <div class="mt-6 group-data-[card-layout=list]:mt-0 group-data-[card-layout=list]:ml-6">
                                    <div class="flex-center-between">
                                        <div class="rounded-full badge badge-heading-outline b-outline shrink-0">
                                            UI/UX Design</div>
                                        <div
                                            class="text-primary text-xl !leading-none font-bold text-right shrink-0 flex items-center gap-1.5">
                                            <span>Free</span>
                                        </div>
                                    </div>
                                    <h6
                                        class="area-title font-bold !text-xl mt-3 group-hover/course:text-primary custom-transition">
                                        <a href="#"
                                            class="line-clamp-2" aria-label="Course title">Comprehensive Product Design
                                            Course for Skill Development</a>
                                    </h6>


                                    <div class="gap-2 pt-4 mt-6 border-t flex-center-between border-heading/10">
                                        <div
                                            class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                            <i class="ri-time-line"></i>
                                            <span>2h 50m</span>
                                        </div>
                                        <div class="flex items-center gap-4 shrink-0">
                                            <div
                                                class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                                <i class="ri-book-line"></i>
                                                <span>0 Lessons </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COURSE CARD -->
                        <div
                            class="swiper-slide col-span-full md:col-span-6 xl:col-span-4 group-data-[card-layout=list]:!col-span-full">
                            <div
                                class="flex flex-col bg-white rounded-2xl h-full p-5 group-data-[card-layout=list]:flex-row [&.card-border]:border [&.card-border]:border-border [&.card-border]:hover:shadow-md custom-transition group/course ">
                                <!-- COURSE THUMBNAIL -->
                                <div class="relative overflow-hidden aspect-video rounded-xl">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/courses/thumbnails/lms-hcgdWWKk.webp"
                                        class="w-full duration-300 course-grid-thumb-img group-hover/topCourse:scale-110"
                                        alt="Course thumbnail">
                                    <!-- badge -->
                                    <span
                                        class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 left-4 rtl:left-auto rtl:right-4 z-10">Professional
                                    </span>
                                </div>
                                <!-- COURSE CONTENT -->
                                <div class="mt-6 group-data-[card-layout=list]:mt-0 group-data-[card-layout=list]:ml-6">
                                    <div class="flex-center-between">
                                        <div class="rounded-full badge badge-heading-outline b-outline shrink-0">
                                            UI/UX Design</div>
                                        <div
                                            class="text-primary text-xl !leading-none font-bold text-right shrink-0 flex items-center gap-1.5">
                                            <span>$0</span>
                                        </div>
                                    </div>
                                    <h6
                                        class="area-title font-bold !text-xl mt-3 group-hover/course:text-primary custom-transition">
                                        <a href="#"
                                            class="line-clamp-2" aria-label="Course title">Webflow Development for
                                            Building Modern Website</a>
                                    </h6>


                                    <div class="gap-2 pt-4 mt-6 border-t flex-center-between border-heading/10">
                                        <div
                                            class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                            <i class="ri-time-line"></i>
                                            <span>2h 30m</span>
                                        </div>
                                        <div class="flex items-center gap-4 shrink-0">
                                            <div
                                                class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                                <i class="ri-book-line"></i>
                                                <span>6 Lessons </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-center mt-10 lg:mt-[60px]">
                    <a href="#" title="View Upcoming Course"
                        class="btn b-outline btn-primary-outline btn-xl !rounded-full font-medium text-[16px] md:text-[18px]"
                        aria-label="View Upcoming Course">
                        View Upcoming Course
                        <span class="hidden md:block">
                            <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <!-- END UPCOMING COURSE AREA -->

        <!-- START INSTRUCTOR AREA -->
        <div class="bg-white py-16 sm:py-24 lg:py-[120px]">
            <div class="container">
                <!-- HEADER -->
                <div class="grid items-center grid-cols-12 gap-4">
                    <div class="col-span-full md:col-span-7 xl:col-span-6 md:pr-20">
                        <div class="area-subtitle">
                            Our Team Member
                        </div>
                        <h2 class="mt-2 area-title">
                            Meet Our Best
                            <span class="title-highlight-one"> Instructors </span>
                        </h2>
                    </div>
                    <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                        <a href="#" title="More Instructors"
                            class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium text-[16px] md:text-[18px]"
                            aria-label="More Instructors">
                            More Instructors
                            <span class="hidden md:block">
                                <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <!-- BODY -->
                <div class="swiper instructor-slider mt-10 lg:mt-[60px]">
                    <div class="swiper-wrapper">
                        <!-- SINGLE INSTRUCTOR -->
                        <?php foreach ($teacherEnrolls as $teachers) { ?>
                            <div class="swiper-slide col-span-full sm:col-span-6 xl:col-span-4">
                                <div class="flex flex-col group/instructor">
                                    <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                                        <img data-src="<?php echo $teachers["profile_image"] ?? null ?>"
                                            alt="Thumbnail image"
                                            class="object-cover size-full group-hover/instructor:scale-110 custom-transition">
                                    </div>
                                    <div class="flex justify-between mt-6">
                                        <div class="shrink-0 grow">
                                            <h6 class="cursor-pointer sm:w-[65%] md:w-[80%] lg:w-[65%] area-title text-xl font-bold group-hover/instructor:text-primary custom-transition">
                                                <a href="#" class="flex items-center justify-between" aria-label="Instructor full name">
                                                    <!-- Instructor Name -->
                                                    <div class="flex items-center gap-2 truncate">
                                                        <span><?= $teachers["first_name"] ?? null; ?></span>
                                                        <span><?= $teachers["last_name"] ?? null; ?></span>
                                                    </div>
                                                    <!-- Icon -->
                                                    <i class="ri-arrow-right-line text-[20px] text-gray-600 transition-transform duration-300 group-hover:translate-x-1"></i>
                                                </a>
                                            </h6>

                                            <p class="area-description !leading-none mt-1.5 sm:w-[20%] md:w-[70%] lg:w-[60%]">
                                                <?= $teachers["course_title"] ?? null ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="swiper-slide col-span-full sm:col-span-6 xl:col-span-4">
                            <div class="flex flex-col group/instructor">
                                <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-txQEJxay.webp"
                                        alt="Thumbnail image"
                                        class="object-cover size-full group-hover/instructor:scale-110 custom-transition">
                                </div>
                                <div class="flex justify-between mt-6">
                                    <div class="shrink-0 grow">
                                        <h6
                                            class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                            <a href="#"
                                                class="flex items-center justify-between"
                                                aria-label="Instructor full name">
                                                Sarah Johnson
                                                <i
                                                    class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                            </a>
                                        </h6>
                                        <p class="area-description !leading-none mt-1.5">
                                            UX/UI Designer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide col-span-full sm:col-span-6 xl:col-span-4">
                            <div class="flex flex-col group/instructor">
                                <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-6Dv0EyvQ.webp"
                                        alt="Thumbnail image"
                                        class="object-cover size-full group-hover/instructor:scale-110 custom-transition">
                                </div>
                                <div class="flex justify-between mt-6">
                                    <div class="shrink-0 grow">
                                        <h6
                                            class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                            <a href=""
                                                class="flex items-center justify-between"
                                                aria-label="Instructor full name">
                                                John Abraham
                                                <i
                                                    class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                            </a>
                                        </h6>
                                        <p class="area-description !leading-none mt-1.5">
                                            UX/UI Designer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide col-span-full sm:col-span-6 xl:col-span-4">
                            <div class="flex flex-col group/instructor">
                                <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-dq2Qr9k2.webp"
                                        alt="Thumbnail image"
                                        class="object-cover size-full group-hover/instructor:scale-110 custom-transition">
                                </div>
                                <div class="flex justify-between mt-6">
                                    <div class="shrink-0 grow">
                                        <h6
                                            class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                            <a href="#"
                                                class="flex items-center justify-between"
                                                aria-label="Instructor full name">
                                                Emma Brown
                                                <i
                                                    class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                            </a>
                                        </h6>
                                        <p class="area-description !leading-none mt-1.5">
                                            Data Scientist</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide col-span-full sm:col-span-6 xl:col-span-4">
                            <div class="flex flex-col group/instructor">
                                <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-prnZ4ooz.webp"
                                        alt="Thumbnail image"
                                        class="object-cover size-full group-hover/instructor:scale-110 custom-transition">
                                </div>
                                <div class="flex justify-between mt-6">
                                    <div class="shrink-0 grow">
                                        <h6
                                            class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                            <a href=""
                                                class="flex items-center justify-between"
                                                aria-label="Instructor full name">
                                                Ahmed Hassan
                                                <i
                                                    class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                            </a>
                                        </h6>
                                        <p class="area-description !leading-none mt-1.5">
                                            Mobile App Developer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="swiper-slide col-span-full sm:col-span-6 xl:col-span-4">
                            <div class="flex flex-col group/instructor">
                                <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-XjMjZbvH.webp"
                                        alt="Thumbnail image"
                                        class="object-cover size-full group-hover/instructor:scale-110 custom-transition">
                                </div>
                                <div class="flex justify-between mt-6">
                                    <div class="shrink-0 grow">
                                        <h6
                                            class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                            <a href=""
                                                class="flex items-center justify-between"
                                                aria-label="Instructor full name">
                                                Olivia Martinez
                                                <i
                                                    class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                            </a>
                                        </h6>
                                        <p class="area-description !leading-none mt-1.5">
                                            Graphic Designer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide col-span-full sm:col-span-6 xl:col-span-4">
                            <div class="flex flex-col group/instructor">
                                <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-ItaQqrmm.webp"
                                        alt="Thumbnail image"
                                        class="object-cover size-full group-hover/instructor:scale-110 custom-transition">
                                </div>
                                <div class="flex justify-between mt-6">
                                    <div class="shrink-0 grow">
                                        <h6
                                            class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                            <a href=""
                                                class="flex items-center justify-between"
                                                aria-label="Instructor full name">
                                                Chen Wei
                                                <i
                                                    class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                            </a>
                                        </h6>
                                        <p class="area-description !leading-none mt-1.5">
                                            Cybersecurity Expert</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide col-span-full sm:col-span-6 xl:col-span-4">
                            <div class="flex flex-col group/instructor">
                                <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-YWjtcEFx.webp"
                                        alt="Thumbnail image"
                                        class="object-cover size-full group-hover/instructor:scale-110 custom-transition">
                                </div>
                                <div class="flex justify-between mt-6">
                                    <div class="shrink-0 grow">
                                        <h6
                                            class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                            <a href=""
                                                class="flex items-center justify-between"
                                                aria-label="Instructor full name">
                                                Smith Nguyen
                                                <i
                                                    class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                            </a>
                                        </h6>
                                        <p class="area-description !leading-none mt-1.5">
                                            Digital Marketing Specialist</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide col-span-full sm:col-span-6 xl:col-span-4">
                            <div class="flex flex-col group/instructor">
                                <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-ObZnCY4y.webp"
                                        alt="Thumbnail image"
                                        class="object-cover size-full group-hover/instructor:scale-110 custom-transition">
                                </div>
                                <div class="flex justify-between mt-6">
                                    <div class="shrink-0 grow">
                                        <h6
                                            class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                            <a href=""
                                                class="flex items-center justify-between"
                                                aria-label="Instructor full name">
                                                Robert Bloom
                                                <i
                                                    class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                            </a>
                                        </h6>
                                        <p class="area-description !leading-none mt-1.5">
                                            Senior JavaScript Developer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide col-span-full sm:col-span-6 xl:col-span-4">
                            <div class="flex flex-col group/instructor">
                                <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                                    <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-4dtpfg8z.webp"
                                        alt="Thumbnail image"
                                        class="object-cover size-full group-hover/instructor:scale-110 custom-transition">
                                </div>
                                <div class="flex justify-between mt-6">
                                    <div class="shrink-0 grow">
                                        <h6
                                            class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                            <a href="#"
                                                class="flex items-center justify-between"
                                                aria-label="Instructor full name">
                                                Kabir Hosen
                                                <i
                                                    class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                            </a>
                                        </h6>
                                        <p class="area-description !leading-none mt-1.5">
                                            Instructor</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END INSTRUCTOR AREA -->

        <!-- START ONLINE VIDEO COURSE AREA -->
        <div
            class="relative pt-16 sm:pt-24 lg:pt-[120px] pb-24 lg:pb-40 xl:pb-[200px] before:absolute before:size-full before:inset-0 before:bg-video before:blur-[100px] before:opacity-10 overflow-hidden">
            <div class="container relative z-10">
                <div class="grid grid-cols-12 gap-7">
                    <div class="relative self-end col-span-full lg:col-span-7">
                        <div class="area-subtitle">
                            Intro
                        </div>
                        <h2 class="mt-2 area-title">
                            Become an
                            <span class="title-highlight-one">
                                Instructor
                            </span>
                        </h2>
                        <div class="mt-10 overflow-hidden rounded-2xl">
                            <div class="swiper online-video-slider">
                                <div class="swiper-wrapper">
                                    <!-- SINGLE ITEM -->
                                    <div class="swiper-slide">
                                        <div
                                            class="flex-center relative video-wrapper w-full h-[430px] rounded-2xl overflow-hidden">
                                            <video class="object-cover cursor-pointer size-full rounded-2xl">
                                                <source src="media/video.mp4" type="video/mp4">
                                            </video>
                                            <!-- CONTROLLER -->
                                            <div
                                                class="controll-wrapper flex-center size-full bg-[#D9D9D9]/30 rounded-2xl absolute inset-0 [&.hide]:invisible">
                                                <button type="button" aria-label="Video popup button"
                                                    class="controller btn-icon size-[60px] b-solid btn-secondary-icon-solid !text-heading dark:text-white pulse-animation active:scale-105">
                                                    <i class="text-2xl ri-play-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- SINGLE ITEM -->
                                    <div class="swiper-slide">
                                        <div
                                            class="flex-center relative video-wrapper w-full h-[430px] rounded-2xl overflow-hidden">
                                            <video class="object-cover cursor-pointer size-full rounded-2xl">
                                                <source src="media/video.mp4" type="video/mp4">
                                            </video>
                                            <!-- CONTROLLER -->
                                            <div
                                                class="controll-wrapper flex-center size-full bg-[#D9D9D9]/30 rounded-2xl absolute inset-0 [&.hide]:invisible">
                                                <button type="button" aria-label="Video popup button"
                                                    class="controller btn-icon size-[60px] b-solid btn-secondary-icon-solid !text-heading dark:text-white pulse-animation active:scale-105">
                                                    <i class="text-2xl ri-play-fill"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- PAGINATION -->
                            <div
                                class="online-video-slider-pagination swiper-custom-pagination absolute w-full z-10 !-bottom-12 hidden lg:flex">
                            </div>
                        </div>
                    </div>
                    <div class="self-end col-span-full lg:col-span-5">
                        <div class="py-12 text-center bg-white shadow-md px-7 rounded-xl">
                            <h5 class="area-title text-[24px] font-bold">
                                Join Now
                            </h5>
                            <form action="./database/user/signup.php" class="mt-6 form">
                                <input type="hidden" name="_token" value=""
                                    autocomplete="off"> <input type="hidden" name="user_type" value="instructor">
                                <div class="grid grid-cols-2 gap-x-3 gap-y-4">
                                    <div class="col-span-full lg:col-auto">
                                        <div class="relative">
                                            <input type="text" id="instructor-first-name" name="first_name"
                                                class="rounded-full form-input peer" placeholder="">
                                            <label for="instructor-first-name" class="form-label floating-form-label">
                                                First Name <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <span class="mt-1 text-danger error-text d-block first_name_err"></span>
                                    </div>
                                    <div class="col-span-full lg:col-auto">
                                        <div class="relative">
                                            <input type="text" id="instructor-last-name" name="last_name"
                                                class="rounded-full form-input peer" placeholder="">
                                            <label for="instructor-last-name" class="form-label floating-form-label">
                                                Last Name <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <span class="mt-1 text-danger error-text d-block last_name_err"></span>
                                    </div>
                                    <div class="col-span-full lg:col-auto">
                                        <div class="relative">
                                            <input type="email" id="instructor-email" name="email"
                                                class="rounded-full form-input peer" placeholder="">
                                            <label for="instructor-email" class="form-label floating-form-label">
                                                Email <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <span class="mt-1 text-danger error-text d-block email_err"></span>
                                    </div>

                                    <div class="col-span-full lg:col-auto">
                                        <div class="relative">
                                            <input type="password" id="password" name="password"
                                                class="rounded-full form-input peer" placeholder="">
                                            <label for="password" class="form-label floating-form-label">
                                                Password <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <span class="mt-1 text-danger error-text d-block password_err"></span>
                                    </div>

                                    <div class="col-span-full lg:col-auto">
                                        <div class="relative">
                                            <input type="date" id="date_of_birth" name="date_of_birth"
                                                class="rounded-full form-input peer" placeholder="">
                                            <label for="date_of_birth" class="form-label floating-form-label">
                                                Date_Of_Birth <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <span class="mt-1 text-danger error-text d-block phone_err"></span>
                                    </div>

                                    <!-- <div class="col-span-full lg:col-auto">
                                        <div class="relative">
                                            <input type="password" id="password-confirmation"
                                                name="password_confirmation" class="rounded-full form-input peer"
                                                placeholder="">
                                            <label for="password-confirmation" class="form-label floating-form-label">
                                                Confirm Password <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <span
                                            class="mt-1 text-danger error-text d-block password_confirmation_err"></span>
                                    </div> -->

                                    <div class="col-span-full">
                                        <div class="relative">
                                            <input type="file" id="file" name="image_path"
                                                class="rounded-full form-input peer" placeholder="">
                                            <label for="file" class="form-label floating-form-label">
                                                file <span class="text-danger"> *</span>
                                            </label>
                                        </div>
                                        <span class="mt-1 text-danger error-text d-block designation_err"></span>
                                    </div>
                                    <div class="col-span-full">
                                        <div class="relative">
                                            <textarea id="instructor-education" name="address" rows="5"
                                                class="form-input peer !rounded-2xl !h-auto" placeholder=""></textarea>
                                            <label for="instructor-education" class="form-label floating-form-label">
                                                Address </label>
                                        </div>
                                    </div>
                                    <div class="col-span-full">
                                        <button type="submit"
                                            class=" btn b-solid btn-secondary-solid !text-heading btn-xl !rounded-full font-bold w-full"
                                            aria-label="Join as Instructor">
                                            <!-- Join as Instructor
                                            <span class="hidden md:block">
                                                <i
                                                    class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                                            </span> -->
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- WAVE ANIMATION -->
            <div class="absolute bottom-0 left-0 right-0 w-full">
                <img data-src="https://edulab.hivetheme.com/lms/frontend/assets/images/online-video/wave-two.png"
                    class="w-full" alt="wave-two">
            </div>
        </div>
        <!-- END ONLINE VIDEO COURSE AREA -->

        <!-- START BLOG AREA -->
        <div class="bg-white pt-16 sm:pt-24 lg:pt-[120px]">
            <div class="container">
                <!-- HEADER -->
                <div class="grid items-center grid-cols-12 gap-4">
                    <div class="col-span-full md:col-span-7 xl:col-span-6 md:pr-20">
                        <div class="area-subtitle"> Frequent Updates </div>
                        <h2 class="mt-2 area-title">
                            Updated News &
                            <span class="title-highlight-one">Blogs</span>
                        </h2>
                    </div>

                    <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                        <a href="#" title="See All Blog"
                            class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium text-[16px] md:text-[18px]"
                            aria-label="#">
                            See all blog
                            <span class="hidden md:block">
                                <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <!-- BODY -->
                <div class="swiper blog-slider mt-10 lg:mt-[60px]">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide ">
                            <div class="h-full p-5 bg-primary-50 rounded-2xl group/blog">
                                <!-- BLOG THUMBNAIL -->
                                <div class="relative overflow-hidden aspect-video rounded-2xl">
                                    <div class="blog-thumb">
                                        <img data-src="https://edulab.hivetheme.com/storage/lms/blogs/lms-tpDeHhz3.webp"
                                            alt="Blog Thumbnail"
                                            class="object-cover size-full group-hover/blog:scale-110 custom-transition">
                                    </div>
                                    <!-- badge -->
                                    <span
                                        class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 right-4 z-10">Programming
                                        Languages</span>
                                </div>
                                <!-- BLOG CONTENT -->
                                <div class="mt-6">
                                    <div class="pb-4 mb-6 border-b flex-center-between border-heading/10">
                                        <div
                                            class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                            <i class="ri-user-line"></i>
                                            <span>Academine</span>
                                        </div>
                                        <div
                                            class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                            <i class="ri-calendar-2-line"></i>
                                            <span>05 Dec 2024</span>
                                        </div>
                                    </div>
                                    <h6
                                        class="area-title font-bold !text-xl mt-3 group-hover/blog:text-primary custom-transition">
                                        <!-- title -->
                                        <a href="#"
                                            class="line-clamp-2" aria-label="Blog title">
                                            The Importance of Programming in Our Everyday Lives
                                        </a>
                                    </h6>
                                    <a href="#"
                                        class="mt-6 font-medium btn btn-sm text-heading dark:text-white group-hover/blog:text-primary custom-transition"
                                        aria-label="View blog details">
                                        View Detail
                                        <span class="hidden md:block">
                                            <i
                                                class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide ">
                            <div class="h-full p-5 bg-primary-50 rounded-2xl group/blog">
                                <!-- BLOG THUMBNAIL -->
                                <div class="relative overflow-hidden aspect-video rounded-2xl">
                                    <div class="blog-thumb">
                                        <img data-src="https://edulab.hivetheme.com/storage/lms/blogs/lms-z5qgOccq.webp"
                                            alt="Blog Thumbnail"
                                            class="object-cover size-full group-hover/blog:scale-110 custom-transition">
                                    </div>
                                    <!-- badge -->
                                    <span
                                        class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 right-4 z-10">Digital
                                        Marketing</span>
                                </div>
                                <!-- BLOG CONTENT -->
                                <div class="mt-6">
                                    <div class="pb-4 mb-6 border-b flex-center-between border-heading/10">
                                        <div
                                            class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                            <i class="ri-user-line"></i>
                                            <span>Academine</span>
                                        </div>
                                        <div
                                            class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                            <i class="ri-calendar-2-line"></i>
                                            <span>04 Dec 2024</span>
                                        </div>
                                    </div>
                                    <h6
                                        class="area-title font-bold !text-xl mt-3 group-hover/blog:text-primary custom-transition">
                                        <!-- title -->
                                        <a href="#"
                                            class="line-clamp-2" aria-label="Blog title">
                                            How Kindergarten Shapes Future Achievements
                                        </a>
                                    </h6>
                                    <a href="#"
                                        class="mt-6 font-medium btn btn-sm text-heading dark:text-white group-hover/blog:text-primary custom-transition"
                                        aria-label="View blog details">
                                        View Detail
                                        <span class="hidden md:block">
                                            <i
                                                class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide ">
                            <div class="h-full p-5 bg-primary-50 rounded-2xl group/blog">
                                <!-- BLOG THUMBNAIL -->
                                <div class="relative overflow-hidden aspect-video rounded-2xl">
                                    <div class="blog-thumb">
                                        <img data-src="https://edulab.hivetheme.com/storage/lms/blogs/lms-67igPh1X.webp"
                                            alt="Blog Thumbnail"
                                            class="object-cover size-full group-hover/blog:scale-110 custom-transition">
                                    </div>
                                    <!-- badge -->
                                    <span
                                        class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 right-4 z-10">Personal
                                        Development</span>
                                </div>
                                <!-- BLOG CONTENT -->
                                <div class="mt-6">
                                    <div class="pb-4 mb-6 border-b flex-center-between border-heading/10">
                                        <div
                                            class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                            <i class="ri-user-line"></i>
                                            <span>Academine</span>
                                        </div>
                                        <div
                                            class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                            <i class="ri-calendar-2-line"></i>
                                            <span>27 Nov 2024</span>
                                        </div>
                                    </div>
                                    <h6
                                        class="area-title font-bold !text-xl mt-3 group-hover/blog:text-primary custom-transition">
                                        <!-- title -->
                                        <a href="#"
                                            class="line-clamp-2" aria-label="Blog title">
                                            How to Choose the Right Course for Your Goals
                                        </a>
                                    </h6>
                                    <a href="#"
                                        class="mt-6 font-medium btn btn-sm text-heading dark:text-white group-hover/blog:text-primary custom-transition"
                                        aria-label="View blog details">
                                        View Detail
                                        <span class="hidden md:block">
                                            <i
                                                class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div>
        <?php require_once("./footer.php") ?>

    </div>

    <script src="js/jquery-3.7.1.min.js"></script>
    <!-- VENDOR JS -->
    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/toastr.min.js"></script>
    <!-- THEME JS -->

    <script src="js/slider.min.js"></script>
    <script src="js/tab.min.js"></script>
    <script>
        let baseUrl = "https://edulab.hivetheme.com"
        const discountText = "Discount";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


    <script src="js/main.min.js"></script>
    <script src="js/custom.min.js"></script>

    <p class="d-none cookie"></p>



</body>

</html>