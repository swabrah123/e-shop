<?php
session_start();
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

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Fetch orders with user name
$sql = "SELECT id, customer_id, user_name, created_at, order_status, total_price
        FROM orders
        ORDER BY id DESC
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Count total orders
$totalResult = $conn->query("SELECT COUNT(*) as total FROM orders");
$totalOrders = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalOrders / $limit);

// Helper function for badge class based on status
function statusBadgeClass($status) {
    $status = strtolower($status);
    return match($status) {
        'pending' => 'bg-warning',
        'in progress' => 'bg-info',
        'delivered' => 'bg-success',
        'canceled' => 'bg-danger',
        'completed' => 'bg-success',
        'delayed' => 'bg-warning',
        default => 'bg-secondary',
    };
}
?>

<!-- Include Bootstrap Icons CDN in your <head> if not already -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

<!-- Page Title-->
<div class="page-title-overlap bg-dark pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="index-2.html"><i class="ci-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap"><a href="#">Account</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page">Orders history</li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
      <h1 class="h3 text-light mb-0">Order History</h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <?php require_once('files/account-sidebar.php');?>

    <!-- Content  -->
    <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
      <div class="pt-2 px-4 ps-lg-0 pe-xl-5">

        <!-- Title-->
        <div class="d-sm-flex flex-wrap justify-content-between align-items-center border-bottom">
          <h2 class="h3 py-2 me-2 text-center text-sm-start">Your orders<span class="badge bg-faded-accent fs-sm text-body align-middle ms-2"><?= $totalOrders ?></span></h2>
          <div class="py-2"></div>
        </div>

        <!-- Orders Table -->
        <div class="table-responsive fs-md mb-4">
          <table class="table table-hover mb-0 align-middle">
            <thead>
              <tr>
                <th>Order #</th>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Date Purchased</th>
                <th>Status</th>
                <th>Total</th>
                <th class="text-center">View</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td class="py-3"><?= htmlspecialchars($row['id']) ?></td>
                    <td class="py-3"><?= htmlspecialchars($row['customer_id']) ?></td>
                    <td class="py-3"><?= htmlspecialchars($row['user_name']) ?></td>
                    <td class="py-3"><?= date('F d, Y', strtotime($row['created_at'])) ?></td>
                    <td class="py-3">
                      <span class="badge <?= statusBadgeClass($row['order_status']) ?> m-0">
                        <?= ucfirst(htmlspecialchars($row['order_status'])) ?>
                      </span>
                    </td>
                    <td class="py-3">$<?= number_format($row['total_price'], 2) ?></td>
                    <td class="py-3 text-center">
                      <a href="order_history_details.php?order_id=<?= urlencode($row['id']) ?>" 
                         class="btn btn-sm btn-outline-primary" 
                         title="View Details">
                        <i class="bi bi-eye"></i>
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr><td colspan="7" class="text-center">No orders found.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <nav class="d-flex justify-content-between pt-2" aria-label="Page navigation">
          <ul class="pagination">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= max(1, $page - 1) ?>" aria-label="Previous">
                <i class="ci-arrow-left me-2"></i>Prev
              </a>
            </li>
          </ul>

          <ul class="pagination">
            <li class="page-item d-sm-none"><span class="page-link page-link-static"><?= $page ?> / <?= $totalPages ?></span></li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?= ($i === $page) ? 'active' : '' ?> d-none d-sm-block" aria-current="<?= ($i === $page) ? 'page' : '' ?>">
                <?php if ($i === $page): ?>
                  <span class="page-link"><?= $i ?><span class="visually-hidden">(current)</span></span>
                <?php else: ?>
                  <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                <?php endif; ?>
              </li>
            <?php endfor; ?>
          </ul>

          <ul class="pagination">
            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= min($totalPages, $page + 1) ?>" aria-label="Next">
                Next<i class="ci-arrow-right ms-2"></i>
              </a>
            </li>
          </ul>
        </nav>

      </div>
    </section>
  </div>
</div>

<?php require_once('files/footer.php'); ?>
