<?php
require_once("./connection.php");
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


    <div>
        <?php require_once("./header.php") ?>
    </div>

    <main class="flex items-center justify-center h-screen">
        <div class="text-center fade-in">
            <h2 class="mb-4 text-5xl font-bold text-red-500">Access Denied</h2>
            <p class="text-xl text-gray-300">You are not an authenticated user.</p>
            <p class="mt-2 text-lg text-gray-400">Please contact support if you believe this is an error.</p>

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