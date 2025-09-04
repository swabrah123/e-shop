<?php
// Start session once safely

use stefangabos\Zebra_Image\Zebra_Image;

if (session_status() === PHP_SESSION_NONE) {
    session_start();

 
} 

define('BASE_URL', 'http://localhost/e-shop/');


function url($path = '/') {
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}



// DB connection
$conn = new mysqli("localhost", "root", "", "e_store_recover");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Check if user is logged in
function isUserLoggedIn(): bool {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Log in user
function loginUser(array $user): void {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['last_name'] = $user['last_name'];
    $_SESSION['email'] = $user['email'];
}

// Check if email exists
function emailExists(string $email): bool {
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

function protected_area() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error_message'] = "You must be logged in to access this page.";
        header("Location: login.php");
        exit(); 
    }
}


function logout_user() {
    if (isset($_SESSION['user_id'])) {
        unset($_SESSION['user_id']);
    }
    header("Location: login.php");
    exit();
}

function text_input($data) {
    $value = "";
    $error = "";
    $extras = "";

    if (isset($_SESSION['form'])) {
        if (isset($_SESSION['form'][$data['name']])) {
            $value = htmlspecialchars($_SESSION['form'][$data['name']]);
        }
    }

    $name = isset($data['name']) ? htmlspecialchars($data['name']) : '';
    $label = isset($data['label']) ? htmlspecialchars($data['label']) : $name;

    if (isset($data['value'])) {
        if ($value === "") {
            $value = htmlspecialchars($data['value']);
        }
    }

    if (isset($_SESSION['errors'])) {
        if (isset($_SESSION['errors'][$data['name']])) {
            $error = '<div class="form-text text-danger">' . htmlspecialchars($_SESSION['errors'][$data['name']]) . '</div>';
        }
    }

    if (isset($data['attr'])) {
        foreach ($data['attr'] as $key => $val) {
            $extras .= $key . '="' . htmlspecialchars($val) . '" ';
        }
    }

    return
        '<label class="form-label text-capitalize" for="' . $name . '">' . $label . '</label>' .
        '<input value="' . $value . '" class="form-control" type="text" name="' . $name . '" placeholder="' . $name . '" id="' . $name . '" ' . $extras . '>' .
        $error;
}
function upload_files($input_name, $upload_dir = 'uploads/') {
    $uploaded_files = [];

    // Check if input exists and has at least one file
    if (!isset($_FILES[$input_name]) || empty($_FILES[$input_name]['name'][0])) {
        return $uploaded_files; // No files uploaded
    }

    // Make sure the uploads directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $file_count = count($_FILES[$input_name]['name']);

    for ($i = 0; $i < $file_count; $i++) {
        $name     = $_FILES[$input_name]['name'][$i] ?? '';
        $type     = $_FILES[$input_name]['type'][$i] ?? '';
        $tmp_name = $_FILES[$input_name]['tmp_name'][$i] ?? '';
        $error    = $_FILES[$input_name]['error'][$i] ?? UPLOAD_ERR_NO_FILE;
        $size     = $_FILES[$input_name]['size'][$i] ?? 0;

        // Validate the file
        if (
            $error === UPLOAD_ERR_OK &&
            !empty($name) &&
            is_uploaded_file($tmp_name) &&
            $size > 0
        ) {
            $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $unique_name = time() . '_' . uniqid() . '.' . $extension;
            $final_path = rtrim($upload_dir, '/') . '/' . $unique_name;

            // Upload
            if (move_uploaded_file($tmp_name, $final_path)) {
                $uploaded_files[] = $final_path;
            }
        }
    }

    return $uploaded_files;
}


require_once 'files/Zebra_Image.php';

function compress_image($source_path, $target_path, $dimension = 600, $quality = 80) {
    ini_set('memory_limit', '-1'); // unlimited memory
    
    if (!file_exists($source_path)) {
        return false;
    }
    
    $dimension = (int) $dimension;
    if ($dimension <= 0) {
        $dimension = 600;
    }
    
    $image = new Zebra_Image();
    
    $image->source_path = $source_path;
    $image->target_path = $target_path;
    $image->jpeg_quality = $quality;
    $image->preserve_aspect_ratio = false;
    $image->enlarge_smaller_images = true;
    $image->preserve_time = true;
    
    $image->target_width = $dimension;
    $image->target_height = $dimension;
    
    return $image->resize();
}

