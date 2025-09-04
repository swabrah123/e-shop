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
$limit = 1;  // Show 1 order per page in details view
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Count total orders
$totalResult = $conn->query("SELECT COUNT(*) as total FROM orders");
$totalOrders = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalOrders / $limit);

// Fetch the order for current page
$sql = "SELECT * FROM orders ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    echo '<div class="container py-5"><div class="alert alert-warning">No order found.</div></div>';
    require_once('files/footer.php');
    exit;
}

$order = $result->fetch_assoc();

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

// Decode cart JSON (stored as JSON string)
$cart = json_decode($order['cart'], true);

?>

<!-- Include Bootstrap Icons CDN if not already -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

<div class="page-title-overlap bg-dark pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="index-2.html"><i class="ci-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap"><a href="order_history.php">Orders History</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page">Order #<?= htmlspecialchars($order['id']) ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
      <h1 class="h3 text-light mb-0">Order Details</h1>
    </div>
  </div>
</div>

<div class="container py-5">
  <div class="card shadow-sm">
    <div class="card-header">
      <h5>Order #<?= htmlspecialchars($order['id']) ?></h5>
      <span class="badge <?= statusBadgeClass($order['order_status']) ?> ms-2">
        <?= ucfirst(htmlspecialchars($order['order_status'])) ?>
      </span>
    </div>
    <div class="card-body">
      <p><strong>Customer ID:</strong> <?= htmlspecialchars($order['customer_id']) ?></p>
      <p><strong>Customer Name:</strong> <?= htmlspecialchars($order['user_name']) ?></p>
      <p><strong>Date Purchased:</strong> <?= date('F d, Y', strtotime($order['created_at'])) ?></p>
      <p><strong>Total Price:</strong> $<?= number_format($order['total_price'], 2) ?></p>

      <hr>

      <h5>Shipping Address</h5>
      <?php
// Decode shipping_address JSON safely
$shippingData = json_decode($order['shipping_address'], true);
$addressOnly = '';
if (is_array($shippingData) && isset($shippingData['address'])) {
    $addressOnly = $shippingData['address'];
} else {
    // fallback if not JSON or empty
    $addressOnly = $order['shipping_address'];
}
?>
<p><?= htmlspecialchars($addressOnly) ?></p>


      <hr>

      <h5>Ordered Items</h5>
      <?php if (!empty($cart) && is_array($cart)): ?>
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>Product Name</th>
              <th class="text-center">Quantity</th>
              <th class="text-end">Price</th>
              <th class="text-end">Subtotal</th>
              <th>Photo</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $grandTotal = 0;
            foreach ($cart as $item):
              $price = (float)$item['price'];
              $qty = (int)$item['quantity'];
              $subtotal = $price * $qty;
              $grandTotal += $subtotal;

              // photos is a JSON string, decode it
              $photos = json_decode($item['photos'], true);
              $firstPhoto = $photos[0] ?? null;
            ?>
            <tr>
              <td><?= htmlspecialchars($item['name']) ?></td>
              <td class="text-center"><?= $qty ?></td>
              <td class="text-end">$<?= number_format($price, 2) ?></td>
              <td class="text-end">$<?= number_format($subtotal, 2) ?></td>
              <td>
                <?php if ($firstPhoto): ?>
                  <img src="<?= htmlspecialchars($firstPhoto) ?>" alt="Product Photo" style="max-width: 80px; max-height: 80px; object-fit: contain;">
                <?php else: ?>
                  N/A
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="text-end">Grand Total:</th>
              <th class="text-end">$<?= number_format($grandTotal, 2) ?></th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      <?php else: ?>
        <p>No items found in the order.</p>
      <?php endif; ?>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
      <a href="Admin-orders.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Back to Orders</a>

      <!-- Pagination -->
      <nav aria-label="Order pagination">
        <ul class="pagination mb-0">
          <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= max(1, $page - 1) ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo; Prev</span>
            </a>
          </li>

          <li class="page-item disabled d-none d-md-block">
            <span class="page-link">
              Page <?= $page ?> of <?= $totalPages ?>
            </span>
          </li>

          <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= min($totalPages, $page + 1) ?>" aria-label="Next">
              <span aria-hidden="true">Next &raquo;</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</div>

<?php
$conn->close();
require_once('files/footer.php');
?>
