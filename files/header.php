<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('files/functions.php');

$cart_count = 0;
$cart_items = [];
$cart_total = 0.0;
$max_items = 4;  // max unique products displayed in cart

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cart_count = count($_SESSION['cart']);
    
    // Reverse the cart to show latest added products first
    $reversed_cart = array_reverse($_SESSION['cart'], true);

    // Only take up to $max_items products
    $limited_items = array_slice($reversed_cart, 0, $max_items, true);
    
    foreach ($limited_items as $item) {
        $cart_items[] = $item;
        $cart_total += $item['price'] * $item['quantity'];
    }
} else {
    $cart_count = 0;
}
?>


<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from cartzilla.createx.studio/home-fashion-store-v1.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 09 Oct 2023 15:48:22 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <title>Cartzilla | Fashion Store v.1</title>
    <!-- SEO Meta Tags-->
    <meta name="description" content="Cartzilla - Bootstrap E-commerce Template">
    <meta name="keywords" content="bootstrap, shop, e-commerce, market, modern, responsive,  business, mobile, bootstrap, html5, css3, js, gallery, slider, touch, creative, clean">
    <meta name="author" content="Createx Studio">
    <!-- Viewport-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" color="#fe6a6a" href="safari-pinned-tab.svg">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendor Styles including: Font Icons, Plugins, etc.-->
    <link rel="stylesheet" media="screen" href="vendor/simplebar/dist/simplebar.min.css"/>
    <link rel="stylesheet" media="screen" href="vendor/tiny-slider/dist/tiny-slider.css"/>
    <link rel="stylesheet" media="screen" href="vendor/drift-zoom/dist/drift-basic.min.css"/>
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="css/theme.min.css">
    <!-- Google Tag Manager-->
     <style>
  #main-image {
    transition: transform 0.3s ease;
    cursor: zoom-in;
  }

  #main-image.zoomed {
    transform: scale(2); /* Zoom scale */
    cursor: zoom-out;
    z-index: 1000;
    position: relative;
  }
  #main-image {
  transition: transform 0.3s ease;
  cursor: zoom-in;
}

#main-image:hover {
  transform: scale(1.3  );  
  cursor: zoom-out;
  z-index: 1000;
  position: relative;
}

</style>

    <script>
      (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      '../www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f);
      })(window,document,'script','dataLayer','GTM-WKV3GT5');
    </script>
  </head>
  <!-- Body-->
  <body class="handheld-toolbar-enabled">
    <!-- Google Tag Manager (noscript)-->
    <noscript>
      <iframe src="http://www.googletagmanager.com/ns.html?id=GTM-WKV3GT5" height="0" width="0" style="display: none; visibility: hidden;"></iframe>
    </noscript>
    <!-- Sign in / sign up modal -->
