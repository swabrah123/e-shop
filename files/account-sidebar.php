<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('files/functions.php'); 
require_once('files/header.php'); 

// DB connection
$host = 'localhost';
$dbname = 'e_store_recover';
$username = 'root';
$password = '';
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("DB connection failed: " . $conn->connect_error);
}

$user = null;
$rewardPoints = 384; // example default
$avatarUrl = "img/shop/account/avatar.jpg"; // default avatar

if (isset($_SESSION['user_id'])) {
    $userId = (int)$_SESSION['user_id'];

    // Fetch user info
    $stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {
        $user = $res->fetch_assoc();
    }
    $stmt->close();
}
?>

<!-- Sidebar-->
<aside class="col-lg-4 pt-4 pt-lg-0 pe-xl-5">
  <div class="bg-white rounded-3 shadow-lg pt-1 mb-5 mb-lg-0">
    <div class="d-md-flex justify-content-between align-items-center text-center text-md-start p-4">
      <div class="d-md-flex align-items-center">
        <div class="img-thumbnail rounded-circle position-relative flex-shrink-0 mx-auto mb-2 mx-md-0 mb-md-0" style="width: 6.375rem;">
          <span class="badge bg-warning position-absolute end-0 mt-n2" data-bs-toggle="tooltip" title="Reward points">
            <?= htmlspecialchars($rewardPoints) ?>
          </span>
          <img class="rounded-circle" src="<?= htmlspecialchars($avatarUrl) ?>" alt="<?= $user ? htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) : 'User Avatar' ?>">
        </div>
        <div class="ps-md-3">
          <h3 class="fs-base mb-0">
            <?= $user ? htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) : 'Guest User' ?>
          </h3>
          <span class="text-accent fs-sm">
            <?= $user ? htmlspecialchars($user['email']) : 'Not signed in' ?>
          </span>
        </div>
      </div>
      <a class="btn btn-primary d-lg-none mb-2 mt-3 mt-md-0" href="#account-menu" data-bs-toggle="collapse" aria-expanded="false">
        <i class="ci-menu me-2"></i>Account menu
      </a>
    </div>

<div class="d-lg-block collapse" id="account-menu">

  <!-- Admin Section -->
  <div class="bg-secondary px-4 py-3">
    <h3 class="fs-sm mb-0 text-muted">Admin</h3>
  </div>
  <ul class="list-unstyled mb-0">
    <li class="border-bottom mb-0">
      <a class="nav-link-style d-flex align-items-center px-4 py-3" href="admin-categories-add.php">
        <i class="ci-user opacity-60 me-2"></i> Create Products' Categories
      </a>
    </li>
    <li class="border-bottom mb-0">
      <a class="nav-link-style d-flex align-items-center px-4 py-3" href="admin-categories.php">
        <i class="ci-user opacity-60 me-2"></i> Products' Categories
      </a>
    </li>
    <li class="border-bottom mb-0">
      <a class="nav-link-style d-flex align-items-center px-4 py-3" href="admin-products-add.php">
        <i class="ci-user opacity-60 me-2"></i> Create Products
      </a>
    </li>
    <li class="border-bottom mb-0">
      <a class="nav-link-style d-flex align-items-center px-4 py-3" href="admin-products.php">
        <i class="ci-user opacity-60 me-2"></i> Products
      </a>
    </li>
    <li class="border-bottom mb-0">
      <a class="nav-link-style d-flex align-items-center px-4 py-3" href="admin-orders.php">
        <i class="ci-bag opacity-60 me-2"></i> Customer Orders
      </a>
    </li>
  </ul>

  <!-- My Orders Section -->
  <div class="bg-secondary px-4 py-3 mt-4">
    <h3 class="fs-sm mb-0 text-muted">My Orders</h3>
  </div>
  <ul class="list-unstyled mb-0">
    <li class="border-bottom mb-0">
      <a class="nav-link-style d-flex align-items-center px-4 py-3" href="account_orders.php">
        <i class="ci-user opacity-60 me-2"></i> My Orders
      </a>
    </li>
    <li class="border-bottom mb-0">
      <a class="nav-link-style d-flex align-items-center px-4 py-3" href="logout.php">
        <i class="ci-user opacity-60 me-2"></i> Sign Out
      </a>
    </li>
    <li class="d-lg-none border-top mb-0">
      <a class="nav-link-style d-flex align-items-center px-4 py-3" href="/logout.php">
        <i class="ci-sign-out opacity-60 me-2"></i> Sign Out
      </a>
    </li>
  </ul>

</div>

            </div>
          </aside>