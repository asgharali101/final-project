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

    <div class="sm:px-2 lg:px-20">
        <div class="flex-center-between lg:pt-20 ">
            <h3 class="text-2xl border-b-2 border-b-indigo-600 area-title">All Users

                <!-- <span id="total-item">13</span> Results -->
            </h3>
            <div class="gap-2 flex-center">
                <button type="button" aria-label="Off-canvas filter drawer" data-offcanvas-id="filter-drawer" class="btn b-outline btn-secondary-outline lg:hidden">
                    <i class="ri-equalizer-line"></i>
                    Filter
                </button>
            </div>
        </div>
        <div id="outputItemList">
            <div class="container grid grid-cols-4 mx-auto mt-10 gap-x-4 xl:gap-x-7 gap-y-7 ">
                <div class="swiper-slide">
                    <div class="flex flex-col group/instructor">
                        <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                            <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-NQTisjM3.webp" alt="Thumbnail image" class="object-cover size-full group-hover/instructor:scale-110 custom-transition" src="https://edulab.hivetheme.com/storage/lms/instructors/lms-NQTisjM3.webp" data-loaded="true">
                        </div>
                        <div class="flex justify-between mt-6">
                            <div class="shrink-0 grow">
                                <h6 class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                    <a href="https://edulab.hivetheme.com/users/4/profile" class="flex items-center justify-between" aria-label="Instructor full name">
                                        John Smith
                                        <i class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                    </a>
                                </h6>
                                <p class="area-description !leading-none mt-1.5">
                                    Senior Web Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex flex-col group/instructor">
                        <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                            <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-txQEJxay.webp" alt="Thumbnail image" class="object-cover size-full group-hover/instructor:scale-110 custom-transition" src="https://edulab.hivetheme.com/storage/lms/instructors/lms-txQEJxay.webp" data-loaded="true">
                        </div>
                        <div class="flex justify-between mt-6">
                            <div class="shrink-0 grow">
                                <h6 class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                    <a href="https://edulab.hivetheme.com/users/6/profile" class="flex items-center justify-between" aria-label="Instructor full name">
                                        Sarah Johnson
                                        <i class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                    </a>
                                </h6>
                                <p class="area-description !leading-none mt-1.5">
                                    UX/UI Designer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex flex-col group/instructor">
                        <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                            <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-6Dv0EyvQ.webp" alt="Thumbnail image" class="object-cover size-full group-hover/instructor:scale-110 custom-transition" src="https://edulab.hivetheme.com/storage/lms/instructors/lms-6Dv0EyvQ.webp" data-loaded="true">
                        </div>
                        <div class="flex justify-between mt-6">
                            <div class="shrink-0 grow">
                                <h6 class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                    <a href="https://edulab.hivetheme.com/users/7/profile" class="flex items-center justify-between" aria-label="Instructor full name">
                                        John Abraham
                                        <i class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                    </a>
                                </h6>
                                <p class="area-description !leading-none mt-1.5">
                                    UX/UI Designer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex flex-col group/instructor">
                        <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                            <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-dq2Qr9k2.webp" alt="Thumbnail image" class="object-cover size-full group-hover/instructor:scale-110 custom-transition" src="https://edulab.hivetheme.com/storage/lms/instructors/lms-dq2Qr9k2.webp" data-loaded="true">
                        </div>
                        <div class="flex justify-between mt-6">
                            <div class="shrink-0 grow">
                                <h6 class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                    <a href="https://edulab.hivetheme.com/users/8/profile" class="flex items-center justify-between" aria-label="Instructor full name">
                                        Emma Brown
                                        <i class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                    </a>
                                </h6>
                                <p class="area-description !leading-none mt-1.5">
                                    Data Scientist</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex flex-col group/instructor">
                        <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                            <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-prnZ4ooz.webp" alt="Thumbnail image" class="object-cover size-full group-hover/instructor:scale-110 custom-transition" src="https://edulab.hivetheme.com/storage/lms/instructors/lms-prnZ4ooz.webp" data-loaded="true">
                        </div>
                        <div class="flex justify-between mt-6">
                            <div class="shrink-0 grow">
                                <h6 class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                    <a href="https://edulab.hivetheme.com/users/9/profile" class="flex items-center justify-between" aria-label="Instructor full name">
                                        Ahmed Hassan
                                        <i class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                    </a>
                                </h6>
                                <p class="area-description !leading-none mt-1.5">
                                    Mobile App Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex flex-col group/instructor">
                        <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                            <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-XjMjZbvH.webp" alt="Thumbnail image" class="object-cover size-full group-hover/instructor:scale-110 custom-transition" src="https://edulab.hivetheme.com/storage/lms/instructors/lms-XjMjZbvH.webp" data-loaded="true">
                        </div>
                        <div class="flex justify-between mt-6">
                            <div class="shrink-0 grow">
                                <h6 class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                    <a href="https://edulab.hivetheme.com/users/10/profile" class="flex items-center justify-between" aria-label="Instructor full name">
                                        Olivia Martinez
                                        <i class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                    </a>
                                </h6>
                                <p class="area-description !leading-none mt-1.5">
                                    Graphic Designer</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex flex-col group/instructor">
                        <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                            <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-ItaQqrmm.webp" alt="Thumbnail image" class="object-cover size-full group-hover/instructor:scale-110 custom-transition" src="https://edulab.hivetheme.com/storage/lms/instructors/lms-ItaQqrmm.webp" data-loaded="true">
                        </div>
                        <div class="flex justify-between mt-6">
                            <div class="shrink-0 grow">
                                <h6 class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                    <a href="https://edulab.hivetheme.com/users/11/profile" class="flex items-center justify-between" aria-label="Instructor full name">
                                        Chen Wei
                                        <i class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                    </a>
                                </h6>
                                <p class="area-description !leading-none mt-1.5">
                                    Cybersecurity Expert</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex flex-col group/instructor">
                        <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                            <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-YWjtcEFx.webp" alt="Thumbnail image" class="object-cover size-full group-hover/instructor:scale-110 custom-transition" src="https://edulab.hivetheme.com/storage/lms/instructors/lms-YWjtcEFx.webp" data-loaded="true">
                        </div>
                        <div class="flex justify-between mt-6">
                            <div class="shrink-0 grow">
                                <h6 class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                    <a href="https://edulab.hivetheme.com/users/12/profile" class="flex items-center justify-between" aria-label="Instructor full name">
                                        Smith Nguyen
                                        <i class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                    </a>
                                </h6>
                                <p class="area-description !leading-none mt-1.5">
                                    Digital Marketing Specialist</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex flex-col group/instructor">
                        <div class="aspect-[1/1.26] overflow-hidden rounded-xl relative">
                            <img data-src="https://edulab.hivetheme.com/storage/lms/instructors/lms-ObZnCY4y.webp" alt="Thumbnail image" class="object-cover size-full group-hover/instructor:scale-110 custom-transition" src="https://edulab.hivetheme.com/storage/lms/instructors/lms-ObZnCY4y.webp" data-loaded="true">
                        </div>
                        <div class="flex justify-between mt-6">
                            <div class="shrink-0 grow">
                                <h6 class="area-title text-xl !leading-none font-bold group-hover/instructor:text-primary custom-transition">
                                    <a href="https://edulab.hivetheme.com/users/27/profile" class="flex items-center justify-between" aria-label="Instructor full name">
                                        Robert Bloom
                                        <i class="ri-arrow-right-line text-[20px] rtl:before:content-['\ea60']"></i>
                                    </a>
                                </h6>
                                <p class="area-description !leading-none mt-1.5">
                                    Senior JavaScript Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- PAGINATION -->
            <!-- PAGINATION -->
            <div class="flex-center mt-10 lg:mt-[60px]">
                <ul class="flex items-center gap-x-2.5">
                    <button type="button" aria-label="Pagination link" class="pagination active" fdprocessedid="nqgoi">1</button>
                    <a class="pagination" aria-label="Pagination link" href="">2</a>
                    <a class="pagination" href="" aria-label="Pagination link">
                        <i class="ri-arrow-right-line rtl:before:content-['\ea60']"></i>
                    </a>
                </ul>
            </div>

        </div>
    </div>

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