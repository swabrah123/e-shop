<?php
require_once('files/functions.php');
protected_area();

$categories = db_select('categories', '1 ORDER BY id DESC');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : null;
    $buying_price = floatval($_POST['buying_price'] ?? 0);
    $selling_price = floatval($_POST['selling_price'] ?? 0);
    $description = $_POST['description'] ?? null;

    $photos = upload_files('photos', 'uploads/');
    $compressed_photos = [];

    foreach ($photos as $photo_path) {
        $compressed = str_replace('uploads/', 'uploads/compressed_', $photo_path);
        if (compress_image($photo_path, $compressed, 600, 80)) {
            $compressed_photos[] = $compressed;
        } else {
            $compressed_photos[] = $photo_path; // fallback
        }
    }

    if (!empty($name) && !empty($compressed_photos)) {
        $photos_json = json_encode($compressed_photos);

        $stmt = $conn->prepare("INSERT INTO products (name, category_id, buying_price, selling_price, description, photos) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siddss", $name, $category_id, $buying_price, $selling_price, $description, $photos_json);
        $stmt->execute();
        $stmt->close();

        unset($_SESSION['form']);
        $_SESSION['success'] = "Product added successfully.";

        header("Location: admin-products.php");
        exit;
    } else {
        $_SESSION['error'] = "Product name and at least one photo are required.";
        $_SESSION['form'] = $_POST;

        header("Location: admin-products-add.php");
        exit;
    }
}


require_once('files/header.php');

// Fetch existing categories
$all_categories = [];
$result = $conn->query("SELECT id, name FROM categories ORDER BY name ASC");
while ($row = $result->fetch_assoc()) {
    $all_categories[] = $row;
}

?>

<!-- Page Title-->
<div class="page-title-overlap bg-dark pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-light flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="index.php"><i class="ci-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap"><a href="#">Account</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page">Categories</li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pe-lg-4 text-center text-lg-start">
      <h1 class="h3 text-light mb-0">Product add</h1>
    </div>
  </div>
  
</div>


<div class="container pb-5 mb-2 mb-md-4">
  <!-- Title-->
                <div class="d-sm-flex flex-wrap justify-content-between align-items-center border-bottom">
                  <h2 class="h3 py-2 me-2 text-center text-sm-start">Your products<span class="badge bg-faded-accent fs-sm text-body align-middle ms-2">5</span></h2>
                  <div class="py-2">
                    <div class="d-flex flex-nowrap align-items-center pb-3">
                    <label class="form-label fw-normal text-nowrap mb-0 me-2" for="parent_id">Categories</label>
<?= select_input([
  'name' => 'parent_id',
  'label' => 'Categories',
  'options' => array_column($all_categories, 'name', 'id'),
  'placeholder' => 'Add Category'
]) ?>


                      <button class="btn btn-outline-secondary btn-sm px-2" type="button"><i class="ci-arrow-up"></i></button>
                    </div>
                  </div>
                </div>
  <div class="row">
    <?php require_once('files/account-sidebar.php');?>

    <!-- Content -->
    <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
      <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
        <div class="d-sm-flex flex-wrap justify-content-between align-items-center pb-2">
          <h2 class="h3 py-2 me-2 text-center text-sm-start">Add New Category</h2>
        </div>

       <form action="admin-products-add.php" method="POST" enctype="multipart/form-data">
  <div class="mb-3 pb-2">

    <?= text_input([
      'name' => 'name',
      'label' => 'Product Name'
    ]) ?>

    <div class="row">
  <div class="col-md-6">
    <?= text_input([
      'name' => 'buying_price',
      'label' => 'Buying Price'
    ]) ?>
  </div>
  <div class="col-md-6">
    <?= text_input([
      'name' => 'selling_price',
      'label' => 'Selling Price'
    ]) ?>
  </div>
</div>

    <!-- Category Select -->
    <div class="form-group mt-3">
      <?= select_input([
        'name' => 'category_id',
        'label' => 'Category',
        'options' => array_column($all_categories, 'name', 'id'),
        'placeholder' => '--- Select Category ---'
      ]) ?>
    </div>

    <!-- Upload 6 Product Photos -->
   <div class="form-group mt-3">
  <label class="form-label" for="photos">Product Images (max 6)</label>
  <input class="form-control" id="photos" name="photos[]" type="file" accept=".jpg,.jpeg,.png" multiple>
  <small class="form-text text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple files. Max 6 files allowed.</small>
</div>


    <!-- Product Description -->
    <div class="form-group mt-3">
      <label for="description">Description</label>
      <textarea class="form-control" name="description" rows="3" placeholder="Write a short product description..."></textarea>
    </div>

    <div class="form-text">Please fill in all required fields.</div>
  </div>

  <div class="row">
    <div class="col-12">
      <button class="btn btn-primary d-block w-100" type="submit">
        <i class="ci-cloud-upload fs-lg me-2"></i>Upload Product
      </button>
    </div>
  </div>
</form>


      </div>
    </section>
  </div>
</div>

<?php require_once('files/footer.php'); ?>