function insert_into_table($table, $data) {
    global $conn;

    if (!is_array($data) || empty($data)) {
        return false;
    }

    // Build columns and placeholders
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), '?'));

    // Detect value types
    $types = '';
    $values = [];

    foreach ($data as $value) {
        if (is_int($value)) {
            $types .= 'i';
        } elseif (is_float($value)) {
            $types .= 'd';
        } else {
            $types .= 's';
        }
        $values[] = $value;
    }

    // Prepare statement
    $sql = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    // Bind values
    $stmt->bind_param($types, ...$values);

    // Execute
    $success = $stmt->execute();
    $stmt->close();

    return $success;
}

function select_input($data) {
    $name = htmlspecialchars($data['name'] ?? '');
    $label = htmlspecialchars($data['label'] ?? $name);
    $options = $data['options'] ?? [];
    $error = '';
    $extras = '';
    $selected = '';
    $placeholder = htmlspecialchars($data['placeholder'] ?? '-- Select --'); // <-- added

    // Keep selected value from session (after form error)
    if (isset($_SESSION['form'][$name])) {
        $selected = $_SESSION['form'][$name];
    }

    // Handle extra HTML attributes
    if (isset($data['attr'])) {
        foreach ($data['attr'] as $key => $val) {
            $extras .= $key . '="' . htmlspecialchars($val) . '" ';
        }
    }

    // Handle error
    if (isset($_SESSION['errors'][$name])) {
        $error = '<div class="form-text text-danger">' . htmlspecialchars($_SESSION['errors'][$name]) . '</div>';
    }

    $html = '<label class="form-label text-capitalize" for="' . $name . '">' . $label . '</label>';
    $html .= '<select name="' . $name . '" id="' . $name . '" class="form-control" ' . $extras . '>';
    $html .= '<option value="">' . $placeholder . '</option>'; // <-- use custom placeholder

    foreach ($options as $val => $text) {
        $isSelected = $selected == $val ? 'selected' : '';
        $html .= '<option value="' . htmlspecialchars($val) . '" ' . $isSelected . '>' . htmlspecialchars($text) . '</option>';
    }

    $html .= '</select>';
    $html .= $error;

    return $html;
}


function db_select($table, $where = '') {
    global $conn;

    $rows = [];

    // Validate table name to prevent SQL injection
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
        return $rows;
    }

    $sql = "SELECT * FROM `$table`";
    if (!empty($where)) {
        $sql .= " WHERE $where";
    }

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    return $rows;
}

function get_product_photos(array $product): array {
    if (empty($product['photos'])) {
        return [];
    }
    $photos = json_decode($product['photos'], true);
    return is_array($photos) ? $photos : [];
}

function get_category_name($category_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();
    return $name ?? 'Uncategorized';
}

function product_item_ui_1($product) {
    $photos = json_decode($product['photos'], true);
    $main_photo = $photos[0] ?? 'img/default-product.png';

    $price_parts = explode('.', number_format($product['selling_price'], 2));
    $dollars = $price_parts[0];
    $cents = $price_parts[1];

    $category = get_category_name($product['id']);
    $product_id = $product['id'];
    $product_name = htmlspecialchars($product['name']);

    ob_start(); ?>
    
    <div class="col-md-4 col-sm-6 px-2 mb-4">
        <div class="card product-card h-100">
            <button class="btn-wishlist btn-sm" type="button" data-bs-toggle="tooltip" title="Add to wishlist">
                <i class="ci-heart"></i>
            </button>
            <a class="card-img-top d-block overflow-hidden" href="product.php?id=<?= $product_id ?>" 
               style="height: 220px; border-radius: 0.5rem;">
                <img src="<?= htmlspecialchars($main_photo) ?>" alt="<?= $product_name ?>"
                     style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
            </a>
            <div class="card-body py-2 d-flex flex-column">
                <a class="product-meta d-block fs-xs pb-1 text-muted" href="#"><?= htmlspecialchars($category) ?></a>
                <h3 class="product-title fs-sm mb-2">
                    <a href="product.php?id=<?= $product_id ?>"><?= $product_name ?></a>
                </h3>
                <div class="d-flex justify-content-between mt-auto">
                    <div class="product-price">
                        <span class="text-accent">$<?= $dollars; ?><small><?= $cents; ?></small></span>
                    </div>
                    <div class="star-rating">
                        <i class="star-rating-icon ci-star-filled active"></i>
                        <i class="star-rating-icon ci-star-filled active"></i>
                        <i class="star-rating-icon ci-star-filled active"></i>
                        <i class="star-rating-icon ci-star-filled active"></i>
                        <i class="star-rating-icon ci-star"></i>
                    </div>
                </div>
            </div>
            <div class="card-body card-body-hidden">
                <div class="text-center pb-2">
                    <div class="form-check form-option form-check-inline mb-2">
                        <input class="form-check-input" type="radio" name="size<?= $product_id ?>" id="s-80-<?= $product_id ?>" checked>
                        <label class="form-option-label" for="s-80-<?= $product_id ?>">8</label>
                    </div>
                    <div class="form-check form-option form-check-inline mb-2">
                        <input class="form-check-input" type="radio" name="size<?= $product_id ?>" id="s-90-<?= $product_id ?>">
                        <label class="form-option-label" for="s-90-<?= $product_id ?>">9</label>
                    </div>
                </div>
                <button class="btn btn-primary btn-sm d-block w-100 mb-2" type="button">
                    <i class="ci-cart fs-sm me-1"></i>Add to Cart
                </button>
                <div class="text-center">
                    <a class="nav-link-style fs-ms" href="#quick-view" data-bs-toggle="modal">
                        <i class="ci-eye align-middle me-1"></i>Quick view
                    </a>
                </div>
            </div>
        </div>
        <hr class="d-sm-none">
    </div>

    <?php return ob_get_clean();
}
function get_product_with_category($product_id) {
    global $conn;

    $stmt = $conn->prepare("
        SELECT 
            p.id, p.name, p.category_id, p.buying_price, p.selling_price, p.description, p.photos,
            c.name AS category_name,
            c.description AS category_description,
            c.photo AS category_photo
        FROM 
            products p
        LEFT JOIN 
            categories c ON p.category_id = c.id
        WHERE 
            p.id = ?
        LIMIT 1
    ");

    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result && $result->num_rows === 1) {
        return $result->fetch_assoc();
    }

    return null;
}

