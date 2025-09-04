<?php
session_start();
require_once('files/functions.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "You must be logged in to proceed to checkout.";
    header("Location: login.php");
    exit();
}

// Direct Database Connection (PDO)
$host = "localhost";
$dbname = "e_store_recover";  
$username = "root";              
$password = "";                  
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch user info from database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $user_name  = $user['first_name'] . ' ' . $user['last_name'];
    $user_email = $user['email'];
    $user_phone = $user['phone'];
} else {
    $_SESSION['error_message'] = "User not found.";
    header("Location: login.php");
    exit();
}

$user_photo = $_SESSION['user_photo'] ?? 'img/shop/account/avatar.jpg'; // Default avatar

// Fetch cart items
$cart_items = $_SESSION['cart'] ?? [];
$cart_total = 0;
foreach ($cart_items as $item) {
    $cart_total += $item['price'] * $item['quantity'];
}

require_once('files/header.php');
?>


<!-- Display session messages -->
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<!-- Page Title-->
<div class="page-title-overlap bg-dark pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="index.php"><i class="ci-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap"><a href="shop.php">Shop</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page">Checkout</li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
      <h1 class="h3 text-light mb-0">Checkout</h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row g-4">
    <!-- Form (Left) -->
    <section class="col-lg-8">
      <!-- Steps -->
      <div class="steps steps-light pt-2 pb-3 mb-5">
        <a class="step-item active" href="cart-display.php">
          <div class="step-progress"><span class="step-count">1</span></div>
          <div class="step-label"><i class="ci-cart"></i>Cart</div>
        </a>
        <a class="step-item active current" href="checkout.php">
          <div class="step-progress"><span class="step-count">2</span></div>
          <div class="step-label"><i class="ci-user-circle"></i>Checkout</div>
        </a>
        <a class="step-item" href="review.php">
          <div class="step-progress"><span class="step-count">3</span></div>
          <div class="step-label"><i class="ci-check-circle"></i>Review</div>
        </a>
      </div>

      <!-- Customer Info -->
      <div class="d-sm-flex justify-content-between align-items-center bg-secondary p-4 rounded-3 mb-grid-gutter">
        <div class="d-flex align-items-center">
          <div class="img-thumbnail rounded-circle position-relative flex-shrink-0">
            <img class="rounded-circle" src="<?= htmlspecialchars($user_photo); ?>" width="90" alt="<?= htmlspecialchars($user_name); ?>">
          </div>
          <div class="ps-3">
            <h3 class="fs-base mb-0"><?= htmlspecialchars($user_name); ?></h3>
            <span class="text-accent fs-sm"><?= htmlspecialchars($user_email); ?></span>
          </div>
        </div>
        <a class="btn btn-light btn-sm btn-shadow mt-3 mt-sm-0" href="account-profile.php"><i class="ci-edit me-2"></i>Edit profile</a>
      </div>

      <!-- Shipping Form -->
      <h2 class="h6 pt-1 pb-3 mb-3 border-bottom">Shipping address</h2>
      <form method="post" action="review.php">
        <div class="row">
          <div class="col-sm-6 mb-3">
            <label class="form-label" for="checkout-fn">First Name</label>
            <input class="form-control" name="first_name" type="text" id="checkout-fn" value="<?= htmlspecialchars($user['first_name']); ?>" required>
          </div>
          <div class="col-sm-6 mb-3">
            <label class="form-label" for="checkout-ln">Last Name</label>
            <input class="form-control" name="last_name" type="text" id="checkout-ln" value="<?= htmlspecialchars($user['last_name']); ?>" required>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 mb-3">
            <label class="form-label" for="checkout-email">E-mail Address</label>
            <input class="form-control" name="email" type="email" id="checkout-email" value="<?= htmlspecialchars($user_email); ?>" required>
          </div>
          <div class="col-sm-6 mb-3">
            <label class="form-label" for="checkout-phone">Phone Number</label>
            <input class="form-control" name="phone" type="text" id="checkout-phone" value="<?= htmlspecialchars($user_phone); ?>" required>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 mb-3">
            <label class="form-label" for="checkout-address">Address</label>
            <input class="form-control" name="address" type="text" id="checkout-address" required>
          </div>
        </div>

        <div class="d-none d-lg-flex pt-4 mt-3">
          <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="cart-display.php"><i class="ci-arrow-left me-1"></i>Back to Cart</a></div>
          <div class="w-50 ps-2"><button class="btn btn-primary d-block w-100" type="submit">Proceed to Shipping<i class="ci-arrow-right ms-1"></i></button></div>
        </div>
      </form>
    </section>

    <!-- Sidebar (Right) -->
    <aside class="col-lg-4">
      <div class="bg-white rounded-3 shadow-lg p-4 ms-lg-auto">
        <div class="py-2 px-xl-2">
          <h2 class="widget-title text-center">Order summary</h2>
          <?php if (!empty($cart_items)): ?>
            <?php foreach ($cart_items as $item): 
              $photos = json_decode($item['photos'], true);
              $photo_url = $photos[0] ?? 'img/default.jpg';
            ?>
              <div class="d-flex align-items-center py-2 border-bottom">
                <a class="d-block flex-shrink-0" href="product.php?id=<?= $item['id']; ?>">
                  <img src="<?= htmlspecialchars($photo_url); ?>" width="64" alt="<?= htmlspecialchars($item['name']); ?>">
                </a>
                <div class="ps-2">
                  <h6 class="widget-product-title"><a href="product.php?id=<?= $item['id']; ?>"><?= htmlspecialchars($item['name']); ?></a></h6>
                  <div class="widget-product-meta">
                    <span class="text-accent me-2">$<?= number_format($item['price'], 2); ?></span>
                    <span class="text-muted">x <?= $item['quantity']; ?></span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            <ul class="list-unstyled fs-sm pb-2 border-bottom">
              <li class="d-flex justify-content-between"><span>Subtotal:</span><span>$<?= number_format($cart_total, 2); ?></span></li>
            </ul>
            <h3 class="fw-normal text-center my-4">$<?= number_format($cart_total, 2); ?></h3>
          <?php else: ?>
            <p class="text-center text-muted">Your cart is empty.</p>
          <?php endif; ?>
        </div>
      </div>
    </aside>
  </div>
</div>
</main>

<?php require_once('files/footer.php'); ?>


<?php require_once('files/footer.php'); ?>
