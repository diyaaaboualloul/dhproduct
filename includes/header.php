<?php
// includes/header.php
require_once __DIR__ . '/auth.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$displayName = null;
if (isLoggedIn()) {
    // (Optional) fetch name to show in header
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/user_model.php';
    $u = user_find_by_id((int)$_SESSION['user_id']);
    $displayName = $u['name'] ?? null;
}
?>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
  <!-- Navbar Brand-->
  <a class="navbar-brand ps-3" href="/products.php">Diyaa Abou Alloul</a>

  <!-- Sidebar Toggle-->
  <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Navbar Search-->
  <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
    <div class="input-group">
      <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
      <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
    </div>
  </form>

  <!-- Right side -->
  <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
    <?php if (!isLoggedIn()): ?>
      <!-- Guest: show Login / Register -->
      <li class="nav-item">
        <a class="nav-link" href="/auth/login.php">Login</a>
      </li>
      <li class="nav-item ms-2">
        <a class="btn btn-sm btn-primary" href="/auth/register.php">Register</a>
      </li>
    <?php else: ?>
      <!-- Logged-in: show user dropdown -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
           data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fas fa-user fa-fw"></i>
          <span class="ms-1"><?= htmlspecialchars($displayName ?: 'Account') ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#!">Settings</a></li>
          <li><a class="dropdown-item" href="#!">Activity Log</a></li>
          <li><hr class="dropdown-divider" /></li>
          <li><a class="dropdown-item" href="/auth/logout.php">Logout</a></li>
        </ul>
      </li>
    <?php endif; ?>
  </ul>
</nav>
