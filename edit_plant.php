<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
require 'db_connect.php';
$message = "";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id == 0) {
    die("Invalid request. Go back to the inventory.");
}

// Handle Form Submission for ALL fields
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $updateQuery = "UPDATE plants SET 
                    plant_name = '$name', category = '$category', type = '$type', 
                    light_requirement = '$light', water_frequency = '$water', 
                    temp_min = $temp_min, temp_max = $temp_max, 
                    maintenance_level = '$maintenance', growth_rate = '$growth', 
                    price = $price, stock_quantity = $stock, expert_score = $score 
                    WHERE plant_id = $id";

    if ($conn->query($updateQuery) === TRUE) {
        $message = "<div style='background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-weight: bold; text-align:center;'>Plant details updated successfully!</div>";
    } else {
        $message = "<div style='background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align:center;'>Error: " . $conn->error . "</div>";
    }
}

// Fetch current details to populate the form
$result = $conn->query("SELECT * FROM plants WHERE plant_id = $id");
$plant = $result->fetch_assoc();

if (!$plant) {
    die("Plant not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Plant - Swat Garden Center</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f7f6; padding: 30px; }
        .form-container { background: white; padding: 30px; border-radius: 8px; width: 600px; margin: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .full-width { grid-column: 1 / -1; }
        label { font-weight: bold; color: #333; display: block; margin-bottom: 5px; font-size: 14px;}
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #f39c12; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; margin-top: 20px; font-weight: bold;}
        button:hover { background-color: #d68910; }
        .back-link { display: block; text-align: center; margin-top: 20px; text-decoration: none; color: #2980b9; font-weight: bold;}
    </style>
</head>
<body>

    <div class="form-container">
        <h2>✏️ Edit Plant Profile</h2>
        <?php echo $message; ?>

        <form action="" method="POST">
            <div class="form-grid">
                <div class="full-width">
                    <label>Plant Name *</label>
                    <input type="text" name="plant_name" value="<?php echo htmlspecialchars($plant['plant_name']); ?>" required>
                </div>

                <div>
                    <label>Category</label>
                    <input type="text" name="category" value="<?php echo htmlspecialchars($plant['category']); ?>">
                </div>
                <div>
                    <label>Type</label>
                    <input type="text" name="type" value="<?php echo htmlspecialchars($plant['type']); ?>">
                </div>

                <div>
                    <label>Light Requirement</label>
                    <input type="text" name="light_requirement" value="<?php echo htmlspecialchars($plant['light_requirement']); ?>">
                </div>
                <div>
                    <label>Water Frequency</label>
                    <input type="text" name="water_frequency" value="<?php echo htmlspecialchars($plant['water_frequency']); ?>">
                </div>

                <div>
                    <label>Min Temp (°C)</label>
                    <input type="number" name="temp_min" value="<?php echo $plant['temp_min']; ?>">
                </div>
                <div>
                    <label>Max Temp (°C)</label>
                    <input type="number" name="temp_max" value="<?php echo $plant['temp_max']; ?>">
                </div>

                <div>
                    <label>Maintenance Level</label>
                    <input type="text" name="maintenance_level" value="<?php echo htmlspecialchars($plant['maintenance_level']); ?>">
                </div>
                <div>
                    <label>Growth Rate</label>
                    <input type="text" name="growth_rate" value="<?php echo htmlspecialchars($plant['growth_rate']); ?>">
                </div>

                <div>
                    <label>Price (Rs.) *</label>
                    <input type="number" step="0.01" name="price" value="<?php echo $plant['price']; ?>" required>
                </div>
                <div>
                    <label>Stock Quantity *</label>
                    <input type="number" name="stock_quantity" value="<?php echo $plant['stock_quantity']; ?>" required>
                </div>

                <div class="full-width">
                    <label>Expert Score (out of 10)</label>
                    <input type="number" step="0.1" max="10" name="expert_score" value="<?php echo $plant['expert_score']; ?>">
                </div>
            </div>

            <button type="submit">Save All Changes</button>
        </form>
        
        <a href="inventory.php" class="back-link">← Back to Master Inventory</a>
    </div>

</body>
</html>