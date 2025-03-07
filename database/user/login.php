<?php

require_once '../../connection.php';
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $login = $_POST['login'] ?? null;
  $password = $_POST['password'] ?? null;

  $stmt = $conn->query("SELECT * from users where email='$login'");
  $result = $stmt->fetch(PDO::FETCH_OBJ);

  if ($result && password_verify($password, $result->password)) {
    $_SESSION['user'] = [
      'first_name' => $result->first_name,
      'last_name' => $result->last_name,
      'email' => $result->email,
      'role_id' => $result->role_id,
    ];

    header('location:../../index.html');
  } else {
    $error = 'incorrect email or password';
  }
}

?>


<!DOCTYPE html>
<html lang="en" class="form-screen">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login </title>

  <!-- Tailwind is included -->
  <link rel="stylesheet" href="../../user/css/main.css?v=1628755089081" />

  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png" />
  <link rel="mask-icon" href="safari-pinned-tab.svg" color="#00b4b6" />
  <script src="https://cdn.tailwindcss.com"></script>

  <meta name="description" content="Admin One - free Tailwind dashboard" />


  <meta property="og:site_name" content="asgharali" />
  <meta property="og:title" content="Admin One HTML" />
  <meta
    property="og:description"
    content="Admin One - free Tailwind dashboard" />
  <meta
    property="og:image"
    content="https://justboil.me/uploads/one-tailwind/repository-preview-hi-res.png" />
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
    content="https://justboil.me/uploads/one-tailwind/repository-preview-hi-res.png" />
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
</head>

<body>

  <div id="app">

    <div>
      <?php require_once("./header.php"); ?>
    </div>
    <section class="section main-section">
      <div class="card">
        <p class="text-center text-red-500"><?php echo $error ?></p>

        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-lock"></i></span>
            Login
          </p>
        </header>

        <div class="card-content">
          <form method="post">
            <div class="field spaced">
              <label class="label">Login</label>
              <div class="control icons-left">
                <input
                  class="input"
                  type="text"
                  name="login"
                  placeholder="user@example.com"
                  autocomplete="username" />
                <span class="icon is-small left"><i class="mdi mdi-account"></i></span>
              </div>
              <p class="help">Please enter your login</p>
            </div>

            <div class="field spaced">
              <label class="label">Password</label>
              <p class="control icons-left">
                <input
                  class="input"
                  type="password"
                  name="password"
                  placeholder="Password"
                  autocomplete="current-password" />
                <span class="icon is-small left"><i class="mdi mdi-asterisk"></i></span>
              </p>
              <p class="help">Please enter your password</p>
            </div>

            <div class="flex items-center space-x-2 control">
              <span class="font-medium text-gray-700 ">
                Don’t have an account yet?
              </span>
              <a href="./signup.php"
                class="inline-block text-lg font-semibold text-blue-600 underline transition-colors duration-300 hover:text-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400">
                Sign up
              </a>
            </div>

            <p class="my-2 border-b"></p>

            <div class="field grouped">
              <div class="control">
                <button type="submit" class="button blue">Login</button>
              </div>
              <div class="control">
                <a href="index.php" class="button">Back</a>
              </div>
            </div>

          </form>
        </div>
      </div>
    </section>
    <div>
      <?php require_once("./footer.php"); ?>

    </div>
  </div>

  <!-- Scripts below are for demo only -->
  <script
    type="text/javascript"
    src="../../user/js/main.min.js?v=1628755089081"></script>
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