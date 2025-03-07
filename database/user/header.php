<?php

$previousEmail = $_SESSION['user']['email'] ?? null;
$stmt = $conn->query("SELECT * FROM users WHERE email='$previousEmail'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);

$courseStmt = $conn->query('SELECT * from courses');
$allCourses = $courseStmt->fetchAll(PDO::FETCH_ASSOC);

$courseStmt = $conn->query(
  "SELECT courses.*, categories.name as category_name,  COUNT(topics.id) as topic_count
        FROM courses
        JOIN categories ON courses.category_id = categories.id
        LEFT JOIN topics ON courses.id = topics.course_id
        GROUP BY courses.id "
);

$courses = $courseStmt->fetchAll(PDO::FETCH_ASSOC);
$url = basename($_SERVER['REQUEST_URI']);

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
  <link rel="stylesheet" href="../../css/toastr.min.css">
  <link rel="stylesheet" href="../../css/swiper-bundle.min.css">
  <script src="../../js/lozad.min.js"></script>
  <link rel="stylesheet" href="../../css/output.min.css">
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
  <script src="../../js/flasher.min.js" type="text/javascript" nonce=""></script>
  <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>


  <div class="hidden py-1 bg-primary md:block">
    <div class="container">
      <div class="flex items-center justify-start">
        <div class="flex items-center gap-5">
          <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="12" viewBox="0 0 17 12" fill="none">
              <path
                d="M2.5 0H14.5C15.325 0 16 0.675 16 1.5V10.5C16 11.325 15.325 12 14.5 12H2.5C1.675 12 1 11.325 1 10.5V1.5C1 0.675 1.675 0 2.5 0Z"
                fill="white"></path>
              <path d="M15.5713 1.71411L8.49989 6.74983L1.42847 1.71411" stroke="#5F3EED"
                stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round"></path>
            </svg>
            <a href="mailto:asgharburdi786gmail@gmail.com" aria-label="Contact mail"
              class="text-sm !leading-none font-semibold text-white/80 hover:text-white custom-transition">
              asgharburdi786@gmail.com
            </a>
          </div>
          <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"
              class="rtl:rotate-[270deg]">
              <path
                d="M13.9718 10.4817V12.5893C13.9726 12.7849 13.9325 12.9786 13.8542 13.1578C13.7758 13.3371 13.6608 13.498 13.5167 13.6303C13.3725 13.7626 13.2023 13.8633 13.0169 13.9259C12.8316 13.9886 12.6352 14.0119 12.4403 13.9943C10.2786 13.7594 8.20202 13.0207 6.37757 11.8376C4.68016 10.7589 3.24105 9.31984 2.16244 7.62243C0.975167 5.78969 0.2363 3.70306 0.00570216 1.53156C-0.0118535 1.33729 0.0112345 1.1415 0.0734958 0.956639C0.135757 0.77178 0.235828 0.601911 0.367336 0.457846C0.498845 0.313781 0.65891 0.198678 0.837341 0.119863C1.01577 0.0410494 1.20866 0.000251806 1.40372 6.81111e-05H3.51128C3.85222 -0.00328744 4.18275 0.117444 4.44126 0.33976C4.69976 0.562076 4.86861 0.870806 4.91633 1.20841C5.00528 1.88287 5.17025 2.54511 5.40809 3.18249C5.50261 3.43394 5.52307 3.70721 5.46704 3.96993C5.41101 4.23265 5.28084 4.4738 5.09196 4.66481L4.19976 5.55701C5.19983 7.31581 6.65609 8.77206 8.41489 9.77214L9.30709 8.87994C9.4981 8.69106 9.73925 8.56089 10.002 8.50486C10.2647 8.44883 10.538 8.46929 10.7894 8.56381C11.4268 8.80164 12.089 8.96662 12.7635 9.05557C13.1048 9.10371 13.4164 9.2756 13.6392 9.53855C13.862 9.8015 13.9804 10.1372 13.9718 10.4817Z"
                fill="white"></path>
            </svg>
            <a href="tel:03192508544" aria-label="Contact phone"
              class="text-sm !leading-none font-semibold text-white/80 hover:text-white custom-transition">
              Call:
              03192508544
            </a>
          </div>
        </div>
        <div class="flex items-center justify-end [&>:not(:first-child)]:pl-5 grow">
          <form method="get" action="https://edulab.hivetheme.com/language" id="language-form">
            <input type="hidden" name="_token" value="YUCtNVCcqCgR5CLiVKgCJZbPniH2JTCRYZWfRuLz"
              autocomplete="off"> <input type="hidden" name="admin_id" value="">
            <input type="hidden" name="user_id" value="">
            <select name="locale" aria-label="Choose Language" onchange="event.preventDefault();
                            document.getElementById('language-form').submit();"
              class="text-white *:text-heading dark:text-white font-semibold bg-transparent focus:outline-none cursor-pointer select-none text-sm p-1">
              <option value="en" selected="">
                English
              </option>
              <option value="ur">
                Urdu
              </option>
              <option value="es">
                Spanish
              </option>
              <option value="bn">
                Bengali
              </option>
              <option value="INA">
                indonesia
              </option>
              <option value="ro">
                Romana
              </option>
            </select>
          </form>
        </div>
      </div>
    </div>
  </div>

  <header class="w-full bg-white sticky-header">
    <div class="container">
      <div class="flex items-center justify-between">
        <!-- LOGO -->
        <a href="../../index.php" class="flex items-center w-16 lg:mr-32">
          <img src="../../uploads/3.png" alt="Aliedu Logo" class="">
          <span class="pt-1 text-2xl font-extrabold tracking-tight text-gray-700"
            style="font-family: 'Montserrat', sans-serif;">
            Aliedu
          </span>

        </a>


        <nav class="items-center justify-end hidden text-gray-600 lg:flex ms-20">
          <ul class="flex items-center gap-5 font-bold leading-none text-heading">

            <li class="flex-center">
              <a href="../../index.php" aria-label="Nav menu link"
                class="custom-transition !inline-block px-2 py-3 hover:text-primary 
                   <?= ($url == 'index.php') ? 'text-primary' : ''; ?>">
                Home
              </a>
            </li>

            <li class="relative flex-center group/has-menu">
              <a href="../../index.php" aria-label="Nav menu link"
                class="inline-block px-2 py-3 hover:text-primary 
               <?= ($url == 'index.php') ? 'text-primary' : ''; ?>">
                Courses
              </a>
              <ul
                class="absolute left-0 z-20 flex flex-col invisible px-2 py-3 -translate-x-5 bg-white rounded-lg shadow-md opacity-0 w-max top-full rtl:right-0 group-hover/has-menu:visible group-hover/has-menu:opacity-100 group-hover/has-menu:translate-x-0 custom-transition">
                <?php foreach ($allCourses as $course) { ?>
                  <li>
                    <a href="../../user/topics.php?id=<?php echo $course['id'] ?? null; ?>"
                      aria-label="Nav menu link"
                      class="text-xs relative inline-block px-2 py-2 hover:text-primary w-full 
              <?= ($url == './user/topics.php?id=' . ($course['id'] ?? '')) ? 'text-primary' : ''; ?>">
                      <?= $course['title'] ?? null; ?>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </li>

            <li class="flex-center">
              <a href="../../about.php" aria-label="Nav menu link"
                class="inline-block px-2 py-3 hover:text-primary 
                    <?= ($url == 'about.php') ? 'text-primary' : ''; ?>">
                About
              </a>
            </li>

            <li class="flex-center">
              <a href="../../contact.php" aria-label="Nav menu link"
                class="inline-block px-2 py-3 hover:text-primary 
                   <?= ($url == 'contact.php') ? 'text-primary' : ''; ?>">
                Contact
              </a>
            </li>
          </ul>
        </nav>
        <!-- ACTIONS -->
        <div class="flex items-center xs:gap-5 md:gap-7 ms-auto">
          <!-- SEARCH -->
          <form action="#" class="hidden lg:block shrink-0" method="GET">
            <input type="search" class="py-2 rounded-full form-input" name="q" placeholder="Search...">
          </form>
          <!-- WISH LIST -->
          <!-- CART LIST -->
          <a href="#" aria-label="Cart icon" class="relative hidden px-2 py-3 md:flex text-heading shrink-0">
            <img data-src="https://edulab.hivetheme.com/lms/frontend/assets/images/icons/cart.svg" alt="Icon" src="https://edulab.hivetheme.com/lms/frontend/assets/images/icons/cart.svg" data-loaded="true">
            <span class="absolute top-0 text-xs text-white border-2 border-white flex-center size-6 rounded-50 bg-primary -right-1 rtl:right-auto rtl:-left-1 total-qty">0</span>
          </a>



          <!-- ACTION LINK -->
          <?php if ($previousEmail === null) { ?>
            <div class="flex items-center gap-4 shrink-0">
              <a href="./login.php" aria-label="Log in"
                class="mr-1 font-bold flex btn b-outline btn-secondary-outline !rounded-full   py-2 px-3 text-sm">
                <span class="hidden md:block"><i class="ri-user-3-line"></i></span>
                Log in
              </a>
              <a href="./signup.php" aria-label="Registration"
                class="text-white font-bold hidden md:flex btn b-solid btn-secondary-solid !rounded-full !text-heading  py-2 px-3 text-sm">
                Sign up
                <span class="hidden md:block">
                  <i class="ri-arrow-right-up-line"></i>
                </span>
              </a>
            </div>
          <?php } else { ?>
            <a href="./logout.php" aria-label="Registration"
              class="hidden md:flex bg-red-500 text-sm py-2 px-3 text-white !rounded-full  font-semibold">
              Logout
              <span class="hidden md:block">
                <i class="ri-arrow-right-up-line"></i>
              </span>
            </a>
          <?php } ?>
          <!-- MENU BUTTON -->
          <div class="flex-center lg:hidden shrink-0">
            <button type="button" aria-label="Offcanvas menu" data-offcanvas-id="offcanvas-menu"
              class="btn-icon b-solid btn-secondary-icon-solid !text-heading dark:text-white font-bold">
              <i class="ri-menu-unfold-line rtl:before:content-['\ef3d']"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div id="offcanvas-menu" class="bg-black/50 fixed size-full inset-0 invisible opacity-0 duration-300 z-[102]">
    <div
      class="offcanvas-menu-inner absolute top-0 bottom-0 right-0 rtl:right-auto rtl:left-0 flex flex-col py-4 bg-white w-64 sm:w-72 translate-x-full rtl:-translate-x-full duration-300 z-[103]">
      <!-- CLOSE MENU -->
      <button type="button"
        class="absolute bg-white border border-transparent offcanvas-menu-close size-11 flex-center hover:border-primary top-4 right-full rtl:right-auto rtl:left-full custom-transition">
        <i class="text-gray-500 ri-close-line dark:text-dark-text"></i>
      </button>
      <!-- header search -->
      <div class="px-4 pr-6 xl:pr-4">
        <form class="hidden xl:block shrink-0" method="GET">
          <input type="search" class="rounded-full form-input" name="q" placeholder="Search...">
        </form>
      </div>
      <div class="px-4 my-5 overflow-x-hidden grow">
        <ul class="font-medium leading-none text-heading dark:text-white">
          <li>
            <a href="../../index.php" aria-label="Menu link"
              class="inline-block w-full py-3 hover:text-primary [&.active]:text-primary custom-transition active">
              Home
            </a>
          </li>
          <li>
            <a href="../../user/courses.php" aria-label="Menu link"
              class="inline-block w-full py-3 hover:text-primary [&.active]:text-primary custom-transition">
              Course
            </a>
          </li>
          <li>
            <a href="#"
              class="inline-block w-full py-3 hover:text-primary [&.active]:text-primary custom-transition">
              Pages
            </a>
            <ul class="flex flex-col">
              <li>
                <a href="#" aria-label="Menu link"
                  class="sub-menu-link">
                  Course Bundle
                </a>
              </li>
              <li>
                <a href="#" aria-label="Menu link"
                  class="sub-menu-link">
                  Instructor
                </a>
              </li>
              <li>
                <a href="https://asghar-dev.godaddysites.com/about" aria-label="Menu link"
                  class="sub-menu-link">
                  Organization
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a href="../../user/topics.php?id=2" aria-label="Menu link"
              class="inline-block w-full py-3 hover:text-primary [&.active]:text-primary custom-transition">
              Blogs
            </a>
          </li>
          <li>
            <a href="#" aria-label="Menu link"
              class="inline-block w-full py-3 hover:text-primary [&.active]:text-primary custom-transition">
              Contact
            </a>
          </li>
        </ul>
      </div>

    </div>
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