<div class="modal fade" id="signin-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-secondary">
        <ul class="nav nav-tabs card-header-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link fw-medium active" href="login.php#signin-tab" data-bs-toggle="tab" role="tab" aria-selected="true">
              <i class="ci-unlocked me-2 mt-n1"></i>Sign in
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-medium" href="login.php#signup-tab" data-bs-toggle="tab" role="tab" aria-selected="false">
              <i class="ci-user me-2 mt-n1"></i>Sign up
            </a>
          </li>
        </ul>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body tab-content py-4">

        <!-- Sign In Form -->
        <form class="needs-validation tab-pane fade show active" autocomplete="off" novalidate id="signin-tab" method="post" action="loginlogic.php">
          <input type="hidden" name="action" value="login">
          <div class="mb-3">
            <label class="form-label" for="si-email">Email address</label>
            <input class="form-control" type="email" id="si-email" name="email" placeholder="johndoe@example.com" required>
            <div class="invalid-feedback">Please provide a valid email address.</div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="si-password">Password</label>
            <div class="password-toggle">
              <input class="form-control" type="password" id="si-password" name="password" required>
              <label class="password-toggle-btn" aria-label="Show/hide password">
                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
              </label>
            </div>
          </div>
          <div class="mb-3 d-flex flex-wrap justify-content-between">
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="si-remember" name="remember_me">
              <label class="form-check-label" for="si-remember">Remember me</label>
            </div>
            <a class="fs-sm" href="#">Forgot password?</a>
          </div>
          <button class="btn btn-primary btn-shadow d-block w-100" type="submit">Sign in</button>
        </form>

        <!-- Sign Up Form -->
        <form class="needs-validation tab-pane fade" autocomplete="off" novalidate id="signup-tab" method="post" action="loginlogic.php">
          <input type="hidden" name="action" value="register">
          <div class="mb-3">
            <label class="form-label" for="su-fullname">Full name</label>
            <input class="form-control" type="text" id="su-fullname" name="full_name" placeholder="John Doe" required>
            <div class="invalid-feedback">Please fill in your name.</div>
          </div>
          <div class="mb-3">
            <label for="su-email">Email address</label>
            <input class="form-control" type="email" id="su-email" name="email" placeholder="johndoe@example.com" required>
            <div class="invalid-feedback">Please provide a valid email address.</div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="su-password">Password</label>
            <div class="password-toggle">
              <input class="form-control" type="password" id="su-password" name="password" required>
              <label class="password-toggle-btn" aria-label="Show/hide password">
                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
              </label>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="su-password-confirm">Confirm password</label>
            <div class="password-toggle">
              <input class="form-control" type="password" id="su-password-confirm" name="confirm_password" required>
              <label class="password-toggle-btn" aria-label="Show/hide password">
                <input class="password-toggle-check" type="checkbox"><span class="password-toggle-indicator"></span>
              </label>
            </div>
          </div>
          <button class="btn btn-primary btn-shadow d-block w-100" type="submit">Sign up</button>
        </form>

      </div>
    </div>
  </div>
