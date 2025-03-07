<?php

$email = $_SESSION['user']['email'] ?? null;
$stmt = $conn->query("SELECT * FROM users WHERE email='$email'");
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<aside class="aside is-placed-left is-expanded">
  <div class="aside-tools">
    <div>Admin <b class="font-black">One</b></div>
  </div>
  <div class="menu is-menu-main">
    <p class="menu-label">General</p>
    <ul class="menu-list">
      <li class="active">
        <a href="../../user/index.php">
          <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
          <span class="menu-item-label">Dashboard</span>
        </a>
      </li>
    </ul>
    <p class="menu-label">Examples</p>
    <ul class="menu-list">
      <li class="--set-active-profile-html">
        <a href="../../user/users.php">
          <span class="icon"><i class="mdi mdi-account-circle"></i></span>
          <span class="menu-item-label">Users</span>
        </a>
      </li>


      <!-- <li class="--set-active-tables-html">
        <a href="../../user/tables.php">
          <span class="icon"><i class="mdi mdi-table"></i></span>
          <span class="menu-item-label">Tables</span>
        </a>
      </li> -->

      <li class="--set-active-category-html">
        <a href="../../user/courses.php">
          <span class="icon"><i class="mdi mdi-school"></i></span>
          <span class="menu-item-label">Courses</span>
        </a>
      </li>
      <li class="--set-active-category-html">
        <a href="../user/category.php">
          <span class="icon"><i class="mdi mdi-tag"></i></span>
          <span class="menu-item-label">Categories</span>
        </a>
      </li>

      <li class="--set-active-enrollment-html">
        <a href="../../user/enrollment.php">
          <span class="icon"><i class="mdi mdi-account-circle"></i></span>
          <span class="menu-item-label">Enrollments</span>
        </a>
      </li>






      <li>
        <a class="dropdown">
          <span class="icon"><i class="mdi mdi-view-list"></i></span>
          <span class="menu-item-label">Submenus</span>
          <span class="icon"><i class="mdi mdi-plus"></i></span>
        </a>
        <ul>
          <li>
            <a href="#void">
              <span>Sub-item One</span>
            </a>
          </li>
          <li>
            <a href="#void">
              <span>Sub-item Two</span>
            </a>
          </li>
        </ul>
      </li>
      <?php if (! isset($_SESSION['user'])) { ?>
        <li>
          <a href="../user/signup.php">
            <span class="icon"><i class="mdi mdi-account-plus"></i></span>
            <span class="menu-item-label">Sign Up</span>
          </a>
        </li>
        <li>
          <a href="../user/login.php">
            <span class="icon"><i class="mdi mdi-login"></i></span>
            <span class="menu-item-label">Login</span>
          </a>
        </li>
      <?php } else { ?>
        <li>
          <a href="../user/logout.php">
            <span class="icon"><i class="mdi mdi-logout"></i></span>
            <span class="menu-item-label">Logout</span>
          </a>
        </li>
      <?php } ?>
    </ul>
    <p class="menu-label">About</p>
    <ul class="menu-list ">

      <li>
        <a
          href="https://www.x.com/AsgharAli101"
          class="has-icon">
          <span class="icon"><i class="mdi mdi-twitter-circle"></i></span>
          <span class="menu-item-label">Twitter</span>
        </a>
      </li>
      <li>
        <a
          href="https://www.facebook.com/asgharburdi22"
          class="has-icon">

          <span class="icon"><i class="mdi mdi-facebook"></i></span>
          <span class="menu-item-label">facebook</span>
        </a>
      </li>
      <li>
        <a
          href="https://github.com/asgharali101"
          class="has-icon">
          <span class="icon"><i class="mdi mdi-github-circle"></i></span>
          <span class="menu-item-label">GitHub</span>
        </a>
      </li>
      <li class="pb-10" style="margin-bottom: 10px;">
        <a
          href="https://linkedin.com/asgharali-dev"
          class="has-icon">
          <span class="icon"><i class="mdi mdi-linkedin"></i></span>
          <span class="menu-item-label">linkedin</span>
        </a>
      </li>
    </ul>
  </div>
</aside>