<?php
session_start();
require_once('files/functions.php');

// Redirect if no cart
if (empty($_SESSION['cart'])) {
    $_SESSION['error_message'] = "Your cart is empty.";
    header("Location: cart-display.php");
    exit();
}

// If shipping data posted, save to session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['shipping'] = [
        'first_name' => $_POST['first_name'] ?? '',
        'last_name'  => $_POST['last_name'] ?? '',
        'email'      => $_POST['email'] ?? '',
        'phone'      => $_POST['phone'] ?? '',
        'address'    => $_POST['address'] ?? '',
    ];
} elseif (empty($_SESSION['shipping'])) {
    // No shipping info, redirect back to checkout
    header("Location: checkout.php");
    exit();
}

// Load cart and shipping info from session
$cart_items = $_SESSION['cart'];
$shipping = $_SESSION['shipping'];

// Calculate total price
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

require_once('files/header.php');
?>

<

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
        <a class="step-item active " href="checkout.php">
          <div class="step-progress"><span class="step-count">2</span></div>
          <div class="step-label"><i class="ci-user-circle"></i>Checkout</div>
        </a>
          <a class="step-item active current" href="review.php">
          <div class="step-progress"><span class="step-count">3</span></div>
          <div class="step-label"><i class="ci-check-circle"></i>Review</div>
        </a>
       
      </div>

     
      <!-- Shipping Form -->
      <h2 class="h6 pt-1 pb-3 mb-3 border-bottom">Review your order</h2>
         <?php if (!empty($cart_items)): ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="d-sm-flex justify-content-between align-items-center my-2 pb-3 border-bottom">
                        <div class="d-block d-sm-flex align-items-center text-center text-sm-start">
                            <?php
                            $photos = json_decode($item['photos'], true);
                            $photo_url = isset($photos[0]) ? $photos[0] : 'img/default.jpg';
                            ?>
                            <a class="d-inline-block flex-shrink-0 mx-auto me-sm-4" href="product.php?id=<?= $item['id']; ?>">
                                <img src="<?= htmlspecialchars($photo_url); ?>" width="160" alt="<?= htmlspecialchars($item['name']); ?>">
                            </a>
                            <div class="pt-2">
                                <h3 class="product-title fs-base mb-2">
                                    <a href="product.php?id=<?= $item['id']; ?>"><?= htmlspecialchars($item['name']); ?></a>
                                </h3>
                                <div class="fs-lg text-accent pt-2">$<?= number_format($item['price'], 2); ?></div>
                            </div>
                        </div>
                       
                    </div>
                <?php endforeach; ?>
                <button class="btn btn-outline-accent d-block w-100 mt-4" type="button"><i class="ci-loading fs-base me-2"></i>Update cart</button>
            <?php else: ?>
                <p class="text-center">Your cart is empty.</p>
            <?php endif; ?>
      <form method="post" action="submit-order.php">
        
        <div class="d-none d-lg-flex pt-4 mt-3">
          <div class="w-50 pe-3"><a class="btn btn-secondary d-block w-100" href="cart-display.php"><i class="ci-arrow-left me-1"></i>Back to Cart</a></div>
          <div class="w-50 ps-2"><button class="btn btn-primary d-block w-100" type="submit">submit orders<i class="ci-arrow-right ms-1"></i></button></div>
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