</div>
    <main class="page-wrapper">
      <!-- Quick View Modal-->
      <div class="modal-quick-view modal fade" id="quick-view" tabindex="-1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title product-title"><a href="shop-single-v1.html" data-bs-toggle="tooltip" data-bs-placement="right" title="Go to product page">Sports Hooded Sweatshirt<i class="ci-arrow-right fs-lg ms-2"></i></a></h4>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row">
                <!-- Product gallery-->
                <div class="col-lg-7 pe-lg-0">
                  <div class="product-gallery">
                    <div class="product-gallery-preview order-sm-2">
                      <div class="product-gallery-preview-item active" id="first"><img class="image-zoom" src="img/shop/single/gallery/01.jpg" data-zoom="img/shop/single/gallery/01.jpg" alt="Product image">
                        <div class="image-zoom-pane"></div>
                      </div>
                      <div class="product-gallery-preview-item" id="second"><img class="image-zoom" src="img/shop/single/gallery/02.jpg" data-zoom="img/shop/single/gallery/02.jpg" alt="Product image">
                        <div class="image-zoom-pane"></div>
                      </div>
                      <div class="product-gallery-preview-item" id="third"><img class="image-zoom" src="img/shop/single/gallery/03.jpg" data-zoom="img/shop/single/gallery/03.jpg" alt="Product image">
                        <div class="image-zoom-pane"></div>
                      </div>
                      <div class="product-gallery-preview-item" id="fourth"><img class="image-zoom" src="img/shop/single/gallery/04.jpg" data-zoom="img/shop/single/gallery/04.jpg" alt="Product image">
                        <div class="image-zoom-pane"></div>
                      </div>
                    </div>
                    <div class="product-gallery-thumblist order-sm-1"><a class="product-gallery-thumblist-item active" href="#first"><img src="img/shop/single/gallery/th01.jpg" alt="Product thumb"></a><a class="product-gallery-thumblist-item" href="#second"><img src="img/shop/single/gallery/th02.jpg" alt="Product thumb"></a><a class="product-gallery-thumblist-item" href="#third"><img src="img/shop/single/gallery/th03.jpg" alt="Product thumb"></a><a class="product-gallery-thumblist-item" href="#fourth"><img src="img/shop/single/gallery/th04.jpg" alt="Product thumb"></a></div>
                  </div>
                </div>
                <!-- Product details-->
                <div class="col-lg-5 pt-4 pt-lg-0 image-zoom-pane">
                  <div class="product-details ms-auto pb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2"><a href="shop-single-v1.html#reviews">
                        <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star"></i>
                        </div><span class="d-inline-block fs-sm text-body align-middle mt-1 ms-1">74 Reviews</span></a>
                      <button class="btn-wishlist" type="button" data-bs-toggle="tooltip" title="Add to wishlist"><i class="ci-heart"></i></button>
                    </div>
                    <div class="mb-3"><span class="h3 fw-normal text-accent me-1">$18.<small>99</small></span>
                      <del class="text-muted fs-lg me-3">$25.<small>00</small></del><span class="badge bg-danger badge-shadow align-middle mt-n2">Sale</span>
                    </div>
                    <div class="fs-sm mb-4"><span class="text-heading fw-medium me-1">Color:</span><span class="text-muted" id="colorOptionText">Red/Dark blue/White</span></div>
                    <div class="position-relative me-n4 mb-3">
                      <div class="form-check form-option form-check-inline mb-2">
                        <input class="form-check-input" type="radio" name="color" id="color1" data-bs-label="colorOptionText" value="Red/Dark blue/White" checked>
                        <label class="form-option-label rounded-circle" for="color1"><span class="form-option-color rounded-circle" style="background-image: url(img/shop/single/color-opt-1.png)"></span></label>
                      </div>
                      <div class="form-check form-option form-check-inline mb-2">
                        <input class="form-check-input" type="radio" name="color" id="color2" data-bs-label="colorOptionText" value="Beige/White/Black">
                        <label class="form-option-label rounded-circle" for="color2"><span class="form-option-color rounded-circle" style="background-image: url(img/shop/single/color-opt-2.png)"></span></label>
                      </div>
                      <div class="form-check form-option form-check-inline mb-2">
                        <input class="form-check-input" type="radio" name="color" id="color3" data-bs-label="colorOptionText" value="Dark grey/White/Mustard">
                        <label class="form-option-label rounded-circle" for="color3"><span class="form-option-color rounded-circle" style="background-image: url(img/shop/single/color-opt-3.png)"></span></label>
                      </div>
                      <div class="product-badge product-available mt-n1"><i class="ci-security-check"></i>Product available</div>
                    </div>
                    <form class="mb-grid-gutter">
                      <div class="mb-3">
                        <label class="fw-medium pb-1" for="product-size">Size:</label>
                        <select class="form-select" required id="product-size">
                          <option value="">Select size</option>
                          <option value="xs">XS</option>
                          <option value="s">S</option>
                          <option value="m">M</option>
                          <option value="l">L</option>
                          <option value="xl">XL</option>
                        </select>
                      </div>
                      <div class="mb-3 d-flex align-items-center">
                        <select class="form-select me-3" style="width: 5rem;">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select>
                        <button class="btn btn-primary btn-shadow d-block w-100" type="submit"><i class="ci-cart fs-lg me-2"></i>Add to Cart</button>
                      </div>
                    </form>
                    <h5 class="h6 mb-3 pb-2 border-bottom"><i class="ci-announcement text-muted fs-lg align-middle mt-n1 me-2"></i>Product info</h5>
                    <h6 class="fs-sm mb-2">Style</h6>
                    <ul class="fs-sm ps-4">
                      <li>Hooded top</li>
                    </ul>
                    <h6 class="fs-sm mb-2">Composition</h6>
                    <ul class="fs-sm ps-4">
                      <li>Elastic rib: Cotton 95%, Elastane 5%</li>
                      <li>Lining: Cotton 100%</li>
                      <li>Cotton 80%, Polyester 20%</li>
                    </ul>
                    <h6 class="fs-sm mb-2">Art. No.</h6>
                    <ul class="fs-sm ps-4 mb-0">
                      <li>183260098</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Navbar 3 Level (Light)-->
      <header class="shadow-sm">
        <!-- Topbar-->
        <div class="topbar topbar-dark bg-dark">
          <div class="container">
            <div class="topbar-text dropdown d-md-none"><a class="topbar-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Useful links</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="tel:00331697720"><i class="ci-support text-muted me-2"></i>(00) 33 169 7720</a></li>
                <li><a class="dropdown-item" href="order-tracking.html"><i class="ci-location text-muted me-2"></i>Order tracking</a></li>
              </ul>
            </div>
            <div class="topbar-text text-nowrap d-none d-md-inline-block"><i class="ci-support"></i><span class="text-muted me-1">Support</span><a class="topbar-link" href="tel:00331697720">(00) 33 169 7720</a></div>
            <div class="tns-carousel tns-controls-static d-none d-md-block">
              <div class="tns-carousel-inner" data-carousel-options="{&quot;mode&quot;: &quot;gallery&quot;, &quot;nav&quot;: false}">
                <div class="topbar-text">Free shipping for order over $200</div>
                <div class="topbar-text">We return money within 30 days</div>
                <div class="topbar-text">Friendly 24/7 customer support</div>
              </div>
            </div>
            <div class="ms-3 text-nowrap"><a class="topbar-link me-4 d-none d-md-inline-block" href="order-tracking.html"><i class="ci-location"></i>Order tracking</a>
              <div class="topbar-text dropdown disable-autohide"><a class="topbar-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><img class="me-2" src="img/flags/en.png" width="20" alt="English">Eng / $</a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li class="dropdown-item">
                    <select class="form-select form-select-sm">
                      <option value="usd">$ USD</option>
                      <option value="eur">€ EUR</option>
                      <option value="ukp">£ UKP</option>
                      <option value="jpy">¥ JPY</option>
                    </select>
                  </li>
                  <li><a class="dropdown-item pb-1" href="#"><img class="me-2" src="img/flags/fr.png" width="20" alt="Français">Français</a></li>
                  <li><a class="dropdown-item pb-1" href="#"><img class="me-2" src="img/flags/de.png" width="20" alt="Deutsch">Deutsch</a></li>
                  <li><a class="dropdown-item" href="#"><img class="me-2" src="img/flags/it.png" width="20" alt="Italiano">Italiano</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- Remove "navbar-sticky" class to make navigation bar scrollable with the page.-->
        <div class="navbar-sticky bg-light">
          <div class="navbar navbar-expand-lg navbar-light">
            <div class="container"><a class="navbar-brand d-none d-sm-block flex-shrink-0" href="<?= url('index.php') ?>><img src="img/logo-dark.png" width="142" alt="Cartzilla"></a><a class="navbar-brand d-sm-none flex-shrink-0 me-2" href="index-2.html"><img src="img/logo-icon.png" width="74" alt="Cartzilla"></a>
              <div class="input-group d-none d-lg-flex mx-4">
                <input class="form-control rounded-end pe-5" type="text" placeholder="Search for products"><i class="ci-search position-absolute top-50 end-0 translate-middle-y text-muted fs-base me-3"></i>
              </div>
              <div class="navbar-toolbar d-flex flex-shrink-0 align-items-center">
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"><span class="navbar-toggler-icon"></span></button>
  <a class="navbar-tool navbar-stuck-toggler" href="#"><span class="navbar-tool-tooltip">Expand menu</span>
    <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-menu"></i></div>
  </a>
  <a class="navbar-tool d-none d-lg-flex" href="account-wishlist.html"><span class="navbar-tool-tooltip">Wishlist</span>
    <div class="navbar-tool-icon-box"><i class="navbar-tool-icon ci-heart"></i></div>
  </a>
  <?php if (isUserLoggedIn()): ?>
  <div class="navbar-tool-text ms-n3">
    <small>Hello,</small> <?= htmlspecialchars($_SESSION['first_name']) ?>
    <a href="account_orders.php">My Account</a>
  </div>
