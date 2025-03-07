<?php
require_once './connection.php';
session_start();



$priviousEmail = $_SESSION['user']['email'] ?? null;


?>

<!DOCTYPE html>
<html lang="en" class="group" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Edulab LMS</title>
    <meta name="description" content="web development agency">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="YUCtNVCcqCgR5CLiVKgCJZbPniH2JTCRYZWfRuLz">
    <link rel="shortcut icon" type="image/x-icon" href="uploads/3.png">
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap">
    <link rel="stylesheet" href="css/toastr.min.css">
    <link rel="stylesheet" href="css/swiper-bundle.min.css">
    <script src="js/lozad.min.js"></script>
    <link rel="stylesheet" href="css/output.min.css">

    <script src="js/flasher.min.js" type="text/javascript" nonce=""></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <div>
        <?php require_once("./header.php"); ?>

    </div>

    <main>
        <!-- START INNER HERO AREA -->
        <div class="bg-transparent relative overflow-hidden mb-16 sm:mb-24 lg:mb-[120px]">
            <div class="container py-[70px] relative">
                <h1 class="text-center area-title xl:text-5xl lg:text-left rtl:lg:text-right">About Us</h1>
                <!-- BREADCRUMB -->
                <ul class="flex items-center bg-white px-4 py-3 lg:px-6 lg:py-3.5 mx-0 lg:mx-3 gap-1.5 *:flex-center *:gap-1.5 leading-none absolute bottom-0 left-1/2 -translate-x-1/2 lg:left-auto rtl:lg:left-0 lg:right-0 rtl:lg:right-auto lg:translate-x-0 rounded-t-2xl w-max">
                    <li class="text-heading/70 font-semibold after:font-remix after:flex-center after:font-thin after:text-heading/70 after:size-5 after:content-['\f3c1'] after:text-[6px] after:translate-y-[1.4px] last:after:hidden">
                        <a href="./index.php" aria-label="Go to homepage" class="gap-2 flex-center shrink-0 text-inherit">
                            <i class="ri-home-7-fill"></i>
                            Home
                        </a>
                    </li>
                    <li class="text-primary font-semibold after:font-remix after:flex-center after:font-thin after:text-heading/70 after:size-5 after:content-['\f3c1'] after:text-[6px] after:translate-y-[1.4px] last:after:hidden">
                        About Us
                    </li>
                </ul>
            </div>
            <!-- POSITIONAL ELEMENTS -->
            <ul>
                <!-- LEFT -->
                <li class="block size-[550px] w-[33.33vw] rounded-50 bg-[#1AEBC5]/15 blur-[200px] absolute top-1/2 -translate-y-1/2 -left-[10%] rtl:left-auto rtl:-right-[10%] -z-10"></li>
                <!-- CENTER -->
                <li class="block size-[550px] w-[33.33vw] rounded-50 bg-[#F98272]/15 blur-[200px] absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 -z-10"></li>
                <!-- RIGHT -->
                <li class="block size-[550px] w-[33.33vw] rounded-50 bg-[#5F3EED]/20 blur-[200px] absolute top-1/2 -translate-y-1/2 -right-[10%] rtl:right-auto rtl:-left-[10%] -z-10"></li>
            </ul>
        </div>
        <!-- Blog -->

        <div class="container">
            <div class="grid items-center grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7">
                <div class="col-span-full lg:col-span-6">
                    <img data-src="https://edulab.hivetheme.com/storage/lms/theme-options/lms-fBIzj8HMy4.webp" alt="About Us" src="https://edulab.hivetheme.com/storage/lms/theme-options/lms-fBIzj8HMy4.webp" data-loaded="true">
                </div>
                <div class="col-span-full lg:col-span-6">
                    <div class="lg:pl-[10%] rtl:lg:pl-0 rtl:lg:pr-[10%]">
                        <div class="text-4xl outline-text-one lg:text-7xl">About Us</div>
                        <h2 class="mt-1 area-title">Connect with Experts and Learn from Anywhere</h2>
                        <div class="area-description mt-2.5 line-clamp-6">
                            We believe that the foundation of a child’s education should be built on creativity, curiosity, and joy. Our mission is to make learning accessible, exciting, and tailored to every child’s unique pace and style.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div>
        <?php require_once("./footer.php") ?>

    </div>
</body>

</html>