<?php
require_once('files/functions.php');
protected_area();

$categories = db_select('categories', '1 ORDER BY id DESC');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? null;
    $parent_id = !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : null;

    $uploaded = upload_files('photo', 'uploads/');
    $photo_path = '';

    if (!empty($uploaded[0])) {
        $original_path = $uploaded[0];
        $compressed_path = str_replace('uploads/', 'uploads/compressed_', $original_path);

        if (compress_image($original_path, $compressed_path, 600, 80)) {
            $photo_path = $compressed_path;
           
        } else {
            $photo_path = $original_path; // fallback
        }
    }

    if (!empty($name) && !empty($photo_path)) {
        $stmt = $conn->prepare("INSERT INTO categories (name, photo, parent_id, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $name, $photo_path, $parent_id, $description);
        $stmt->execute();
        $stmt->close();


        unset($_SESSION['form']); // Clear form memory

        $_SESSION['success'] = "Category added successfully.";
    } else {
        $_SESSION['error'] = "Name and photo are required.";
    }

    header("Location: account_orders.php");
    exit;
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
      <h1 class="h3 text-light mb-0">Product Categories</h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <?php require_once('files/account-sidebar.php');?>

    <!-- Content -->
    <section class="col-lg-8 pt-lg-4 pb-4 mb-3">
      <div class="pt-2 px-4 ps-lg-0 pe-xl-5">
        <div class="d-sm-flex flex-wrap justify-content-between align-items-center pb-2">
          <h2 class="h3 py-2 me-2 text-center text-sm-start">Add New Category</h2>
        </div>

       <form action="admin-categories-add.php" method="POST" enctype="multipart/form-data">
  <div class="mb-3 pb-2">
    <?= text_input([
      'name' => 'name',
      'label' => 'Category Name'
    ]) ?>

    <div class="form-group mt-3">
      <label for="photo">Category image</label>
      <input class="form-control" name="photo[]" type="file" accept=".jpg,.jpeg,.png">
    </div>

    

    <div class="form-group mt-3">
 <?= select_input([
  'name' => 'parent_id',
  'label' => 'Parent Category (optional)',
  'options' => array_column($all_categories, 'name', 'id')  // ['id' => 'name']
]) ?>

</div>
<div class="form-group mt-3">
      <label for="description">Description</label>
      <textarea class="form-control" name="description" rows="3" placeholder="Write a short category description..."></textarea>
    </div>

    <div class="form-text">Maximum 100 characters. No HTML or emoji allowed.</div>
  </div>

  <div class="row">
    <div class="col-12">
      <button class="btn btn-primary d-block w-100" type="submit">
        <i class="ci-cloud-upload fs-lg me-2"></i>Upload Category
      </button>
    </div>
  </div>
</form>

      </div>
    </section>
  </div>
</div>

<?php require_once('files/footer.php'); ?>
