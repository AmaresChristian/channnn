<?php
require_once '../config.php';
include '../assets/navbar.php';

// Fetch categories & brands for filters
$categories = $conn->query("SELECT * FROM categories");
$brands = $conn->query("SELECT * FROM brands");

// Fetch bikes with optional filters
$whereClause = [];
if (isset($_GET['category']) && $_GET['category'] != '') {
    $whereClause[] = "b.category_id = " . intval($_GET['category']);
}
if (isset($_GET['brand']) && $_GET['brand'] != '') {
    $whereClause[] = "b.brand_id = " . intval($_GET['brand']);
}
$whereSQL = !empty($whereClause) ? 'WHERE ' . implode(' AND ', $whereClause) : '';

$query = "SELECT b.*, c.name AS category_name, br.name AS brand_name 
          FROM bikes b 
          JOIN categories c ON b.category_id = c.id 
          JOIN brands br ON b.brand_id = br.id 
          $whereSQL";

$bikes = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Explore Bikes</title>
    <link rel="stylesheet" href="../assets/bootstrap.min.css"><!-- Include in all pages inside <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h2>Explore Available Bikes</h2>
        <hr>

        <!-- Filter Form -->
        <form method="GET" action="bikes.php" class="mb-3">
            <select name="category">
                <option value="">All Categories</option>
                <?php while ($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>" <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
                        <?= $cat['name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <select name="brand">
                <option value="">All Brands</option>
                <?php while ($brand = $brands->fetch_assoc()): ?>
                    <option value="<?= $brand['id'] ?>" <?= (isset($_GET['brand']) && $_GET['brand'] == $brand['id']) ? 'selected' : '' ?>>
                        <?= $brand['name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Filter</button>
        </form>

        <!-- Bike Listings -->
        <div class="row">
    <?php while ($bike = $bikes->fetch_assoc()): ?>
        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <img src="../uploads/<?= $bike['image'] ?>" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title"><?= $bike['name'] ?></h5>
                    <p class="text-muted"><?= $bike['category_name'] ?> | <?= $bike['brand_name'] ?></p>
                    <p class="fw-bold text-success">$<?= $bike['price_per_day'] ?>/day</p>
                    <a href="bike_details.php?id=<?= $bike['id'] ?>" class="btn btn-primary w-100">View Details</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>

    </div>
</body>
</html>
