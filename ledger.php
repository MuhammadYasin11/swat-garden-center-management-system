<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
require 'db_connect.php';
$message = "";

// --- DELETE LOGIC ---
if (isset($_GET['delete_sale'])) {
    $id = (int)$_GET['delete_sale'];
    $conn->query("DELETE FROM sales WHERE sale_id = $id");
    $message = "<div style='background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px; font-weight: bold;'>Sale Entry Deleted successfully.</div>";
}
if (isset($_GET['delete_exp'])) {
    $id = (int)$_GET['delete_exp'];
    $conn->query("DELETE FROM expenses WHERE expense_id = $id");
    $message = "<div style='background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px; font-weight: bold;'>Expense Entry Deleted successfully.</div>";
}

// --- MONTH FILTER LOGIC ---
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m'); 

$salesList = $conn->query("SELECT * FROM sales WHERE DATE_FORMAT(sale_date, '%Y-%m') = '$selectedMonth' ORDER BY sale_date DESC");
$expList = $conn->query("SELECT * FROM expenses WHERE DATE_FORMAT(expense_date, '%Y-%m') = '$selectedMonth' ORDER BY expense_date DESC");

$monthSalesTotal = $conn->query("SELECT COALESCE(SUM(total_amount), 0) AS t FROM sales WHERE DATE_FORMAT(sale_date, '%Y-%m') = '$selectedMonth'")->fetch_assoc()['t'];
$monthExpTotal = $conn->query("SELECT COALESCE(SUM(amount), 0) AS t FROM expenses WHERE DATE_FORMAT(expense_date, '%Y-%m') = '$selectedMonth'")->fetch_assoc()['t'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Ledger - Swat Garden Center</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; }
        .sidebar { height: 100vh; width: 250px; background-color: #2c3e50; color: white; position: fixed; padding-top: 20px; }
        .sidebar h2 { text-align: center; color: #2ecc71; margin-bottom: 30px; }
        .sidebar a { padding: 15px 25px; text-decoration: none; font-size: 18px; color: white; display: block; }
        .sidebar a:hover { background-color: #27ae60; }
        
        .main-content { margin-left: 250px; padding: 30px; }
        .header-controls { display: flex; justify-content: space-between; align-items: center; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); margin-bottom: 20px; }
        
        .filter-form { display: flex; gap: 10px; align-items: center; }
        input[type="month"] { padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; font-family: inherit;}
        button.btn-filter { padding: 10px 20px; background-color: #2980b9; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight:bold; }
        
        .ledger-container { display: flex; gap: 20px; }
        .ledger-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); flex: 1; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 14px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #f8f9fa; }
        
        .btn-edit { background-color: #f39c12; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold; margin-right: 5px;}
        .btn-delete { background-color: #e74c3c; color: white; padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 12px; font-weight: bold; }
        .btn-edit:hover { background-color: #d68910; }
        .btn-delete:hover { background-color: #c0392b; }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Swat Garden 🌱</h2>
        <a href="index.php">Dashboard</a>
        <a href="daily_entry.php">Daily Entry Form</a>
        <a href="ledger.php" style="background-color: #27ae60;">Full Ledger</a>
        <a href="update_stock.php">Adjust Stock</a>
        <a href="inventory.php">Master Inventory</a>
        <a href="qr_codes.php">Print QR Codes</a>
    </div>

    <div class="main-content">
        <h1>Monthly Ledger Report</h1>
        
        <?php echo $message; ?>

        <div class="header-controls">
            <form method="GET" action="ledger.php" class="filter-form">
                <label style="font-weight: bold;">Select Month:</label>
                <input type="month" name="month" value="<?php echo $selectedMonth; ?>" required>
                <button type="submit" class="btn-filter">View Ledger</button>
            </form>
            
            <div style="text-align: right;">
                <h3 style="margin: 0; color: #2980b9;">Total Sales: Rs. <?php echo number_format($monthSalesTotal, 2); ?></h3>
                <h3 style="margin: 5px 0 0 0; color: #e74c3c;">Total Exp: Rs. <?php echo number_format($monthExpTotal, 2); ?></h3>
            </div>
        </div>

        <div class="ledger-container">
            <div class="ledger-box">
                <h3 style="color: #2980b9; margin-top:0;">Sales History</h3>
                <table>
                    <tr><th>Date</th><th>Amount</th><th>Actions</th></tr>
                    <?php 
                    if ($salesList->num_rows > 0) {
                        while($row = $salesList->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo date('M d, Y', strtotime($row['sale_date'])); ?></td>
                                <td><strong style="color: #2980b9;">Rs. <?php echo number_format($row['total_amount'], 2); ?></strong></td>
                                <td>
                                    <!-- UPDATED LINK HERE -->
                                    <a href="edit_entry.php?dt=<?php echo urlencode($row['sale_date']); ?>" class="btn-edit">Edit</a>
                                    <a href="ledger.php?delete_sale=<?php echo $row['sale_id']; ?>&month=<?php echo $selectedMonth; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this sale?');">Delete</a>
                                </td>
                            </tr>
                        <?php } 
                    } else {
                        echo "<tr><td colspan='3' style='text-align:center;'>No sales recorded this month.</td></tr>";
                    }
                    ?>
                </table>
            </div>

            <div class="ledger-box">
                <h3 style="color: #e74c3c; margin-top:0;">Expense History</h3>
                <table>
                    <tr><th>Date</th><th>Amount</th><th>Desc</th><th>Actions</th></tr>
                    <?php 
                    if ($expList->num_rows > 0) {
                        while($row = $expList->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo date('M d, Y', strtotime($row['expense_date'])); ?></td>
                                <td><strong style="color: #e74c3c;">Rs. <?php echo number_format($row['amount'], 2); ?></strong></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                                <td>
                                    <!-- UPDATED LINK HERE -->
                                    <a href="edit_entry.php?dt=<?php echo urlencode($row['expense_date']); ?>" class="btn-edit">Edit</a>
                                    <a href="ledger.php?delete_exp=<?php echo $row['expense_id']; ?>&month=<?php echo $selectedMonth; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this expense?');">Delete</a>
                                </td>
                            </tr>
                        <?php } 
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center;'>No expenses recorded this month.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>

    </div>
</body>
</html>