function get_product_images($product) {
    if (!isset($product['photos']) || empty($product['photos'])) {
        return [];
    }

    // If stored as JSON
    $photos = json_decode($product['photos'], true);

    // Fallback if decoding fails (e.g., it's a comma-separated string)
    if (!is_array($photos)) {
        $photos = explode(',', $product['photos']);
    }

    // Trim spaces from each filename
    return array_map('trim', $photos);
}

// Helper to generate unique IDs for anchors
function image_id($index) {
    $ids = ['first', 'second', 'third', 'fourth'];
    return $ids[$index] ?? 'img' . $index;
}


function products_insert() {
    global $conn; // mysqli connection

    // Fetch all category IDs from the database
    $categoryIds = [];
    $catQuery = $conn->query("SELECT id FROM categories");
    if (!$catQuery) {
        die("Query failed: " . $conn->error);
    }

    while ($row = $catQuery->fetch_assoc()) {
        $categoryIds[] = $row['id'];
    }

    if (empty($categoryIds)) {
        die("No categories found. Add categories first.");
    }

    // Images available in uploads folder (01.jpg, 02.jpg, ... 20.jpg)
    $imageNumbers = range(1, 20);

    // Sample product names to shuffle
    $productNames = [
        "Deluxe Item", "Premium Gadget", "Smart Device", "Fashion Bag", "Trendy Shoes",
        "Luxury Watch", "Modern Chair", "Wireless Headphones", "Gaming Keyboard", "Stylish Jacket",
        "Bluetooth Speaker", "Office Desk", "LED Lamp", "Sports Gear", "Casual Sneakers",
        "Portable Charger", "Fitness Tracker", "Digital Camera", "Coffee Maker", "Electric Kettle"
    ];

    // Insert 20 products
    for ($i = 1; $i <= 20; $i++) {
        shuffle($productNames);
        $name = $productNames[0] . " #" . $i;

        shuffle($categoryIds);
        $category_id = $categoryIds[0];

        shuffle($imageNumbers);
        // Select 3 random images and JSON encode
        $photos = [];
        for ($j = 0; $j < 3; $j++) {
            $img = str_pad($imageNumbers[$j], 2, "0", STR_PAD_LEFT) . ".jpg";
            $photos[] = "uploads/" . $img;
        }
        $photosJson = json_encode($photos);

        $buying_price = rand(10, 100);
        $selling_price = $buying_price + rand(10, 50);
        $description = "This is a demo description for " . $name;

        // Prepare and execute INSERT query
        $stmt = $conn->prepare("
            INSERT INTO products (name, category_id, buying_price, selling_price, description, photos, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("siddss", $name, $category_id, $buying_price, $selling_price, $description, $photosJson);

        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }

        $stmt->close();
    }

    echo "20 demo products generated successfully!";
}

