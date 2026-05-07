<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }

require 'db_connect.php';
$message = "";

// --- DELETE LOGIC (The Undo Feature) ---
if (isset($_GET['delete_sale'])) {
    $id = (int)$_GET['delete_sale'];
    $conn->query("DELETE FROM sales WHERE sale_id = $id");
    $message = "<div style='color: #e74c3c; font-weight: bold; margin-bottom: 20px;'>Sale Entry Deleted (Undo Successful).</div>";
}
if (isset($_GET['delete_exp'])) {
    $id = (int)$_GET['delete_exp'];
    $conn->query("DELETE FROM expenses WHERE expense_id = $id");
    $message = "<div style='color: #e74c3c; font-weight: bold; margin-bottom: 20px;'>Expense Entry Deleted (Undo Successful).</div>";
}

// --- INSERT LOGIC ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sale_amount = $_POST['sale_amount'];
    $exp_amount = !empty($_POST['exp_amount']) ? $_POST['exp_amount'] : 0;
    $exp_desc = $conn->real_escape_string($_POST['exp_desc']);
    
    // Grab the date from the form and append the current time so the DATETIME format is perfect
    $entry_date = $_POST['entry_date']; 
    $entry_datetime = $entry_date . " " . date('H:i:s');

    if ($sale_amount > 0) {
        $conn->query("INSERT INTO sales (sale_date, total_amount, payment_method) VALUES ('$entry_datetime', $sale_amount, 'Daily Ledger')");
    }
    if ($exp_amount > 0) {
        $conn->query("INSERT INTO expenses (expense_date, amount, description) VALUES ('$entry_datetime', $exp_amount, '$exp_desc')");
    }
    $message = "<div style='color: green; font-weight: bold; margin-bottom: 20px;'>Success! Ledger Updated for " . date('M d, Y', strtotime($entry_date)) . ".</div>";
}

// Fetch the 5 Most Recent Data Entries for the Undo Table
$recentSales = $conn->query("SELECT * FROM sales ORDER BY sale_date DESC LIMIT 5");
$recentExp = $conn->query("SELECT * FROM expenses ORDER BY expense_date DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Entry - Swat Garden</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f7f6; padding: 20px; }
        .wrapper { display: flex; gap: 30px; max-width: 900px; margin: auto; }
        .box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); flex: 1;}
        input[type="number"], input[type="text"], input[type="date"] { width: 100%; padding: 10px; margin: 10px 0 20px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-size: 16px; font-family: inherit;}
        label { font-weight: bold; color: #333; }
        button { width: 100%; padding: 12px; background-color: #2c3e50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold;}
        button:hover { background-color: #1a252f; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px; }
        th, td { padding: 8px; border-bottom: 1px solid #ddd; text-align: left;}
        .btn-delete { color: red; text-decoration: none; font-weight: bold; font-size: 12px; border: 1px solid red; padding: 2px 5px; border-radius: 3px; }
        .btn-delete:hover { background-color: red; color: white; }
    </style>
</head>
<body>
    <a href="index.php" style="display: block; text-align: center; margin-bottom: 20px; text-decoration: none; color: #2980b9;">← Back to Dashboard</a>

    <div class="wrapper">
        <!-- The Entry Form -->
        <div class="box">
            <h2>Enter Totals</h2>
            <?php echo $message; ?>
            <form action="daily_entry.php" method="POST">
                
                <!-- NEW DATE FIELD (Defaults to Today) -->
                <label>Date of Transaction</label>
                <input type="date" name="entry_date" value="<?php echo date('Y-m-d'); ?>" required>

                <label>Total Sales (Rs.)</label>
                <input type="number" step="0.01" id="sale_amount" name="sale_amount" placeholder="e.g. 15000">

                <label>Total Expenses (Rs.)</label>
                <input type="number" step="0.01" id="exp_amount" name="exp_amount" placeholder="e.g. 2000">

                <label>Expense Description</label>
                <input type="text" name="exp_desc" placeholder="e.g. Bought fertilizer">

                <h3 style="text-align:center; color:#16a085;">Net: Rs. <span id="net_sale_display">0.00</span></h3>
                <button type="submit">Save to Ledger</button>
            </form>
        </div>

        <!-- The Undo / History Table -->
        <div class="box">
            <h2>Recent Entries (Undo)</h2>
            
            <h4 style="margin-bottom: 5px; color: #2980b9;">Last 5 Sales</h4>
            <table>
                <?php while($row = $recentSales->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo date('M d', strtotime($row['sale_date'])); ?></td>
                        <td>Rs. <?php echo number_format($row['total_amount'], 2); ?></td>
                        <td><a href="daily_entry.php?delete_sale=<?php echo $row['sale_id']; ?>" class="btn-delete" onclick="return confirm('Delete this sale?');">Undo</a></td>
                    </tr>
                <?php } ?>
            </table>

            <h4 style="margin-bottom: 5px; color: #e74c3c;">Last 5 Expenses</h4>
            <table>
                <?php while($row = $recentExp->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo date('M d', strtotime($row['expense_date'])); ?></td>
                        <td>Rs. <?php echo number_format($row['amount'], 2); ?></td>
                        <td><a href="daily_entry.php?delete_exp=<?php echo $row['expense_id']; ?>" class="btn-delete" onclick="return confirm('Delete this expense?');">Undo</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <script>
        // Auto Calculator logic
        const saleInput = document.getElementById('sale_amount');
        const expInput = document.getElementById('exp_amount');
        const netDisplay = document.getElementById('net_sale_display');

        function calculateNet() {
            let net = (parseFloat(saleInput.value) || 0) - (parseFloat(expInput.value) || 0);
            netDisplay.innerText = net.toFixed(2);
            netDisplay.style.color = net < 0 ? '#e74c3c' : '#16a085';
        }
        saleInput.addEventListener('keyup', calculateNet);
        expInput.addEventListener('keyup', calculateNet);
        saleInput.addEventListener('change', calculateNet);
        expInput.addEventListener('change', calculateNet);
    </script>
</body>
</html>