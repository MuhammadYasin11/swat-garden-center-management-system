<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
require 'db_connect.php';
$message = "";

// --- DELETE LOGIC FOR DASHBOARD ---
if (isset($_GET['delete_sale'])) {
    $id = (int)$_GET['delete_sale'];
    $conn->query("DELETE FROM sales WHERE sale_id = $id");
    $message = "<div style='background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; text-align: center;'>Sale Record Deleted. Totals updated.</div>";
}
if (isset($_GET['delete_exp'])) {
    $id = (int)$_GET['delete_exp'];
    $conn->query("DELETE FROM expenses WHERE expense_id = $id");
    $message = "<div style='background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold; text-align: center;'>Expense Record Deleted. Totals updated.</div>";
}

// --- ALL-TIME TOTALS ---
$allTimeSales = $conn->query("SELECT COALESCE(SUM(total_amount), 0) AS t FROM sales")->fetch_assoc()['t'];
$allTimeExp = $conn->query("SELECT COALESCE(SUM(amount), 0) AS t FROM expenses")->fetch_assoc()['t'];
$allTimeNet = $allTimeSales - $allTimeExp;

// --- MONTHLY LOGIC ---
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m'); 
$monthSales = $conn->query("SELECT COALESCE(SUM(total_amount), 0) AS t FROM sales WHERE DATE_FORMAT(sale_date, '%Y-%m') = '$selectedMonth'")->fetch_assoc()['t'];
$monthExp = $conn->query("SELECT COALESCE(SUM(amount), 0) AS t FROM expenses WHERE DATE_FORMAT(expense_date, '%Y-%m') = '$selectedMonth'")->fetch_assoc()['t'];
$monthNet = $monthSales - $monthExp;

$salesList = $conn->query("SELECT * FROM sales WHERE DATE_FORMAT(sale_date, '%Y-%m') = '$selectedMonth' ORDER BY sale_date DESC");
$expList = $conn->query("SELECT * FROM expenses WHERE DATE_FORMAT(expense_date, '%Y-%m') = '$selectedMonth' ORDER BY expense_date DESC");
$lowStockResult = $conn->query("SELECT plant_name, stock_quantity FROM plants WHERE stock_quantity <= 5 ORDER BY stock_quantity ASC LIMIT 10");

