<?php
require_once('files/functions.php');
protected_area();

$products = db_select('products', '1 ORDER BY id DESC');

require_once('files/header.php');
?>

<!-- Page Title-->
<div class="page-title-overlap bg-dark pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="index-2.html"><i class="ci-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap"><a href="#">Account</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page">Products</li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
      <h1 class="h3 text-light mb-0">Products</h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <?php require_once('files/account-sidebar.php'); ?>

    <!-- Content -->
    <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
      <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
        <!-- Title-->
        <div class="d-sm-flex flex-wrap justify-content-between align-items-center border-bottom">
          <h2 class="h3 py-2 me-2 text-center text-sm-start">
            Your products
            <span class="badge bg-faded-accent fs-sm text-body align-middle ms-2"><?= count($products) ?></span>
          </h2>
          <div class="py-2">
            <div class="d-flex flex-nowrap align-items-center pb-3">
              <label class="form-label fw-normal text-nowrap mb-0 me-2" for="sorting">Sort by:</label>
              <select class="form-select form-select-sm me-2" id="sorting">
                <option>Date Created</option>
                <option>Product Name</option>
                <option>Price</option>
                <option>Your Rating</option>
                <option>Updates</option>
              </select>
              <button class="btn btn-outline-secondary btn-sm px-2" type="button"><i class="ci-arrow-up"></i></button>
            </div>
          </div>
        </div>

        <!-- Product list -->
        <?php if (!empty($products)): ?>
          <?php foreach ($products as $product): ?>
            <?php
              $photos = json_decode($product['photos'], true);
              $main_photo = $photos[0] ?? 'img/default-product.png';
            ?>
            <div class="d-block d-sm-flex align-items-center py-4 border-bottom">
              <a class="d-block mb-3 mb-sm-0 me-sm-4 ms-sm-0 mx-auto" href="#" style="width: 12.5rem; height: 12.5rem; overflow: hidden; border-radius: .5rem;">
                <img
                  src="<?= htmlspecialchars($main_photo) ?>"
                  alt="<?= htmlspecialchars($product['name']) ?>"
                  style="width: 100%; height: 100%; object-fit: cover; object-position: center;"
                >
              </a>

              <div class="text-center text-sm-start">
                <h3 class="h6 product-title mb-2">
                  <a href="#"><?= htmlspecialchars($product['name']) ?></a>
                </h3>

                <?php if (!empty($product['description'])): ?>
                  <p class="mb-2 text-muted"><?= htmlspecialchars($product['description']) ?></p>
                <?php endif; ?>

                <div class="text-muted fs-sm mb-1">
                  Buying Price: <strong><?= number_format($product['buying_price'], 2) ?></strong><br>
                  Selling Price: <strong><?= number_format($product['selling_price'], 2) ?></strong>
                </div>

                <div class="d-inline-block text-muted fs-ms">
                  Created: <span class="fw-medium"><?= date('M d, Y', strtotime($product['created_at'])) ?></span>
                </div>

                <div class="d-flex justify-content-center justify-content-sm-start pt-3">
                  <!-- Download first photo -->
                  <a href="<?= htmlspecialchars($main_photo) ?>" download class="btn bg-faded-accent btn-icon me-2" data-bs-toggle="tooltip" title="Download">
                    <i class="ci-download text-accent"></i>
                  </a>

                  <!-- Edit -->
                  <a href="admin-products-edit.php?id=<?= $product['id'] ?>" class="btn bg-faded-info btn-icon me-2" data-bs-toggle="tooltip" title="Edit">
                    <i class="ci-edit text-info"></i>
                  </a>

                  <!-- Delete -->
                  <a href="admin-products-delete.php?id=<?= $product['id'] ?>" class="btn bg-faded-danger btn-icon" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure you want to delete this product?');">
                    <i class="ci-trash text-danger"></i>
                  </a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="py-4 text-center text-muted">No products found.</div>
        <?php endif; ?>

      </div>
    </section>
  </div>
</div>

<?php
require_once('files/footer.php');
?>
