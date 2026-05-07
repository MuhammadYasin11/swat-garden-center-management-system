<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
require 'db_connect.php';
$message = "";

// --- DELETE LOGIC ---
if (isset($_GET['delete_plant'])) {
    $del_id = (int)$_GET['delete_plant'];
    
    // We try to delete the plant. (Note: If this plant is linked to past sales in sale_items, 
    // it might block deletion to keep accounting history safe. This is a good database practice!)
    if ($conn->query("DELETE FROM plants WHERE plant_id = $del_id") === TRUE) {
        $message = "<div style='background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold;'>Plant successfully deleted from inventory.</div>";
    } else {
        $message = "<div style='background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; font-weight: bold;'>Cannot delete plant! It may be linked to past sales records.</div>";
    }
}

// Fetch all plants from the database
$inventoryResult = $conn->query("SELECT * FROM plants ORDER BY plant_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Master Inventory - Swat Garden Center</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; }
        .sidebar { height: 100vh; width: 250px; background-color: #2c3e50; color: white; position: fixed; padding-top: 20px; }
        .sidebar h2 { text-align: center; color: #2ecc71; margin-bottom: 30px; }
        .sidebar a { padding: 15px 25px; text-decoration: none; font-size: 18px; color: white; display: block; }
        .sidebar a:hover { background-color: #27ae60; }
        
        .main-content { margin-left: 250px; padding: 30px; }
        
        .header-controls { display: flex; justify-content: space-between; align-items: center; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); margin-bottom: 20px; }
        
        .search-box { width: 100%; max-width: 400px; padding: 12px; border: 2px solid #bdc3c7; border-radius: 5px; font-size: 16px; outline: none; transition: border-color 0.3s;}
        .search-box:focus { border-color: #2980b9; }

        .inventory-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow-x: auto; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #2c3e50; color: white; position: sticky; top: 0;}
        
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1f1f1; }

        .btn-edit { background-color: #f39c12; color: white; padding: 6px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold; margin-right: 5px;}
        .btn-edit:hover { background-color: #d68910; }
        
        .btn-delete { background-color: #e74c3c; color: white; padding: 6px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold; }
        .btn-delete:hover { background-color: #c0392b; }
        
        .low-stock { color: #e74c3c; font-weight: bold; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Swat Garden 🌱</h2>
        <a href="index.php">Dashboard</a>
        <a href="daily_entry.php">Daily Entry Form</a>
        <a href="ledger.php">Full Ledger</a>
        <a href="update_stock.php">Adjust Stock</a>
        <a href="inventory.php" style="background-color: #27ae60;">Master Inventory</a>
        <a href="qr_codes.php">Print QR Codes</a>
    </div>

    <div class="main-content">
        <h1>Master Inventory List</h1>
        
        <?php echo $message; ?>

        <div class="header-controls">
            <input type="text" id="searchInput" class="search-box" placeholder="🔍 Search by plant name or category...">
            <div style="display: flex; gap: 20px; align-items: center;">
                <div style="color: #7f8c8d;">
                    <strong>Total Unique Plants:</strong> <?php echo $inventoryResult->num_rows; ?>
                </div>
                <a href="add_plant.php" style="background-color: #27ae60; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; font-weight: bold;">+ Add New Plant</a>
            </div>
        </div>

        <div class="inventory-box">
            <table id="inventoryTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Plant Name</th>
                        <th>Category</th>
                        <th>Price (Rs.)</th>
                        <th>Current Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if ($inventoryResult->num_rows > 0) {
                        while($row = $inventoryResult->fetch_assoc()) { 
                            $stockClass = ($row['stock_quantity'] <= 5) ? 'low-stock' : '';
                            ?>
                            <tr>
                                <td>#<?php echo $row['plant_id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($row['plant_name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                <td><?php echo number_format($row['price'], 2); ?></td>
                                <td class="<?php echo $stockClass; ?>"><?php echo $row['stock_quantity']; ?></td>
                                <td>
                                    <a href="edit_plant.php?id=<?php echo $row['plant_id']; ?>" class="btn-edit">Edit</a>
                                    <!-- NEW DELETE BUTTON -->
                                    <a href="inventory.php?delete_plant=<?php echo $row['plant_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to permanently delete this plant?');">Delete</a>
                                </td>
                            </tr>
                        <?php } 
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center;'>No plants found in inventory.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById("searchInput").addEventListener("keyup", function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll("#inventoryTable tbody tr");

            rows.forEach(row => {
                let name = row.cells[1].textContent.toLowerCase();
                let category = row.cells[2].textContent.toLowerCase();
                
                if (name.includes(filter) || category.includes(filter)) {
                    row.style.display = ""; 
                } else {
                    row.style.display = "none"; 
                }
            });
        });
    </script>

</body>
</html>