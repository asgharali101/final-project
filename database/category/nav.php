<?php

$email = $_SESSION['user']['email'] ?? null;
$stmt = $conn->query("SELECT * FROM users WHERE email='$email'");
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

$image = "../" . $currentUser["image_path"];
?>


<nav id="navbar-main" class="navbar is-fixed-top">
  <div class="navbar-brand">
    <a class="navbar-item mobile-aside-button">
      <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
    </a>
    <div class="navbar-item">
      <div class="control" x-data="searchApp()">
        <form action="" @submit.prevent="performSearch" class="flex items-center">
          <input type="search" x-model="search" placeholder="Search everywhere..." class="input" />
        </form>
        <div class="mt-4">
          <template x-if="searchResults.length > 0">
            <ul>
              <template x-for="result in searchResults" :key="result.id">
                <li class="p-2 border-b" x-text="result"></li>
              </template>
            </ul>
          </template>

          <template x-if="searchResults.length === 0 && searchQuery.trim() !== ''">
            <p class="text-gray-500">No results found</p>
          </template>
        </div>
      </div>
    </div>
  </div>
  <div class="navbar-brand is-right">
    <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
      <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
    </a>
  </div>
  <div class="navbar-menu" id="navbar-menu">
    <div class="navbar-end">

      <div class="navbar-item dropdown has-divider">
        <a class="navbar-link" href="/index.php">
          <span class="icon"><i class="mdi mdi-menu"></i></span>
          <span>Home</span>
          <span class="icon">
            <i class="mdi mdi-chevron-down"></i>
          </span>
        </a>
        <div class="navbar-dropdown">
          <a href="" class="navbar-item">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            <span>Home Page</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-settings"></i></span>
            <span>Settings</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-email"></i></span>
            <span>Messages</span>
          </a>
          <hr class="navbar-divider" />
          <a class="navbar-item" href="../database/user/logout.php">
            <span class="icon"><i class="mdi mdi-logout"></i></span>
            <span>Log Out</span>
          </a>
        </div>
      </div>

      <div class="navbar-item dropdown has-divider has-user-avatar">
        <a class="navbar-link" href="../../user/profile.php?id=<?php echo $currentUser['id'] ?? null ?> ">
          <div class="user-avatar">
            <img class="rounded-full"
              src="<?php echo (!empty($image)
                      ? "../" . $image
                      : 'https://ui-avatars.com/api/?name=' . urlencode($currentUser['first_name'] ?? 'User')); ?>"
              alt="Avatar">
          </div>
          <div class="is-user-name"><span><?php echo $currentUser['first_name'] ?? 'No User' ?></span> <span><?php echo $currentUser['last_name'] ?? 'ali' ?></span> </div>
          <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
        </a>
        <div class="navbar-dropdown">
          <a href="../../user/profile.php?id=<?php echo $currentUser['id'] ?? null ?> " class="navbar-item">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            <span>My Profile</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-settings"></i></span>
            <span>Settings</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-email"></i></span>
            <span>Messages</span>
          </a>
          <hr class="navbar-divider" />
          <a class="navbar-item" href="../database/user/logout.php">
            <span class="icon"><i class="mdi mdi-logout"></i></span>
            <span>Log Out</span>
          </a>
        </div>
      </div>

      <a
        href="https://justboil.me/tailwind-admin-templates"
        class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="mdi mdi-help-circle-outline"></i></span>
        <span>About</span>
      </a>

      <a
        href="https://github.com/asgharali101"
        class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="mdi mdi-github-circle"></i></span>
        <span>GitHub</span>
      </a>

      <a title="Log out" class="navbar-item desktop-icon-only" href="../database/user/logout.php">
        <span class="icon"><i class="mdi mdi-logout"></i></span>
        <span>Log out</span>
      </a>
    </div>
  </div>
</nav>