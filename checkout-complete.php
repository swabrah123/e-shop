<?php
session_start();
require_once('files/header.php');
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger text-center" role="alert">'
         . $_SESSION['error_message'] .
         '</div>';
    unset($_SESSION['error_message']); 
}
?>
 <div class="container pb-5 mb-sm-4">
        <div class="pt-5">
          <div class="card py-3 mt-sm-3">
            <div class="card-body text-center">
              <h2 class="h4 pb-3">Thank you for your order!</h2>
              <p class="fs-sm mb-2">Your order has been placed and will be processed as soon as possible.</p>
              <p class="fs-sm mb-2">Make sure you make note of your order number, which is <span class='fw-medium'>07233444412.</span></p>
              <p class="fs-sm">You will be receiving an email shortly with confirmation of your order. 
                <u>You can now:</u></p><a class="btn btn-secondary mt-3 me-3" href="shop.php">Go to shopping</a><a class="btn btn-primary mt-3" href="account_orders.php"><i class="ci-location"></i>Back to Orders</a>
            </div>
          </div>
        </div>
      </div>


<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>




<?php require_once('files/footer.php'); ?>