<?php else: ?>
  <div class="navbar-tool-text ms-n3" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#loginModal">
    <small>Hello,</small> Goin
  </div>
<?php endif; ?>


  <div class="navbar-tool dropdown ms-3">
    <a class="navbar-tool-icon-box bg-secondary dropdown-toggle" href="shop-cart.html">
      <span class="navbar-tool-label"><?= $cart_count ?></span>
      <i class="navbar-tool-icon ci-cart"></i>
    </a>
<a class="navbar-tool-text" href="cart.php">
    <small>My Cart (<?= $cart_count; ?>)</small>
    $<?= number_format($cart_total, 2); ?>
</a>
    <!-- Cart dropdown-->

                  <div class="dropdown-menu dropdown-menu-end">
                    <div class="widget widget-cart px-3 pt-2 pb-3" style="width: 20rem;">
                      <div style="height: 15rem;" data-simplebar data-simplebar-auto-hide="false">
                       <?php foreach ($cart_items as $key => $value): ?>
    <div class="widget-cart-item pb-2 border-bottom">
    <!-- Remove Button -->
    <form action="cart-process-remove.php" method="post" style="display:inline;">
        <input type="hidden" name="id" value="<?php echo $value['id']; ?>">
        <button class="btn-close text-danger" type="submit" aria-label="Remove">
            <span aria-hidden="true">&times;</span>
        </button>
    </form>

    <div class="d-flex align-items-center">
        <a class="flex-shrink-0" href="product.php?id=<?php echo $value['id']; ?>">
            <?php
            // Decode photos JSON
            $photos = json_decode($value['photos'], true);
            $photo_url = isset($photos[0]) ? $photos[0] : 'img/default.jpg';
            ?>
            <img src="<?php echo $photo_url; ?>" width="64" alt="<?php echo htmlspecialchars($value['name']); ?>">
        </a>
        <div class="ps-2">
            <h6 class="widget-product-title">
                <a href="shop-single-v1.php?id=<?php echo $value['id']; ?>">
                    <?php echo htmlspecialchars($value['name']); ?>
                </a>
            </h6>
            <div class="widget-product-meta">
                <span class="text-accent me-2">$<?php echo number_format($value['price'], 2); ?></span>
                <span class="text-muted">x <?php echo $value['quantity']; ?></span>
            </div>
        </div>
    </div>
