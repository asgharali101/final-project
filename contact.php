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

    <div class="pre-loader-wrapper">
        <div class="loader">
            <div class="orb"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
    </div>

    <div>
        <?php require_once("./header.php"); ?>

    </div>

    <main>
        <!-- START INNER HERO AREA -->
        <div class="bg-transparent relative overflow-hidden mb-16 sm:mb-24 lg:mb-[120px]">
            <div class="container py-[70px] relative">
                <h1 class="text-center area-title xl:text-5xl lg:text-left rtl:lg:text-right">Contact</h1>
                <!-- BREADCRUMB -->
                <ul class="flex items-center bg-white px-4 py-3 lg:px-6 lg:py-3.5 mx-0 lg:mx-3 gap-1.5 *:flex-center *:gap-1.5 leading-none absolute bottom-0 left-1/2 -translate-x-1/2 lg:left-auto rtl:lg:left-0 lg:right-0 rtl:lg:right-auto lg:translate-x-0 rounded-t-2xl w-max">
                    <li class="text-heading/70 font-semibold after:font-remix after:flex-center after:font-thin after:text-heading/70 after:size-5 after:content-['\f3c1'] after:text-[6px] after:translate-y-[1.4px] last:after:hidden">
                        <a href="./index.php" aria-label="Go to homepage" class="gap-2 flex-center shrink-0 text-inherit">
                            <i class="ri-home-7-fill"></i>
                            Home
                        </a>
                    </li>
                    <li class="text-primary font-semibold after:font-remix after:flex-center after:font-thin after:text-heading/70 after:size-5 after:content-['\f3c1'] after:text-[6px] after:translate-y-[1.4px] last:after:hidden">
                        Contact
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
        <!-- START CONTACT OVERVIEW -->
        <div class="container">
            <div class="grid grid-cols-12 gap-4 xl:gap-7">
                <!-- EMAIL -->
                <div class="duration-1000 border border-gray-100 cursor-pointer rounded-xl hover:border-indigo-700 hover:scale-105 col-span-full sm:col-span-6 lg:col-span-3">
                    <div class="flex-col h-full px-4 py-12 text-center bg-primary-50 rounded-xl flex-center">
                        <div class="p-2 text-white size-14 rounded-50 flex-center bg-primary">
                            <i class="text-2xl ri-mail-open-fill"></i>
                        </div>
                        <div class="area-title text-2xl !leading-none mt-5">
                            Email
                        </div>
                        <p class="mt-4 text-sm area-description"> asgharburdi786@gmail.com</p>
                    </div>
                </div>
                <!-- PHONE -->
                <div class="duration-1000 border border-gray-100 cursor-pointer rounded-xl hover:border-indigo-700 hover:scale-105 col-span-full sm:col-span-6 lg:col-span-3">
                    <div class="flex-col h-full px-4 py-12 text-center bg-primary-50 rounded-xl flex-center">
                        <div class="p-2 text-white size-14 rounded-50 flex-center bg-primary">
                            <i class="text-2xl ri-phone-fill"></i>
                        </div>
                        <div class="area-title text-2xl !leading-none mt-5">
                            Phone
                        </div>
                        <p class="mt-4 text-sm area-description">03192508544</p>

                    </div>
                </div>
                <!-- OFFICE HOUR -->
                <div class="duration-1000 border border-gray-100 cursor-pointer rounded-xl hover:border-indigo-700 hover:scale-105 col-span-full sm:col-span-6 lg:col-span-3">
                    <div class="flex-col h-full px-4 py-12 text-center bg-primary-50 rounded-xl flex-center">
                        <div class="p-2 text-white size-14 rounded-50 flex-center bg-primary">
                            <i class="text-2xl ri-home-office-fill"></i>
                        </div>
                        <div class="area-title text-2xl !leading-none mt-5">
                            Working Hour
                        </div>
                        <p class="mt-4 text-sm area-description"> 5AM-11PM </p>
                        <p class="mt-1 text-sm area-description"> Online 24/7
                        </p>
                    </div>
                </div>
                <!-- LOCATION -->
                <div class="duration-1000 border border-gray-100 cursor-pointer rounded-xl hover:border-indigo-700 hover:scale-105 col-span-full sm:col-span-6 lg:col-span-3">
                    <div class="flex-col h-full px-4 py-12 text-center bg-primary-50 rounded-xl flex-center">
                        <div class="p-2 text-white size-14 rounded-50 flex-center bg-primary">
                            <i class="text-2xl ri-map-pin-fill"></i>
                        </div>
                        <div class="area-title text-2xl !leading-none mt-5">
                            Location
                        </div>
                        <p class="mt-4 text-sm area-description">
                            Sehwan Sindh, Hyderabad,Pakistan </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTACT OVERVIEW -->
        <!-- START CONTACT FORM -->
        <div class="bg-primary-50 mt-16 sm:mt-24 lg:mt-[120px] -mb-16 sm:-mb-24 lg:-mb-[120px] relative overflow-hidden">
            <div class="container">
                <div class="grid grid-cols-2">
                    <div class="col-span-full lg:col-auto bg-primary-50 py-16 sm:py-24 lg:py-[120px]">
                        <h5 class="area-title">Free Consultation</h5>
                        <form action="./index.php/contact" class="mt-10 lg:max-w-screen-sm lg:pr-[10%] rtl:lg:pr-0 rtl:lg:pl-[10%] form" method="post">
                            <input type="hidden" name="_token" value="QJm6ZFJZQNtA7wnQhmF2B1Q6ia54YQdocSFFvzH2" autocomplete="off">
                            <div class="grid grid-cols-2 gap-x-3 gap-y-4">
                                <div class="col-span-full lg:col-auto">
                                    <div class="relative">
                                        <input type="text" id="user-first-name" name="name" class="form-input rounded-full peer  !bg-white " placeholder="">
                                        <label for="user-first-name" class="form-label floating-form-label">
                                            Full Name
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <span class="text-danger error-text name_err"></span>
                                </div>


                                <div class="col-span-full lg:col-auto">
                                    <div class="relative">
                                        <input type="email" id="user-email" name="email" class="form-input rounded-full peer !bg-white " placeholder="">
                                        <label for="user-email" class="form-label floating-form-label">
                                            Email
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <span class="text-danger error-text email_err"></span>
                                </div>
                                <div class="col-span-full lg:col-auto">
                                    <div class="relative">
                                        <input type="text" id="user-phone" name="phone" class="form-input rounded-full peer !bg-white " placeholder="">
                                        <label for="user-phone" class="form-label floating-form-label">
                                            Phone
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <span class="text-danger error-text phone_err"></span>
                                </div>
                                <div class="col-span-full lg:col-auto">
                                    <div class="relative">
                                        <input type="text" id="user-address" class="form-input rounded-full peer !bg-white " name="subject" placeholder="">
                                        <label for="user-address" class="form-label floating-form-label">
                                            Subject
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <span class="text-danger error-text subject_err"></span>
                                </div>
                                <div class="col-span-full">
                                    <div class="relative">
                                        <textarea id="user-education" rows="10" class="form-input rounded-2xl h-auto peer !bg-white" name="message" placeholder=""></textarea>
                                        <label for="user-education" class="form-label floating-form-label">
                                            Write your message
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <span class="text-danger error-text message_err"></span>
                                </div>
                                <div class="col-span-full">
                                    <button type="submit" class="btn b-solid btn-primary-solid btn-xl h-12 !rounded-full" aria-label="Send now">
                                        Send Now
                                        <span class="hidden md:block">
                                            <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-span-full lg:col-auto bg-primary-50 lg:absolute lg:w-1/2 lg:h-full lg:top-0 lg:bottom-0 lg:!right-0 rtl:lg:!right-auto rtl:lg:!left-0 hidden lg:block">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d3074160.585504608!2d72.1067713!3d41.1975765!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1731426205694!5m2!1sen!2sbd" width="100%" height="100%" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTACT FORM -->
    </main>
    <div>
        <?php require_once("./footer.php"); ?>
    </div>
    <script src="js/jquery-3.7.1.min.js"></script>
    <!-- VENDOR JS -->
    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/toastr.min.js"></script>
    <!-- THEME JS -->

    <script src="js/slider.min.js"></script>
    <script src="js/tab.min.js"></script>
    <script>
        let baseUrl = "./index.php"
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