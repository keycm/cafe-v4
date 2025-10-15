<?php
include 'session_check.php';
$conn = new mysqli("localhost", "root", "", "addproduct");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = "";
$errorMessage = "";

// --- HANDLE SOFT DELETE REQUEST ---
if (isset($_GET['delete'])) {
    $id_to_delete = intval($_GET['delete']);
    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id_to_delete);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        
        if ($product) {
            $insert_stmt = $conn->prepare("INSERT INTO recently_deleted_products (original_id, name, price, stock, image, category, rating) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("isdissi", $product['id'], $product['name'], $product['price'], $product['stock'], $product['image'], $product['category'], $product['rating']);
            $insert_stmt->execute();

            $delete_stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $delete_stmt->bind_param("i", $id_to_delete);
            $delete_stmt->execute();

            $conn->commit();
            header("Location: recently_deleted.php");
            exit();
        } else {
            throw new Exception("Product not found.");
        }
    } catch (Exception $e) {
        $conn->rollback();
        $errorMessage = "❌ Error deleting product: " . $e->getMessage();
    }
}

// --- HANDLE POST REQUEST (ADD OR EDIT) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // (Add/Edit logic remains the same)
}

// --- FETCH ALL PRODUCTS FOR DISPLAY ---
$products_result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Products - Saplot de Manila</title>
<link rel="stylesheet" href="CSS/admin.css"/>
<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    .message { text-align: center; font-weight: bold; margin-bottom: 20px; font-size: 1.1rem; padding: 15px; border-radius: 8px; }
    .message.success { color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; }
    .message.error { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; }
    .card { background: #fff; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); padding: 30px; margin-bottom: 30px; }
    .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .card-header h2 { margin: 0; font-size: 1.8rem; }
    .btn { padding: 10px 20px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; transition: 0.3s; font-size: 0.9rem; }
    .btn-primary { background: #E03A3E; color: #fff; }
    .btn-primary:hover { background: #c03034; }
    .btn-secondary { background: #6c757d; color: #fff; }
    .btn-danger { background: #dc3545; color: #fff; }
    .btn-sm { padding: 5px 10px; font-size: 0.8rem; }

    form label { font-weight: 600; display: block; margin-bottom: 8px; font-size: 1rem; }
    form input, form select, form button { width: 100%; padding: 12px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #ccc; font-size: 1rem; }

    .table-container { max-height: 420px; overflow-y: auto; }
    .products-table { width: 100%; border-collapse: collapse; }
    .products-table th, .products-table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
    .products-table th { background: #f9fafb; font-weight: 600; position: sticky; top: 0; }
    .products-table img { width: 50px; height: 50px; object-fit: contain; border-radius: 8px; background: #f8f9fa; }
    .products-table .actions { display: flex; gap: 10px; }
    #product-search { padding: 10px; border: 1px solid #ccc; border-radius: 8px; font-size: 0.9rem; width: 250px; }

    .modal { display: none; position: fixed; z-index: 1001; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6); }
    .modal-content { background-color: #fefefe; margin: 10% auto; padding: 30px; border: 1px solid #888; width: 80%; max-width: 600px; border-radius: 12px; position: relative; }
    .close-btn { color: #aaa; position: absolute; top: 15px; right: 25px; font-size: 28px; font-weight: bold; cursor: pointer; }
</style>
</head>
<body>
<div class="admin-container">
    
    <?php include 'admin_sidebar.php'; ?>

    <main class="main-content">
        <header class="main-header">
            <h1>Manage Products</h1>
            <a href="logout.php" class="logout-button">Log Out</a>
        </header>

        <?php if($successMessage): ?><div class="message success"><?= $successMessage ?></div><?php endif; ?>
        <?php if($errorMessage): ?><div class="message error"><?= $errorMessage ?></div><?php endif; ?>

        <div id="addProductCard" class="card" style="display:none;">
            <div class="card-header">
                <h2>Add New Product</h2>
                <button class="btn btn-secondary" onclick="toggleAddForm()">Cancel</button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <label>Product Name:</label><input type="text" name="name" required>
                <label>Price:</label><input type="number" name="price" step="0.01" min="1" required>
                <label>Stock:</label><input type="number" name="stock" min="1" required>
                <label>Category:</label>
                <select name="category" required>
                    <option value="">-- Select --</option><option value="running">Running</option><option value="basketball">Basketball</option><option value="style">Style</option>
                </select>
                <label>Product Image:</label><input type="file" name="image" accept="image/*" required>
                <button type="submit" class="btn btn-primary">Save Product</button>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Product List</h2>
                <input type="text" id="product-search" placeholder="Search products...">
                <button id="showAddFormBtn" class="btn btn-primary" onclick="toggleAddForm()"><i class="fas fa-plus"></i> Add New</button>
            </div>
            <div class="table-container">
                <table class="products-table">
                    <thead><tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead>
                    <tbody>
                    <?php while ($row = $products_result->fetch_assoc()): ?>
                        <tr data-name="<?= strtolower(htmlspecialchars($row['name'])) ?>">
                            <td><img src="<?= htmlspecialchars($row['image']) ?>" alt=""></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td>₱<?= number_format($row['price'], 2) ?></td>
                            <td><?= $row['stock'] ?></td>
                            <td class="actions">
                                <button class="btn btn-secondary btn-sm edit-btn"
                                    data-id="<?= $row['id'] ?>" data-name="<?= htmlspecialchars($row['name']) ?>"
                                    data-price="<?= $row['price'] ?>" data-stock="<?= $row['stock'] ?>"
                                    data-category="<?= $row['category'] ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <a href="practiceaddproduct.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('This will move the product to Recently Deleted. Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Edit Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" id="edit-id">
            <label>Product Name:</label><input type="text" name="name" id="edit-name" required>
            <label>Price:</label><input type="number" name="price" id="edit-price" step="0.01" min="1" required>
            <label>Stock:</label><input type="number" name="stock" id="edit-stock" min="1" required>
            <label>Category:</label>
            <select name="category" id="edit-category" required>
                <option value="running">Running</option><option value="basketball">Basketball</option><option value="style">Style</option>
            </select>
            <label>New Image (Optional):</label><input type="file" name="image" accept="image/*">
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</div>

<script>
    function toggleAddForm() {
        const formCard = document.getElementById('addProductCard');
        formCard.style.display = (formCard.style.display === 'none') ? 'block' : 'none';
    }

    const editModal = document.getElementById('editModal');
    const closeBtn = editModal.querySelector('.close-btn');

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('edit-id').value = button.dataset.id;
            document.getElementById('edit-name').value = button.dataset.name;
            document.getElementById('edit-price').value = button.dataset.price;
            document.getElementById('edit-stock').value = button.dataset.stock;
            document.getElementById('edit-category').value = button.dataset.category;
            editModal.style.display = 'block';
        });
    });

    closeBtn.onclick = () => { editModal.style.display = 'none'; }
    window.onclick = (event) => {
        if (event.target == editModal) { editModal.style.display = 'none'; }
    }
    
    // Search functionality
    const searchInput = document.getElementById('product-search');
    const tableRows = document.querySelectorAll('.products-table tbody tr');
    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        tableRows.forEach(row => {
            const name = row.dataset.name;
            row.style.display = name.includes(searchTerm) ? '' : 'none';
        });
    });
</script>
</body>
</html>