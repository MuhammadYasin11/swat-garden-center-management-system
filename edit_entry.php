<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
require 'db_connect.php';
$message = "";

// 1. Get the exact Date & Time (Timestamp) from the URL
$dt = isset($_GET['dt']) ? $_GET['dt'] : '';

if (empty($dt)) {
    die("Invalid request. No date/time provided.");
}

// 2. Handle the Form Submission (Updating the database)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_sale = (float)$_POST['sale_amount'];
    $new_exp = (float)$_POST['exp_amount'];
    $new_desc = $conn->real_escape_string($_POST['exp_desc']);

    // Start transaction to ensure both tables update safely
    $conn->begin_transaction();
    try {
        // --- UPDATE SALES ---
        $saleCheck = $conn->query("SELECT sale_id FROM sales WHERE sale_date = '$dt'");
        if ($saleCheck->num_rows > 0) {
            if ($new_sale > 0) {
                $conn->query("UPDATE sales SET total_amount = $new_sale WHERE sale_date = '$dt'");
            } else {
                $conn->query("DELETE FROM sales WHERE sale_date = '$dt'"); // Delete if set to 0
            }
        } else if ($new_sale > 0) {
            // If they didn't have a sale before, but added one during edit
            $conn->query("INSERT INTO sales (sale_date, total_amount, payment_method) VALUES ('$dt', $new_sale, 'Daily Ledger')");
        }

        // --- UPDATE EXPENSES ---
        $expCheck = $conn->query("SELECT expense_id FROM expenses WHERE expense_date = '$dt'");
        if ($expCheck->num_rows > 0) {
            if ($new_exp > 0) {
                $conn->query("UPDATE expenses SET amount = $new_exp, description = '$new_desc' WHERE expense_date = '$dt'");
            } else {
                $conn->query("DELETE FROM expenses WHERE expense_date = '$dt'"); // Delete if set to 0
            }
        } else if ($new_exp > 0) {
            // If they didn't have an expense before, but added one during edit
            $conn->query("INSERT INTO expenses (expense_date, amount, description) VALUES ('$dt', $new_exp, '$new_desc')");
        }
        
        $conn->commit();
        $message = "<div style='background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-weight: bold; text-align:center;'>Ledger Entry updated successfully!</div>";
    } catch (Exception $e) {
        $conn->rollback();
        $message = "<div style='background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align:center;'>Error updating record: " . $conn->error . "</div>";
    }
}

// 3. Fetch the CURRENT data to pre-fill the form
$current_sale = 0;
$current_exp = 0;
$current_desc = "";

$saleResult = $conn->query("SELECT total_amount FROM sales WHERE sale_date = '$dt'");
if ($row = $saleResult->fetch_assoc()) {
    $current_sale = $row['total_amount'];
}

$expResult = $conn->query("SELECT amount, description FROM expenses WHERE expense_date = '$dt'");
if ($row = $expResult->fetch_assoc()) {
    $current_exp = $row['amount'];
    $current_desc = $row['description'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Daily Ledger - Swat Garden</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f7f6; padding: 50px; }
        .form-container { background: white; padding: 30px; border-radius: 8px; width: 400px; margin: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        input[type="number"], input[type="text"] { width: 100%; padding: 10px; margin: 10px 0 20px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-size: 16px;}
        label { font-weight: bold; color: #333; }
        .net-sale-box { background: #e8f8f5; padding: 15px; border-radius: 5px; text-align: center; margin-bottom: 20px; border: 1px solid #1abc9c;}
        .net-sale-box h3 { margin: 0; color: #16a085; }
        button { width: 100%; padding: 12px; background-color: #f39c12; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; font-weight: bold;}
        button:hover { background-color: #d68910; }
        .back-link { display: block; text-align: center; margin-top: 20px; text-decoration: none; color: #2980b9; }
        .record-info { background: #ecf0f1; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 14px; color: #7f8c8d; text-align: center;}
    </style>
</head>
<body>

    <div class="form-container">
        <h2 style="margin-top:0;">✏️ Edit Ledger Entry</h2>
        
        <div class="record-info">
            <strong>Entry Timestamp:</strong><br>
            <?php echo date('F j, Y, g:i A', strtotime($dt)); ?>
        </div>

        <?php echo $message; ?>

        <form action="" method="POST">
            <label>Total Sales (Rs.)</label>
            <input type="number" step="0.01" id="sale_amount" name="sale_amount" value="<?php echo $current_sale; ?>">

            <label>Total Expenses (Rs.)</label>
            <input type="number" step="0.01" id="exp_amount" name="exp_amount" value="<?php echo $current_exp; ?>">

            <label>Expense Description</label>
            <input type="text" name="exp_desc" value="<?php echo htmlspecialchars($current_desc); ?>">

            <div class="net-sale-box">
                <small>Calculated Net Sale</small>
                <h3>Rs. <span id="net_sale_display">0.00</span></h3>
            </div>

            <button type="submit">Save Changes</button>
        </form>
        
        <!-- Quick navigation to go back -->
        <div style="display:flex; justify-content: space-between; margin-top: 20px;">
            <a href="index.php" style="text-decoration: none; color: #2980b9;">← Dashboard</a>
            <a href="ledger.php" style="text-decoration: none; color: #2980b9;">Full Ledger →</a>
        </div>
    </div>

    <!-- JavaScript to automatically calculate the Net value as you type -->
    <script>
        const saleInput = document.getElementById('sale_amount');
        const expInput = document.getElementById('exp_amount');
        const netDisplay = document.getElementById('net_sale_display');

        function calculateNet() {
            let net = (parseFloat(saleInput.value) || 0) - (parseFloat(expInput.value) || 0);
            netDisplay.innerText = net.toFixed(2);
            netDisplay.style.color = net < 0 ? '#e74c3c' : '#16a085';
        }
        
        calculateNet(); // Run immediately on page load

        saleInput.addEventListener('keyup', calculateNet);
        expInput.addEventListener('keyup', calculateNet);
        saleInput.addEventListener('change', calculateNet);
        expInput.addEventListener('change', calculateNet);
    </script>
</body>
</html>