<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
require 'db_connect.php';

// 1. Get Selected Month (Defaults to Current Month)
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('Y-m'); 

// 2. Fetch Financial Totals
$monthSales = $conn->query("SELECT COALESCE(SUM(total_amount), 0) AS t FROM sales WHERE DATE_FORMAT(sale_date, '%Y-%m') = '$selectedMonth'")->fetch_assoc()['t'];
$monthExp = $conn->query("SELECT COALESCE(SUM(amount), 0) AS t FROM expenses WHERE DATE_FORMAT(expense_date, '%Y-%m') = '$selectedMonth'")->fetch_assoc()['t'];
$monthNet = $monthSales - $monthExp;

// 3. Fetch Major Expense (The single highest expense of the month)
$majorExpQuery = $conn->query("SELECT description, amount FROM expenses WHERE DATE_FORMAT(expense_date, '%Y-%m') = '$selectedMonth' ORDER BY amount DESC LIMIT 1");
$majorExp = $majorExpQuery->fetch_assoc();

// 4. Fetch Data for Charts
$catQuery = $conn->query("SELECT category, COUNT(*) as count FROM plants GROUP BY category");
$catLabels = []; $catData = [];
while($row = $catQuery->fetch_assoc()) {
    $catLabels[] = empty($row['category']) ? 'Uncategorized' : $row['category'];
    $catData[] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Report - Swat Garden</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; padding: 40px; background: #f4f7f6; color: #333; }
        
        /* The Printable Area */
        .report-page { background: white; width: 850px; margin: auto; padding: 50px; border-top: 10px solid #27ae60; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-radius: 0 0 8px 8px; }
        
        .header { text-align: center; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #2c3e50; text-transform: uppercase; letter-spacing: 1px; }
        .header p { margin: 5px 0; color: #7f8c8d; font-size: 16px; }

        /* KPI Boxes */
        .summary-box { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 40px; background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px solid #eee; }
        .stat-item { text-align: center; padding: 10px; border-right: 1px solid #ddd; }
        .stat-item:last-child { border-right: none; }
        .stat-item h4 { margin: 0; font-size: 12px; color: #7f8c8d; text-transform: uppercase; }
        .stat-item p { margin: 5px 0 0 0; font-size: 20px; font-weight: bold; color: #2c3e50; }

        /* Charts Layout */
        .charts-container { display: flex; gap: 30px; justify-content: space-between; margin-bottom: 40px; page-break-inside: avoid; }
        .chart-wrapper { width: 48%; }

        /* Screen-Only Controls */
        .no-print { text-align: center; margin-bottom: 30px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); width: 850px; margin-left: auto; margin-right: auto; display: flex; justify-content: space-between; align-items: center;}
        .filter-form { display: flex; gap: 10px; align-items: center; }
        .btn-print { background: #2980b9; color: white; padding: 10px 20px; border: none; cursor: pointer; font-weight: bold; border-radius: 5px; }
        .btn-print:hover { background: #2471a3; }
        
        /* Print Rules - Hides buttons and formats for A4 Paper */
        @media print { 
            body { background: white; padding: 0; }
            .no-print { display: none; } 
            .report-page { box-shadow: none; width: 100%; padding: 0; border: none; }
            .charts-container { margin-top: 20px; }
        }
    </style>
</head>
<body>

    <!-- On-Screen Controls (Hidden during print) -->
    <div class="no-print">
        <a href="index.php" style="text-decoration: none; color: #7f8c8d; font-weight: bold;">← Dashboard</a>
        
        <form method="GET" action="report.php" class="filter-form">
            <label style="font-weight: bold;">Select Month:</label>
            <input type="month" name="month" value="<?php echo $selectedMonth; ?>" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
            <button type="submit" style="padding: 8px 15px; background: #2c3e50; color: white; border: none; border-radius: 4px; cursor: pointer;">Load Data</button>
        </form>

        <button class="btn-print" onclick="window.print()">🖨️ Download PDF / Print</button>
    </div>

    <!-- The Actual Report Document -->
    <div class="report-page">
        <div class="header">
            <h1>Swat Garden Center</h1>
            <p>Official Monthly Performance Report</p>
            <p><strong>Period:</strong> <?php echo date('F Y', strtotime($selectedMonth)); ?></p>
        </div>

        <h3 style="color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 5px;">Financial Overview</h3>
        <div class="summary-box">
            <div class="stat-item">
                <h4>Total Sales</h4>
                <p style="color: #2980b9;">Rs. <?php echo number_format($monthSales, 2); ?></p>
            </div>
            <div class="stat-item">
                <h4>Total Expenses</h4>
                <p style="color: #e74c3c;">Rs. <?php echo number_format($monthExp, 2); ?></p>
            </div>
            <div class="stat-item">
                <h4>Major Expense</h4>
                <?php if ($majorExp) { ?>
                    <p style="font-size: 16px; margin-top: 8px;">Rs. <?php echo number_format($majorExp['amount'], 2); ?></p>
                    <small style="color: #7f8c8d; font-size: 11px;"><?php echo htmlspecialchars($majorExp['description']); ?></small>
                <?php } else { ?>
                    <p style="font-size: 16px; margin-top: 8px;">Rs. 0.00</p>
                    <small style="color: #7f8c8d; font-size: 11px;">None recorded</small>
                <?php } ?>
            </div>
            <div class="stat-item">
                <h4>Net Profit</h4>
                <p style="color: #27ae60;">Rs. <?php echo number_format($monthNet, 2); ?></p>
            </div>
        </div>

        <h3 style="color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 5px;">Visual Analytics</h3>
        <div class="charts-container">
            <div class="chart-wrapper">
                <canvas id="financeChart" height="200"></canvas>
            </div>
            <div class="chart-wrapper">
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>

        <div style="margin-top: 60px; display: flex; justify-content: space-between; align-items: flex-end;">
            <div style="font-size: 12px; color: #7f8c8d;">
                <p><strong>Generated By:</strong> System Administrator</p>
                <p><strong>Timestamp:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
                <p><em>This is an automatically generated internal document.</em></p>
            </div>
            <div style="text-align: center;">
                <div style="width: 200px; border-bottom: 1px solid #333; margin-bottom: 5px;"></div>
                <p style="margin: 0; font-size: 14px; font-weight: bold;">Authorized Signature</p>
            </div>
        </div>
    </div>

    <!-- Initialize Charts -->
    <script>
        // Disable animations so the charts are instantly ready to be printed
        Chart.defaults.animation = false;

        // 1. Finance Bar Chart
        new Chart(document.getElementById('financeChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Financials'],
                datasets: [
                    { label: 'Sales', data: [<?php echo $monthSales; ?>], backgroundColor: '#3498db' },
                    { label: 'Expenses', data: [<?php echo $monthExp; ?>], backgroundColor: '#e74c3c' }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // 2. Inventory Category Doughnut Chart
        new Chart(document.getElementById('categoryChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($catLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($catData); ?>,
                    backgroundColor: ['#2ecc71', '#f1c40f', '#9b59b6', '#e67e22', '#1abc9c', '#34495e']
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right' } } }
        });
    </script>
</body>
</html>