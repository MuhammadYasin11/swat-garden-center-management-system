<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
require 'db_connect.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plant_id = $_POST['plant_id'];
    $qty = (int)$_POST['qty'];
    $action = $_POST['action']; // 'add' or 'remove'

    if ($plant_id > 0 && $qty > 0) {
        if ($action == 'remove') {
            $query = "UPDATE plants SET stock_quantity = stock_quantity - $qty WHERE plant_id = $plant_id";
            $msg_text = "Deducted $qty item(s).";
        } else {
            // This acts as your UNDO or Restock feature
            $query = "UPDATE plants SET stock_quantity = stock_quantity + $qty WHERE plant_id = $plant_id";
            $msg_text = "Added $qty item(s) back to inventory.";
        }
        
        if ($conn->query($query) === TRUE) {
            $message = "<div style='background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-weight: bold;'>Success! $msg_text</div>";
        } else {
            $message = "<div style='background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;'>Error: " . $conn->error . "</div>";
        }
    }
}

$plantsResult = $conn->query("SELECT plant_id, plant_name, stock_quantity FROM plants ORDER BY plant_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adjust Stock - Swat Garden Center</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f7f6; padding: 50px; }
        .form-container { background: white; padding: 30px; border-radius: 8px; width: 500px; margin: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        label { font-weight: bold; color: #333; display: block; margin-top: 15px; margin-bottom: 5px; }
        select, input[type="number"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #e67e22; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 20px; font-weight: bold;}
        .back-link { display: block; text-align: center; margin-top: 20px; text-decoration: none; color: #2980b9; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Adjust Inventory Stock</h2>
        <?php echo $message; ?>

        <form action="" method="POST">
            <label>Action to Perform:</label>
            <select name="action" required style="background-color: #fdf2e9; font-weight: bold;">
                <option value="remove">📉 Remove Stock (Sale / Lost Plant)</option>
                <option value="add">📈 Add Stock (Undo Mistake / Restock)</option>
            </select>

            <label>Select Plant:</label>
            <select name="plant_id" required>
                <option value="">-- Choose a plant --</option>
                <?php
                if ($plantsResult->num_rows > 0) {
                    while($row = $plantsResult->fetch_assoc()) {
                        echo "<option value='" . $row['plant_id'] . "'>" . $row['plant_name'] . " (Current Stock: " . $row['stock_quantity'] . ")</option>";
                    }
                }
                ?>
            </select>

            <label>Quantity to Adjust:</label>
            <input type="number" name="qty" min="1" required placeholder="Enter amount...">

            <button type="submit">Update Database</button>
        </form>
        
        <a href="index.php" class="back-link">← Back to Dashboard</a>
    </div>

</body>
</html>