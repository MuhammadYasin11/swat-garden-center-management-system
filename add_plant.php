<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
require 'db_connect.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Grab all the inputs and sanitize them
    $name = $conn->real_escape_string($_POST['plant_name']);
    $category = $conn->real_escape_string($_POST['category']);
    $type = $conn->real_escape_string($_POST['type']);
    $light = $conn->real_escape_string($_POST['light_requirement']);
    $water = $conn->real_escape_string($_POST['water_frequency']);
    $temp_min = (int)$_POST['temp_min'];
    $temp_max = (int)$_POST['temp_max'];
    $maintenance = $conn->real_escape_string($_POST['maintenance_level']);
    $growth = $conn->real_escape_string($_POST['growth_rate']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock_quantity'];
    $score = (float)$_POST['expert_score'];

    // Insert into the database
    $insertQuery = "INSERT INTO plants (plant_name, category, type, light_requirement, water_frequency, temp_min, temp_max, maintenance_level, growth_rate, price, stock_quantity, expert_score) 
                    VALUES ('$name', '$category', '$type', '$light', '$water', $temp_min, $temp_max, '$maintenance', '$growth', $price, $stock, $score)";

    if ($conn->query($insertQuery) === TRUE) {
        $message = "<div style='background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-weight: bold; text-align: center;'>Success! $name has been added to the system.</div>";
    } else {
        $message = "<div style='background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Plant - Swat Garden Center</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f7f6; padding: 30px; }
        .form-container { background: white; padding: 30px; border-radius: 8px; width: 600px; margin: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        
        /* Using a grid to make the long form look clean */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .full-width { grid-column: 1 / -1; }
        
        label { font-weight: bold; color: #333; display: block; margin-bottom: 5px; font-size: 14px;}
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
        
        button { width: 100%; padding: 12px; background-color: #27ae60; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 20px; font-weight: bold;}
        button:hover { background-color: #2ecc71; }
        .back-link { display: block; text-align: center; margin-top: 20px; text-decoration: none; color: #2980b9; font-weight: bold;}
    </style>
</head>
<body>

    <div class="form-container">
        <h2>🌱 Add New Plant to Inventory</h2>
        <?php echo $message; ?>

        <form action="" method="POST">
            <div class="form-grid">
                <div class="full-width">
                    <label>Plant Name *</label>
                    <input type="text" name="plant_name" required placeholder="e.g. Monstera Deliciosa">
                </div>

                <div>
                    <label>Category</label>
                    <input type="text" name="category" placeholder="e.g. Indoor">
                </div>
                <div>
                    <label>Type</label>
                    <input type="text" name="type" placeholder="e.g. Foliage">
                </div>

                <div>
                    <label>Light Requirement</label>
                    <input type="text" name="light_requirement" placeholder="e.g. Indirect Sunlight">
                </div>
                <div>
                    <label>Water Frequency</label>
                    <input type="text" name="water_frequency" placeholder="e.g. Weekly">
                </div>

                <div>
                    <label>Min Temp (°C)</label>
                    <input type="number" name="temp_min" placeholder="e.g. 15">
                </div>
                <div>
                    <label>Max Temp (°C)</label>
                    <input type="number" name="temp_max" placeholder="e.g. 30">
                </div>

                <div>
                    <label>Maintenance Level</label>
                    <input type="text" name="maintenance_level" placeholder="e.g. Low">
                </div>
                <div>
                    <label>Growth Rate</label>
                    <input type="text" name="growth_rate" placeholder="e.g. Fast">
                </div>

                <div>
                    <label>Price (Rs.) *</label>
                    <input type="number" step="0.01" name="price" required placeholder="e.g. 1500">
                </div>
                <div>
                    <label>Initial Stock Quantity *</label>
                    <input type="number" name="stock_quantity" required placeholder="e.g. 10">
                </div>

                <div class="full-width">
                    <label>Expert Score (out of 10)</label>
                    <input type="number" step="0.1" max="10" name="expert_score" placeholder="e.g. 8.5">
                </div>
            </div>

            <button type="submit">+ Add Plant to Database</button>
        </form>
        
        <a href="inventory.php" class="back-link">← Back to Master Inventory</a>
    </div>

</body>
</html>