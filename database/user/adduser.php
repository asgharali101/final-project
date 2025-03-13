<?php

require_once '../../connection.php';
session_start();
$currentEmail = $_SESSION["user"]["email"] ?? null;

$errors = [];

$stmt = $conn->query("SELECT * from users where email='$currentEmail'");
$users = $stmt->fetch(PDO::FETCH_ASSOC);

$role_id = $users["role_id"];

if ($role_id != 1) {
  header("location:../../../../error.php");
}

$stmt = $conn->query('SELECT * from roles');
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $firstName = $_POST['first_name'] ?? null;
  $lastName = $_POST['last_name'] ?? null;
  $email = $_POST['email'] ?? null;
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT) ?? null;
  $date_of_birth = $_POST['date_of_birth'] ?? null;
  $address = $_POST['address'] ?? null;
  $role_id = $_POST["role_id"];
  $is_active = $_POST["is_active"];

  if (empty($_POST['first_name']) || strlen($_POST['first_name']) > 20) {
    $errors['first_name'] = 'First name is required and must be less than 20 characters.';
  }

  if (empty($_POST['last_name']) || strlen($_POST['last_name']) > 20) {
    $errors['last_name'] = 'Last name is required and must be less than 20 characters.';
  }

  if (empty($_POST['email']) || strlen($_POST['email']) > 40) {
    $errors['email'] = 'Email is required and must be less than 40 characters.';
  }

  if (empty($_POST['password']) || strlen($_POST['password']) > 30) {
    $errors['password'] = 'Password is required and must be less than 30 characters.';
  }

  if (empty($_POST['address']) || strlen($_POST['address']) > 500) {
    $errors['address'] = 'address is required and must be less than 500 characters.';
  }

  if (!DateTime::createFromFormat('Y-m-d', $date_of_birth)) {
    $errors['date_of_birth'] = ' invalid date_of_birth';
  }

  if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
    $errors['image'] = 'Image size must be 2MB or less.';
  }

  $filename = $_FILES['image']['name'];
  $fileType = pathinfo($filename, PATHINFO_EXTENSION);
  $allowedTypes = ['png', 'jpeg', 'jpg'];
  $filePath = null;


  if (! empty($filename)) {
    if (! in_array($fileType, $allowedTypes)) {
      $errors['image'] = 'Image extension type must be png, jpeg, jpg.';
    }
  }



  $stmt = $conn->query("SELECT count(*) as count from users where email='$email'");
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($result["count"] > 0) {
    $errors["email"] = 'Email already in use. Please choose another email.';
  } else {
    if (empty($errors)) {

      if (! empty($filename)) {
        $filePath = '../../uploads/' . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], $filePath);
      }

      $addData = $conn->exec("INSERT INTO users(role_id,first_name,last_name,email,password,date_of_birth,image_path,address,is_active) value($role_id,'$firstName','$lastName','$email','$password','$date_of_birth','$filePath','$address',0)");
      header('location:../../index.html');
      exit();
    }
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
      <?php require_once("nav.php"); ?>
      <?php require_once("./sidebar.php"); ?>

    </div>

    <section class="section main-section my-52">
      <div class="card">
        <header class="card-header">
          <p class="card-header-title">
            <span class="icon"><i class="mdi mdi-lock"></i></span>
            Sign up
          </p>
        </header>
        <div class="card-content">
          <form method="post" enctype="multipart/form-data">
            <div class="flex space-x-5">
              <div class="field spaced">
                <label class="label">Name</label>
                <div class="control icons-left">
                  <input
                    class="input"
                    type="text"
                    name="first_name"
                    value="<?php echo $_POST["first_name"] ?? null ?>"
                    placeholder="asghar"
                    autocomplete="username" required />
                  <span class="icon is-small left"><i class="mdi mdi-account"></i></span>

                </div>
                <p class="help">Please enter your Name</p>
                <p class="text-red-500" id="message"><?php echo $errors["first_name"] ?? null ?></p>
              </div>

              <div class="field spaced">
                <label class="label">last Name</label>
                <div class="control icons-left">
                  <input required
                    class="input"
                    type="text"
                    name="last_name"
                    value="<?php echo $_POST["last_name"] ?? null ?>"
                    placeholder="ali"
                    autocomplete="username" />
                  <span class="icon is-small left"><i class="mdi mdi-account"></i></span>
                </div>
                <p class="help">Please enter your last Name</p>
                <p class="text-red-500" id="message"><?php echo $errors["last_name"] ?? null ?></p>

              </div>
            </div>

            <div class="field spaced">
              <label class="label">email</label>
              <div class="control icons-left">
                <input required
                  class="input"
                  type="text"
                  name="email"
                  value="<?php echo $_POST["email"] ?? null ?>"
                  placeholder="user@example.com"
                  autocomplete="username" />

                <span class="icon is-small left"><i class="mdi mdi-email"></i></span>

              </div>
              <p class="help">Please enter your email</p>
              <p class="text-red-500" id="message"><?php echo $errors["email"] ?? null ?></p>

            </div>

            <div class="field spaced">
              <label class="label">Password</label>
              <p class="control icons-left">
                <input required
                  class="input"
                  type="password"
                  name="password"
                  value="<?php echo $_POST["password"] ?? null ?>"
                  placeholder="Password"
                  autocomplete="current-password" />
                <span class="icon is-small left"><i class="mdi mdi-lock"></i></span>
              </p>
              <p class="help">Please enter your password</p>
              <p class="text-red-500" id="message"><?php echo $errors["password"] ?? null ?></p>

            </div>

            <div class="flex items-center justify-between">


              <div class="control">
                <label class="label">role_id</label>
                <select
                  class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md"
                  name="role_id"
                  id="role_id">
                  <?php if (! empty($roles)) {
                  ?>
                    <?php foreach ($roles as $role) { ?>
                      <option value="<?php echo $role['id'] ?? null; ?>">
                        <?php echo $role['role'] ?? 'Unknown'; ?>
                      </option>
                    <?php } ?>
                  <?php } else { ?>
                    <option value="" disabled>No roles available</option>
                  <?php } ?>
                </select>


              </div>

              <div class="control">
                <label class="label">Status</label>
                <select
                  class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md"
                  name="is_active"
                  id="is_active">
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>


              </div>
            </div>

            <div class="field spaced">
              <label class="label">Date_Of_Birth</label>
              <p class="control icons-left">
                <input required
                  class="input"
                  type="date"
                  name="date_of_birth"
                  value="<?php echo $_POST["date_of_birth"] ?? null ?>"
                  placeholder="date_of_birth"
                  autocomplete="current-date_of_birth" />
                <span class="icon is-small left"><i class="mdi mdi-calculator"></i></span>
              </p>
              <p class="help">Please enter your date of birth</p>
              <p class="text-red-500" id="message" id="message"><?php echo $errors["date_of_birth"] ?? null ?></p>

            </div>
            <!-- <div class="field spaced">
              <label class="block mb-2 text-sm font-medium text-gray-700">Role</label>
              <div class="relative">
                <select
                  name="role_id"
                  id="role_id"
                  class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm appearance-none focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
                  <?php foreach ($roles as $role) { ?>
                    <option value="<?= $role['id'] ?>"><?= $role['role'] ?></option>
                  <?php } ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                  <svg
                    class="w-5 h-5 text-gray-400"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    aria-hidden="true">
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 9l-7 7-7-7" />
                  </svg>
                </div>
              </div>
              <p class="mt-2 text-sm text-gray-500">Please select your role</p>
            </div> -->


            <div class="field spaced">
              <label class="label">Address</label>
              <div class="control">
                <textarea
                  class="textarea"
                  name="address"
                  value="<?php echo $_POST["address"] ?? null ?>"
                  placeholder="Enter your address here"><?php echo $_POST["address"] ?? null ?></textarea>
              </div>
              <p class="text-red-500" id="message" id="message"><?php echo $errors["address"] ?? null ?></p>

              <p class="help">Please enter your Address</p>
            </div>


            <div class="field spaced">
              <label class="label">Upload File</label>
              <div class="control">
                <input required
                  class="w-full border border-gray-400 rounded-md file:border-0 file:rounded-lg file:px-4 file:py-2"
                  type="file"
                  name="image"
                  accept="image/*, .jpg, .jpeg, .png" />
              </div>
              <p class="help">Please upload a file (image, PDF, or document)</p>
              <p class="text-red-500" id="message"><?php echo $errors["image"] ?? null ?></p>
            </div>

            <!-- <div class="field spaced">
              <div class="control">
                <label class="checkbox"><input type="checkbox" name="restudent" value="1" checked />
                  <span class="check"></span>
                  <span class="control-label">Restudent</span>
                </label>
              </div>
            </div> -->


            <hr />

            <div class="field grouped">
              <div class="control">
                <button type="submit" class="button blue">signup</button>
              </div>
              <div class="control">
                <a href="../../user/index.php" class="button"> Back </a>
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
  <script>
    setTimeout(() => {
      const messageDiv = document.getElementById('message');
      if (messageDiv) {
        messageDiv.style.display = 'none';
      }
    }, 10000);
  </script>
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