</div>

<?php endforeach; ?>


</div><a class="btn btn-outline-secondary btn-sm" href="cart-display.php">Expand cart<i class="ci-arrow-right ms-1 me-n1"></i></a>
                      </div><a class="btn btn-primary btn-sm d-block w-100" href="checkout.php"><i class="ci-card me-2 fs-base align-middle"></i>Checkout</a>
                    </div>                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="navbar navbar-expand-lg navbar-light navbar-stuck-menu mt-n2 pt-0 pb-2">
            <div class="container">
              <div class="collapse navbar-collapse" id="navbarCollapse">
                <!-- Search-->
                <div class="input-group d-lg-none my-3"><i class="ci-search position-absolute top-50 start-0 translate-middle-y text-muted fs-base ms-3"></i>
                  <input class="form-control rounded-start" type="text" placeholder="Search for products">
                </div>
                <!-- Departments menu-->
                <ul class="navbar-nav navbar-mega-nav pe-lg-2 me-lg-2">
                  <li class="nav-item dropdown"><a class="nav-link dropdown-toggle ps-lg-0" href="#" data-bs-toggle="dropdown"><i class="ci-view-grid me-2"></i>Departments</a>
                    <div class="dropdown-menu px-2 pb-4">
                      <div class="d-flex flex-wrap flex-sm-nowrap">
                        <div class="mega-dropdown-column pt-3 pt-sm-4 px-2 px-lg-3">
                          <div class="widget widget-links"><a class="d-block overflow-hidden rounded-3 mb-3" href="#"><img src="img/shop/departments/01.jpg" alt="Clothing"></a>
                            <h6 class="fs-base mb-2">Clothing</h6>
                            <ul class="widget-list">
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Women's clothing</a></li>
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Men's clothing</a></li>
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Kid's clothing</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="mega-dropdown-column pt-4 px-2 px-lg-3">
                          <div class="widget widget-links"><a class="d-block overflow-hidden rounded-3 mb-3" href="#"><img src="img/shop/departments/02.jpg" alt="Shoes"></a>
                            <h6 class="fs-base mb-2">Shoes</h6>
                            <ul class="widget-list">
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Women's shoes</a></li>
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Men's shoes</a></li>
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Kid's shoes</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="mega-dropdown-column pt-4 px-2 px-lg-3">
                          <div class="widget widget-links"><a class="d-block overflow-hidden rounded-3 mb-3" href="#"><img src="img/shop/departments/03.jpg" alt="Gadgets"></a>
                            <h6 class="fs-base mb-2">Gadgets</h6>
                            <ul class="widget-list">
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Smartphones &amp; Tablets</a></li>
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Wearable gadgets</a></li>
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">E-book readers</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="d-flex flex-wrap flex-sm-nowrap">
                        <div class="mega-dropdown-column pt-4 px-2 px-lg-3">
                          <div class="widget widget-links"><a class="d-block overflow-hidden rounded-3 mb-3" href="#"><img src="img/shop/departments/04.jpg" alt="Furniture"></a>
                            <h6 class="fs-base mb-2">Furniture &amp; Decor</h6>
                            <ul class="widget-list">
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Home furniture</a></li>
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Office furniture</a></li>
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Lighting and decoration</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="mega-dropdown-column pt-4 px-2 px-lg-3">
                          <div class="widget widget-links"><a class="d-block overflow-hidden rounded-3 mb-3" href="#"><img src="img/shop/departments/05.jpg" alt="Accessories"></a>
                            <h6 class="fs-base mb-2">Accessories</h6>
                            <ul class="widget-list">
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Hats</a></li>
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Sunglasses</a></li>
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Bags</a></li>
                            </ul>
                          </div>
                        </div>
                        <div class="mega-dropdown-column pt-4 px-2 px-lg-3">
                          <div class="widget widget-links"><a class="d-block overflow-hidden rounded-3 mb-3" href="#"><img src="img/shop/departments/06.jpg" alt="Entertainment"></a>
                            <h6 class="fs-base mb-2">Entertainment</h6>
                            <ul class="widget-list">
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Kid's toys</a></li>
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Video games</a></li>
                              <li class="widget-list-item mb-1"><a class="widget-list-link" href="#">Outdoor / Camping</a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
                <!-- Primary menu-->
                <ul class="navbar-nav">
                  <li class="nav-item dropdown active"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Home</a>
                    <ul class="dropdown-menu">
                      <li class="dropdown position-static mb-0"><a class="dropdown-item border-bottom py-2" href="home-nft.html"><span class="d-block text-heading">NFT Marketplace<span class="badge bg-danger ms-1">NEW</span></span><small class="d-block text-muted">NFTs, Multi-vendor, Auctions</small></a>
                        <div class="dropdown-menu h-100 animation-none mt-0 p-3"><a class="d-block" href="home-nft.html" style="width: 250px;"><img src="img/home/preview/th08.jpg" alt="NFT Marketplace"></a></div>
                      </li>
                      <li class="dropdown position-static mb-0"><a class="dropdown-item py-2 border-bottom" href="home-fashion-store-v1.html"><span class="d-block text-heading">Fashion Store v.1</span><small class="d-block text-muted">Classic shop layout</small></a>
                        <div class="dropdown-menu h-100 animation-none mt-0 p-3"><a class="d-block" href="home-fashion-store-v1.html" style="width: 250px;"><img src="img/home/preview/th01.jpg" alt="Fashion Store v.1"></a></div>
                      </li>
                      <li class="dropdown position-static mb-0"><a class="dropdown-item py-2 border-bottom" href="home-electronics-store.html"><span class="d-block text-heading">Electronics Store</span><small class="d-block text-muted">Slider + Promo banners</small></a>
                        <div class="dropdown-menu h-100 animation-none mt-0 p-3"><a class="d-block" href="home-electronics-store.html" style="width: 250px;"><img src="img/home/preview/th03.jpg" alt="Electronics Store"></a></div>
                      </li>
                      <li class="dropdown position-static mb-0"><a class="dropdown-item py-2 border-bottom" href="home-marketplace.html"><span class="d-block text-heading">Marketplace</span><small class="d-block text-muted">Multi-vendor, digital goods</small></a>
                        <div class="dropdown-menu h-100 animation-none mt-0 p-3"><a class="d-block" href="home-marketplace.html" style="width: 250px;"><img src="img/home/preview/th04.jpg" alt="Marketplace"></a></div>
                      </li>
                      <li class="dropdown position-static mb-0"><a class="dropdown-item py-2 border-bottom" href="home-grocery-store.html"><span class="d-block text-heading">Grocery Store</span><small class="d-block text-muted">Full width + Side menu</small></a>
                        <div class="dropdown-menu h-100 animation-none mt-0 p-3"><a class="d-block" href="home-grocery-store.html" style="width: 250px;"><img src="img/home/preview/th06.jpg" alt="Grocery Store"></a></div>
                      </li>
                      <li class="dropdown position-static mb-0"><a class="dropdown-item py-2 border-bottom" href="home-food-delivery.html"><span class="d-block text-heading">Food Delivery Service</span><small class="d-block text-muted">Food &amp; Beverages delivery</small></a>
                        <div class="dropdown-menu h-100 animation-none mt-0 p-3"><a class="d-block" href="home-food-delivery.html" style="width: 250px;"><img src="img/home/preview/th07.jpg" alt="Food Delivery Service"></a></div>
                      </li>
                      <li class="dropdown position-static mb-0"><a class="dropdown-item py-2 border-bottom" href="home-fashion-store-v2.html"><span class="d-block text-heading">Fashion Store v.2</span><small class="d-block text-muted">Slider + Featured categories</small></a>
                        <div class="dropdown-menu h-100 animation-none mt-0 p-3"><a class="d-block" href="home-fashion-store-v2.html" style="width: 250px;"><img src="img/home/preview/th02.jpg" alt="Fashion Store v.2"></a></div>
                      </li>
                      <li class="dropdown position-static mb-0"><a class="dropdown-item py-2" href="home-single-store.html"><span class="d-block text-heading">Single Product Store</span><small class="d-block text-muted">Single product / mono brand</small></a>
                        <div class="dropdown-menu h-100 animation-none mt-0 p-3"><a class="d-block" href="home-single-store.html" style="width: 250px;"><img src="img/home/preview/th05.jpg" alt="Single Product / Brand Store"></a></div>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item "><a class="nav-link " href="shop.php" >Shop</a>
                    
                  </li>
                  <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Account</a>
                    <ul class="dropdown-menu">
                      <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Shop User Account</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="account-orders.html">Orders History</a></li>
                          <li><a class="dropdown-item" href="account-profile.html">Profile Settings</a></li>
                          <li><a class="dropdown-item" href="account-address.html">Account Addresses</a></li>
                          <li><a class="dropdown-item" href="account-payment.html">Payment Methods</a></li>
                          <li><a class="dropdown-item" href="account-wishlist.html">Wishlist</a></li>
                          <li><a class="dropdown-item" href="account-tickets.html">My Tickets</a></li>
                          <li><a class="dropdown-item" href="account-single-ticket.html">Single Ticket</a></li>
                        </ul>
                      </li>
                      <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Vendor Dashboard</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="dashboard-settings.html">Settings</a></li>
                          <li><a class="dropdown-item" href="dashboard-purchases.html">Purchases</a></li>
                          <li><a class="dropdown-item" href="dashboard-favorites.html">Favorites</a></li>
                          <li><a class="dropdown-item" href="dashboard-sales.html">Sales</a></li>
                          <li><a class="dropdown-item" href="dashboard-products.html">Products</a></li>
                          <li><a class="dropdown-item" href="dashboard-add-new-product.html">Add New Product</a></li>
                          <li><a class="dropdown-item" href="dashboard-payouts.html">Payouts</a></li>
                        </ul>
                      </li>
                      <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">NFT Marketplace<span class="badge bg-danger ms-1">NEW</span></a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="nft-account-settings.html">Profile Settings</a></li>
                          <li><a class="dropdown-item" href="nft-account-payouts.html">Wallet &amp; Payouts</a></li>
                          <li><a class="dropdown-item" href="nft-account-my-items.html">My Items</a></li>
                          <li><a class="dropdown-item" href="nft-account-my-collections.html">My Collections</a></li>
                          <li><a class="dropdown-item" href="nft-account-favorites.html">Favorites</a></li>
                          <li><a class="dropdown-item" href="nft-account-notifications.html">Notifications</a></li>
                        </ul>
                      </li>
                      <li><a class="dropdown-item" href="login">Sign In / Sign Up</a></li>
                      <li><a class="dropdown-item" href="account-password-recovery.html">Password Recovery</a></li>
                    </ul>
                  </li>
                  <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Pages</a>
                    <ul class="dropdown-menu">
                      <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Navbar Variants</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="navbar-1-level-light.html">1 Level Light</a></li>
                          <li><a class="dropdown-item" href="navbar-1-level-dark.html">1 Level Dark</a></li>
                          <li><a class="dropdown-item" href="navbar-2-level-light.html">2 Level Light</a></li>
                          <li><a class="dropdown-item" href="navbar-2-level-dark.html">2 Level Dark</a></li>
                          <li><a class="dropdown-item" href="navbar-3-level-light.html">3 Level Light</a></li>
                          <li><a class="dropdown-item" href="navbar-3-level-dark.html">3 Level Dark</a></li>
                          <li><a class="dropdown-item" href="home-electronics-store.html">Electronics Store</a></li>
                          <li><a class="dropdown-item" href="home-marketplace.html">Marketplace</a></li>
                          <li><a class="dropdown-item" href="home-grocery-store.html">Side Menu (Grocery)</a></li>
                        </ul>
                      </li>
                      <li class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="about.html">About Us</a></li>
                      <li><a class="dropdown-item" href="contacts.html">Contacts</a></li>
                      <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Help Center</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="help-topics.html">Help Topics</a></li>
                          <li><a class="dropdown-item" href="help-single-topic.html">Single Topic</a></li>
                          <li><a class="dropdown-item" href="help-submit-request.html">Submit a Request</a></li>
                        </ul>
                      </li>
                      <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">404 Not Found</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="404-simple.html">404 - Simple Text</a></li>
                          <li><a class="dropdown-item" href="404-illustration.html">404 - Illustration</a></li>
                        </ul>
                      </li>
                      <li class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="sticky-footer.html">Sticky Footer Demo</a></li>
                    </ul>
                  </li>
                  <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Blog</a>
                    <ul class="dropdown-menu">
                      <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Blog List Layouts</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="blog-list-sidebar.html">List with Sidebar</a></li>
                          <li><a class="dropdown-item" href="blog-list.html">List no Sidebar</a></li>
                        </ul>
                      </li>
                      <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Blog Grid Layouts</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="blog-grid-sidebar.html">Grid with Sidebar</a></li>
                          <li><a class="dropdown-item" href="blog-grid.html">Grid no Sidebar</a></li>
                        </ul>
                      </li>
                      <li class="dropdown"><a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Single Post Layouts</a>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item" href="blog-single-sidebar.html">Article with Sidebar</a></li>
                          <li><a class="dropdown-item" href="blog-single.html">Article no Sidebar</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Docs / Components</a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="docs/dev-setup.html">
                          <div class="d-flex">
                            <div class="lead text-muted pt-1"><i class="ci-book"></i></div>
                            <div class="ms-2"><span class="d-block text-heading">Documentation</span><small class="d-block text-muted">Kick-start customization</small></div>
                          </div></a></li>
                      <li class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="components/typography.html">
                          <div class="d-flex">
                            <div class="lead text-muted pt-1"><i class="ci-server"></i></div>
                            <div class="ms-2"><span class="d-block text-heading">Components<span class="badge bg-info ms-2">40+</span></span><small class="d-block text-muted">Faster page building</small></div>
                          </div></a></li>
                      <li class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="docs/changelog.html">
                          <div class="d-flex">
                            <div class="lead text-muted pt-1"><i class="ci-edit"></i></div>
                            <div class="ms-2"><span class="d-block text-heading">Changelog<span class="badge bg-success ms-2">v2.5.1</span></span><small class="d-block text-muted">Regular updates</small></div>
                          </div></a></li>
                      <li class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="mailto:support@createx.studio">
                          <div class="d-flex">
                            <div class="lead text-muted pt-1"><i class="ci-help"></i></div>
                            <div class="ms-2"><span class="d-block text-heading">Support</span><small class="d-block text-muted">support@createx.studio</small></div>
                          </div></a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </header>