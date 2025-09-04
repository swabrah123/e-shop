<?php
session_start();
require_once('files/functions.php');

// Fetch products or any required functions
products_insert();
require_once('files/header.php');

// Initialize cart data
$cart_items = [];
$cart_total = 0.0;

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_items[] = $item;
        $cart_total += $item['price'] * $item['quantity'];
    }
}
?>

<!-- Page Title-->
<div class="page-title-overlap bg-dark pt-4">
    <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
        <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
                    <li class="breadcrumb-item"><a class="text-nowrap" href="index.php"><i class="ci-home"></i>Home</a></li>
                    <li class="breadcrumb-item text-nowrap"><a href="shop.php">Shop</a></li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>
        <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
            <h1 class="h3 text-light mb-0">Your cart</h1>
        </div>
    </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
        <!-- List of items-->
        <section class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-4 pb-sm-5 mt-1">
                <h2 class="h6 text-light mb-0">Products</h2>
                <a class="btn btn-outline-primary btn-sm ps-2" href="shop.php">
                    <i class="ci-arrow-left me-2"></i>Continue shopping
                </a>
            </div>

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
                        <div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-start" style="max-width: 9rem;">
                            <label class="form-label" for="quantity<?= $item['id']; ?>">Quantity</label>
                            <input class="form-control" type="number" id="quantity<?= $item['id']; ?>" value="<?= $item['quantity']; ?>" min="1">
                            <form action="cart-process-remove.php" method="post" style="margin-top:5px;">
                                <input type="hidden" name="id" value="<?= $item['id']; ?>">
                                <button class="btn btn-link px-0 text-danger" type="submit">
                                    <i class="ci-close-circle me-2"></i><span class="fs-sm">Remove</span>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
                <button class="btn btn-outline-accent d-block w-100 mt-4" type="button"><i class="ci-loading fs-base me-2"></i>Update cart</button>
            <?php else: ?>
                <p class="text-center">Your cart is empty.</p>
            <?php endif; ?>
        </section>

        <!-- Sidebar-->
        <aside class="col-lg-4 pt-4 pt-lg-0 ps-xl-5">
            <div class="bg-white rounded-3 shadow-lg p-4">
                <div class="py-2 px-xl-2">
                    <div class="text-center mb-4 pb-3 border-bottom">
                        <h2 class="h6 mb-3 pb-1">Subtotal</h2>
                        <h3 class="fw-normal">$<?= number_format($cart_total, 2); ?></h3>
                    </div>
                    <div class="mb-3 mb-4">
                        <label class="form-label mb-3" for="order-comments">
                            <span class="badge bg-info fs-xs me-2">Note</span>
                            <span class="fw-medium">Additional comments</span>
                        </label>
                        <textarea class="form-control" rows="6" id="order-comments"></textarea>
                    </div>
                    <div class="accordion" id="order-options">
                        <!-- Promo code accordion -->
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <a class="accordion-button" href="#promo-code" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="promo-code">Apply promo code</a>
                            </h3>
                            <div class="accordion-collapse collapse show" id="promo-code" data-bs-parent="#order-options">
                                <form class="accordion-body needs-validation" method="post" novalidate>
                                    <div class="mb-3">
                                        <input class="form-control" type="text" placeholder="Promo code" required>
                                        <div class="invalid-feedback">Please provide promo code.</div>
                                    </div>
                                    <button class="btn btn-outline-primary d-block w-100" type="submit">Apply promo code</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary btn-shadow d-block w-100 mt-4" href="checkout.php">
                        <i class="ci-card fs-lg me-2"></i>Proceed to Checkout
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>
</main>

<?php require_once('files/footer.php'); ?>