// --- DATA FOR JAVASCRIPT CHARTS ---
$catQuery = $conn->query("SELECT category, COUNT(*) as count FROM plants GROUP BY category");
$catLabels = [];
$catData = [];
while($row = $catQuery->fetch_assoc()) {
    $catLabels[] = empty($row['category']) ? 'Uncategorized' : $row['category'];
    $catData[] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Swat Garden Center - Dashboard</title>
    <!-- Include Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; box-sizing: border-box; }
        
        .sidebar { height: 100vh; width: 250px; background-color: #2c3e50; color: white; position: fixed; top: 0; left: 0; padding-top: 20px; overflow-y: auto; }
        .sidebar h2 { text-align: center; color: #2ecc71; margin-bottom: 30px; }
        .sidebar a { padding: 15px 25px; text-decoration: none; font-size: 16px; color: white; display: block; border-bottom: 1px solid #34495e;}
        .sidebar a:hover { background-color: #27ae60; }
        
        /* Fixed main content area */
        .main-content { margin-left: 250px; padding: 20px 40px; max-width: 1400px; }
        
        .all-time-banner { background: #34495e; color: white; padding: 15px; border-radius: 8px; display: flex; justify-content: space-around; margin-bottom: 20px; }
        .all-time-banner div { text-align: center; }
        .all-time-banner h4 { margin: 0; color: #bdc3c7; font-size: 12px; text-transform: uppercase; }
        .all-time-banner .amount { font-size: 20px; font-weight: bold; margin-top: 5px; }

        .tabs { display: flex; border-bottom: 2px solid #ddd; margin-bottom: 20px; }
        .tabs a { padding: 10px 20px; text-decoration: none; color: #7f8c8d; font-weight: bold; border-bottom: 3px solid transparent; }
        .tabs a.active { color: #2980b9; border-bottom: 3px solid #2980b9; }

        .dashboard-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px; }
        .card { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; }
        .card h3 { margin: 0; color: #7f8c8d; font-size: 14px; text-transform: uppercase; }
        .card .amount { font-size: 26px; font-weight: bold; margin-top: 5px; }
        .text-green { color: #27ae60; } .text-red { color: #e74c3c; } .text-blue { color: #2980b9; }

        /* Chart Layout - Fixed Heights */
        .chart-container { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px; }
        .chart-box { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); height: 250px; display: flex; flex-direction: column; }
        .chart-wrapper { position: relative; height: 100%; width: 100%; }

        /* Ledger Tables - Fixed Heights with Internal Scrolling */
        .ledger-container { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .ledger-box { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); height: 250px; overflow-y: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th, td { padding: 8px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #f8f9fa; position: sticky; top: 0; z-index: 1; box-shadow: 0 1px 0 #ddd;}
        
        .btn-edit { background-color: #f39c12; color: white; padding: 3px 8px; text-decoration: none; border-radius: 3px; font-size: 11px; font-weight: bold; margin-right: 3px;}
        .btn-delete { background-color: #e74c3c; color: white; padding: 3px 8px; text-decoration: none; border-radius: 3px; font-size: 11px; font-weight: bold; }
        
        .alerts-box { background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 40px; height: 200px; overflow-y: auto;}
    </style>
</head>
<body>

    <div class="sidebar">
    <h2>Swat Garden 🌱</h2>
    <a href="index.php">Dashboard</a>
    <a href="daily_entry.php">Daily Entry Form</a>
    <a href="ledger.php">Full Ledger</a>
    <a href="inventory.php">Master Inventory</a>
    <a href="update_stock.php">Adjust Stock</a>
    <a href="report.php">Monthly Report</a>
    <a href="qr_codes.php">Print QR Codes</a>
    <a href="logout.php" class="logout" style="color:#e74c3c;">Logout</a>
</div>

    <div class="main-content">
        <h1 style="margin-top:0;">Overview Dashboard</h1>
        
        <?php echo $message; ?>

        <div class="all-time-banner">
            <div><h4>All-Time Sales</h4><div class="amount">Rs. <?php echo number_format($allTimeSales, 2); ?></div></div>
            <div><h4>All-Time Expenses</h4><div class="amount">Rs. <?php echo number_format($allTimeExp, 2); ?></div></div>
            <div><h4>All-Time Net Profit</h4><div class="amount text-green">Rs. <?php echo number_format($allTimeNet, 2); ?></div></div>
        </div>

        <div class="tabs">
            <?php
            for ($i = 0; $i < 4; $i++) {
                $monthValue = date('Y-m', strtotime("-$i months"));
                $monthLabel = date('M Y', strtotime("-$i months")); // Shortened to 'M' (e.g. May 2024) to save space
                $activeClass = ($selectedMonth == $monthValue) ? 'active' : '';
                echo "<a href='index.php?month=$monthValue' class='$activeClass'>$monthLabel</a>";
            }
            ?>
        </div>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Sales for <?php echo date('M', strtotime($selectedMonth)); ?></h3>
                <div class="amount text-blue">Rs. <?php echo number_format($monthSales, 2); ?></div>
            </div>
            <div class="card">
                <h3>Expenses for <?php echo date('M', strtotime($selectedMonth)); ?></h3>
                <div class="amount text-red">Rs. <?php echo number_format($monthExp, 2); ?></div>
            </div>
            <div class="card">
                <h3>Net Sales</h3>
                <div class="amount text-green">Rs. <?php echo number_format($monthNet, 2); ?></div>
            </div>
        </div>

        <!-- CHARTS -->
        <div class="chart-container">
            <div class="chart-box">
                <h3 style="margin: 0 0 10px 0; color:#2c3e50; text-align:center; font-size:14px;">Financial Breakdown</h3>
                <div class="chart-wrapper">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>
            <div class="chart-box">
                <h3 style="margin: 0 0 10px 0; color:#2c3e50; text-align:center; font-size:14px;">Inventory</h3>
                <div class="chart-wrapper">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- LEDGER TABLES -->
        <div class="ledger-container">
            <div class="ledger-box">
                <h3 style="margin: 0 0 10px 0; color: #2980b9;">Sales Ledger</h3>
                <table>
                    <tr><th>Date</th><th>Amount</th><th>Action</th></tr>
                    <?php while($row = $salesList->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo date('M d', strtotime($row['sale_date'])); ?></td>
                            <td>Rs. <?php echo number_format($row['total_amount'], 2); ?></td>
                            <td>
                                <a href="edit_entry.php?dt=<?php echo urlencode($row['sale_date']); ?>" class="btn-edit">Edit</a>
                                <a href="index.php?delete_sale=<?php echo $row['sale_id']; ?>&month=<?php echo $selectedMonth; ?>" class="btn-delete" onclick="return confirm('Delete this sale?');">Del</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <div class="ledger-box">
                <h3 style="margin: 0 0 10px 0; color: #e74c3c;">Expense Ledger</h3>
                <table>
                    <tr><th>Date</th><th>Amount</th><th>Action</th></tr>
                    <?php while($row = $expList->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo date('M d', strtotime($row['expense_date'])); ?></td>
                            <td>Rs. <?php echo number_format($row['amount'], 2); ?></td>
                            <td>
                                <a href="edit_entry.php?dt=<?php echo urlencode($row['expense_date']); ?>" class="btn-edit">Edit</a>
                                <a href="index.php?delete_exp=<?php echo $row['expense_id']; ?>&month=<?php echo $selectedMonth; ?>" class="btn-delete" onclick="return confirm('Delete?');">Del</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <!-- LOW STOCK ALERTS -->
        <div class="alerts-box">
            <h3 style="margin: 0 0 10px 0; color: #e74c3c;">⚠️ Low Stock Alerts</h3>
            <table>
                <tr>
                    <th>Plant Name</th><th>Stock</th><th>Status</th>
                </tr>
                <?php
                if ($lowStockResult->num_rows > 0) {
                    while($row = $lowStockResult->fetch_assoc()) {
                        echo "<tr><td><strong>{$row['plant_name']}</strong></td><td>{$row['stock_quantity']}</td><td style='color:#e74c3c; font-weight:bold;'>Restock Needed</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align:center; color:green;'>All well stocked!</td></tr>";
                }
                ?>
            </table>
        </div>

    </div>

    <script>
        // Set default font for charts to match UI
        Chart.defaults.font.family = "'Segoe UI', Tahoma, sans-serif";

        const ctxFinance = document.getElementById('financeChart').getContext('2d');
        new Chart(ctxFinance, {
            type: 'bar',
            data: {
                labels: ['Monthly Totals'],
                datasets: [
                    {
                        label: 'Sales (Rs.)',
                        data: [<?php echo $monthSales; ?>],
                        backgroundColor: '#3498db',
                        borderRadius: 3
                    },
                    {
                        label: 'Expenses (Rs.)',
                        data: [<?php echo $monthExp; ?>],
                        backgroundColor: '#e74c3c',
                        borderRadius: 3
                    }
                ]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($catLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($catData); ?>,
                    backgroundColor: ['#2ecc71', '#f1c40f', '#9b59b6', '#e67e22', '#1abc9c', '#34495e'],
                    borderWidth: 0
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { position: 'right', labels: { boxWidth: 10 } } }
            }
        });
    </script>
</body>
</html>