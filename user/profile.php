<?php
require_once '../connection.php';
session_start();
require_once "../database/user/edit.php";


$email = $_SESSION['user']['email'] ?? null;


if ($email === null) {
  header('location:../../index.html');
  exit;
}
$error = '';
$success = '';
$rolestmt = $conn->query('SELECT * from roles');
$roles = $rolestmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query("SELECT users.*,roles.role AS role_name FROM users LEFT JOIN roles ON users.role_id=roles.id  WHERE users.email='$email'");
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $currentPassword = $_POST['current-password'] ?? 123;
  $newPassword = $_POST['new-password'] ?? null;
  $confirmPassword = $_POST['confirm-password'] ?? null;

  if (password_verify($currentPassword, $currentUser['password'])) {
    if ($newPassword == $confirmPassword) {
      $hashPassword = password_hash($newPassword, PASSWORD_DEFAULT) ?? null;
      $addData = $conn->exec("UPDATE users SET password='$hashPassword'  where email='$email'");
      if ($addData) {
        $success = 'password change successfully';
      } else {
        $error = 'No changes made to the password';
      }
    } else {
      $error = 'new password not matching with confirm password';
    }
  } else {
    $error = 'current password is not matching';
  }
}

?>

<!DOCTYPE html>
<html lang="en" class="">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profile </title>

  <!-- Tailwind is included -->
  <link rel="stylesheet" href="css/main.css?v=1628755089081" />
  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png" />
  <link rel="icon" type="" sizes="32x32" href="favicon-32x32.png" />
  <link rel="icon" type="" sizes="16x16" href="favicon-16x16.png" />
  <link rel="mask-icon" href="safari-pinned-tab.svg" color="#00b4b6" />

  <meta name="description" content="Admin One - free Tailwind dashboard" />

  <meta
    property="og:url"
    content="https://github.com/asgharali101/" />
  <meta property="og:site_name" content="JustBoil.me" />
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
    <?php require_once '../particions/nav.php'; ?>
    <?php require_once '../particions/sidebar.php'; ?>

    <section class="is-title-bar">
      <div
        class="flex flex-col items-center justify-between space-y-6 md:flex-row md:space-y-0">
        <ul>
          <li><?php
              echo $currentPassword['role_name'] ?? '';
              ?></li>
          <li>Profile</li>
        </ul>
        <a
          href="https://asghar-dev.godaddysites.com/"
          onclick="alert('Coming soon'); return false"
          target="_blank"
          class="button blue">
          <span class="icon"><i class="mdi mdi-credit-card-outline"></i></span>
          <span>Premium Demo</span>
        </a>
      </div>
    </section>

    <section class="is-hero-bar">
      <div
        class="flex flex-col items-center justify-between space-y-6 md:flex-row md:space-y-0">
        <h1 class="title">Profile</h1>
        <button class="button light">Button</button>
      </div>
    </section>

    <section class="section main-section">
      <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-2">

        <div class="card">
          <header class="card-header">
            <p class="card-header-title">
              <span class="icon"><i class="mdi mdi-account-circle"></i></span>
              Edit Profile
            </p>
          </header>
          <div class="card-content">
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="field">
                <div class="mx-auto w-[1rem] h-04">

                </div>
                <label class="label">Avatar</label>
                <div class="">
                  <div class="">
                    <label class="">
                      <input type="file" name="newImage" />
                      <p class="text-red-500"><?php echo $errors["newImage"] ?? null ?></p>

                    </label>
                  </div>
                </div>
              </div>
              <hr />
              <div class="flex justify-between">
                <div class="field">
                  <label class="label">First Name</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        <input
                          type="text"
                          autocomplete="on"
                          name="first_name"
                          value="<?= $currentUser['first_name'] ?? null ?>"
                          class="input"
                          required />
                        <p class="text-red-500" id="message"><?php echo $errors["first_name"] ?? null ?></p>
                      </div>
                      <p class="help">Required. Your first name</p>
                    </div>
                  </div>
                </div>

                <div class="field">
                  <label class="label">Last Name</label>
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        <input
                          type="text"
                          autocomplete="on"
                          name="last_name"
                          value="<?= $currentUser['last_name'] ?? null ?>"
                          class="input"
                          required />
                        <p class="text-red-500" id="message"><?php echo $errors["last_name"] ?? null ?></p>

                      </div>
                      <p class="help">Required. Your last name</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="field">
                <label class="label">E-mail</label>
                <div class="field-body">
                  <div class="field">
                    <div class="control">
                      <input
                        type="email"
                        autocomplete="on"
                        name="email"
                        value="<?= $currentUser['email'] ?? null ?>"
                        class="input"
                        required />
                      <p class="text-red-500" id="message"><?php echo $errors["email"] ?? null ?></p>

                    </div>
                    <p class="help">Required. Your e-mail</p>
                  </div>
                </div>
              </div>

              <div class="flex justify-between field">

                <div class="control">
                  <label class="label">Date Of Birth</label>
                  <input required
                    type="date"
                    name="date_of_birth"
                    value="<?php echo $currentUser['date_of_birth'] ?>"
                    class="input is-static" />
                  <p class="text-red-500" id="message"><?php echo $errors["date_of_birth"] ?? null ?></p>

                </div>
              </div>


              <div class="field">
                <label class="label">
                  <Address>Address</Address>
                </label>
                <div class="control">
                  <textarea required name="address" class="input is-static"><?= $currentUser['address'] ?? null ?></textarea>
                  <p class="text-red-500" id="message"><?php echo $errors["address"] ?? null ?></p>

                </div>
              </div>


              <hr />
              <div class="field">
                <div class="control">
                  <button type="submit" name="submit" class="button green">Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- profile -->
        <div class="card">
          <header class="card-header">
            <p class="card-header-title">
              <span class="icon"><i class="mdi mdi-account"></i></span>
              Profile
            </p>
          </header>

          <div class="card-content">
            <div class="w-48 h-48 mx-auto image">
              <img class="h-32 rounded-full w-36"
                src="<?php echo (!empty($currentUser['image_path'])
                        ? $currentUser['image_path']
                        : 'https://ui-avatars.com/api/?name=' . urlencode($currentUser['first_name'] ?? 'User')); ?>"
                alt="Avatar">
            </div>
            <hr />

            <div class="flex justify-between field">
              <div class="control">
                <label class="label">First Name</label>
                <input
                  type="text"
                  readonly
                  value="<?php echo $currentUser['first_name'] ?? null ?>"
                  class="input is-static" />
              </div>
              <div class="control">
                <label class="label">Last Name</label>

                <input
                  type="text"
                  readonly
                  value="<?php echo $currentUser['last_name'] ?? null ?>"
                  class="input is-static" />
              </div>
            </div>
            <hr />

            <div class="field">
              <label class="label">E-mail</label>
              <div class="control">
                <input
                  type="text"
                  readonly
                  value="<?= $currentUser['email'] ?? null ?>"
                  class="input is-static" />
              </div>
            </div>
            <div class="flex justify-between field">

              <div class="control">
                <label class="label">Date Of Birth</label>

                <input
                  type="text"
                  readonly
                  value="<?php echo $currentUser['date_of_birth'] ?? null ?>"
                  class="input is-static" />
              </div>
            </div>
            <div class="field">
              <label class="label">
                <Address></Address>
              </label>
              <div class="control">
                <textarea readonly class="input is-static"><?= $currentUser['address'] ?? null ?></textarea>

              </div>
            </div>
          </div>

        </div>
      </div>
      <?php if (isset($success)) { ?>
        <div id="message" class="p-2 font-sans text-lg text-center text-green-500"><?= $success; ?></div>
      <?php } ?>
      <?php if (isset($error)) { ?>
        <div id="message" class="p-2 font-sans text-lg text-center text-red-500"><?= $error; ?></div>
      <?php } ?>

      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-lock"></i></span>
            Change Password
          </p>
        </header>
        <div class="card-content">
          <form method="post">
            <div class="field">
              <label class="label">Current password</label>
              <div class="control">
                <input
                  type="password"
                  name="current-password"
                  autocomplete="current-password"
                  class="input"
                  required />
              </div>
              <p class="help">Required. Your current password</p>
            </div>
            <hr />
            <div class="field">
              <label class="label">New password</label>
              <div class="control">
                <input
                  type="password"
                  autocomplete=""
                  name="new-password"
                  class="input"
                  required />
              </div>
              <p class="help">Required. New password</p>
            </div>
            <div class="field">
              <label class="label">Confirm password</label>
              <div class="control">
                <input
                  type="password"
                  autocomplete="confirm-password"
                  name="confirm-password"
                  class="input"
                  required />
              </div>
              <p class="help">Required. New password one more time</p>
            </div>
            <hr />
            <div class="field">
              <div class="control">
                <button type="submit" class="button green">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>

    <?php require_once '../particions/footer.php'; ?>

    <div id="sample-modal" class="modal">
      <div class="modal-background --jb-modal-close"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Sample modal</p>
        </header>
        <section class="modal-card-body">
          <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
          <p>This is sample modal</p>
        </section>
        <footer class="modal-card-foot">
          <button class="button --jb-modal-close">Cancel</button>
          <button class="button red --jb-modal-close">Confirm</button>
        </footer>
      </div>
    </div>

    <div id="sample-modal-2" class="modal">
      <div class="modal-background --jb-modal-close"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Sample modal</p>
        </header>
        <section class="modal-card-body">
          <p>Lorem ipsum dolor sit amet <b>adipiscing elit</b></p>
          <p>This is sample modal</p>
        </section>
        <footer class="modal-card-foot">
          <button class="button --jb-modal-close">Cancel</button>
          <button class="button blue --jb-modal-close">Confirm</button>
        </footer>
      </div>
    </div>
  </div>

  <!-- Scripts below are for demo only -->
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