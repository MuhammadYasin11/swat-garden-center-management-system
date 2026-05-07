<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
require 'db_connect.php';

// Fetch all plants (or you can add a limit if you only want to print a few at a time)
$plantsResult = $conn->query("SELECT * FROM plants ORDER BY plant_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code Labels - Swat Garden Center</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f4f7f6; margin: 0; }
        
        /* Standard Sidebar Layout */
        .sidebar { height: 100vh; width: 250px; background-color: #2c3e50; color: white; position: fixed; padding-top: 20px; }
        .sidebar h2 { text-align: center; color: #2ecc71; margin-bottom: 30px; }
        .sidebar a { padding: 15px 25px; text-decoration: none; font-size: 18px; color: white; display: block; }
        .sidebar a:hover { background-color: #27ae60; }
        
        .main-content { margin-left: 250px; padding: 30px; }
        
        .header-controls { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);}
        button.btn-print { background-color: #8e44ad; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; }
        button.btn-print:hover { background-color: #732d91; }

        /* The Grid for the Labels */
        .label-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        
        /* Individual Label Styling */
        .label-card { background: white; padding: 15px; border: 2px dashed #bdc3c7; border-radius: 8px; text-align: center; }
        .label-card img { width: 150px; height: 150px; margin-bottom: 10px; border: 1px solid #eee; padding: 5px;}
        .label-card h4 { margin: 0 0 5px 0; color: #2c3e50; font-size: 18px; }
        .label-card p { margin: 2px 0; color: #7f8c8d; font-size: 12px; }
        .label-card .price { color: #27ae60; font-weight: bold; font-size: 16px; margin-top: 5px; }

        /* PRINT STYLES - This hides the sidebar and background colors when you actually print the page */
        @media print {
            body { background-color: white; }
            .sidebar, .header-controls { display: none; }
            .main-content { margin-left: 0; padding: 0; }
            .label-card { break-inside: avoid; border: 1px solid #000; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Swat Garden 🌱</h2>
        <a href="index.php">Dashboard</a>
        <a href="daily_entry.php">Daily Entry Form</a>
        <a href="ledger.php">Full Ledger</a>
        <a href="update_stock.php">Adjust Stock</a>
        <a href="inventory.php">Master Inventory</a>
        <a href="qr_codes.php" style="background-color: #27ae60;">Print QR Codes</a>
    </div>

    <div class="main-content">
        <div class="header-controls">
            <div>
                <h1 style="margin: 0; color: #2c3e50;">Plant QR Code Labels</h1>
                <p style="margin: 5px 0 0 0; color: #7f8c8d;">Cut these out and attach them to your plant pots!</p>
            </div>
            <!-- This button triggers the browser's print dialog -->
            <button class="btn-print" onclick="window.print()">🖨️ Print Labels</button>
        </div>

        <div class="label-grid">
            <?php 
            if ($plantsResult->num_rows > 0) {
                while($row = $plantsResult->fetch_assoc()) { 
                    
                    // 1. Combine the data we want the customer to see when they scan it
                    $qrData = "Swat Garden Center\n";
                    $qrData .= "Plant: " . $row['plant_name'] . "\n";
                    $qrData .= "Price: Rs. " . $row['price'] . "\n";
                    $qrData .= "Light: " . $row['light_requirement'] . "\n";
                    $qrData .= "Water: " . $row['water_frequency'];

                    // 2. URL-encode the data so it can be sent safely over the internet
                    $encodedData = urlencode($qrData);
                    
                    // 3. The API URL that magically generates the image
                    $qrImageUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . $encodedData;
                    ?>
                    
                    <!-- HTML for a single label -->
                    <div class="label-card">
                        <h4><?php echo htmlspecialchars($row['plant_name']); ?></h4>
                        <img src="<?php echo $qrImageUrl; ?>" alt="QR Code for <?php echo $row['plant_name']; ?>">
                        <p><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
                        <p><strong>Care:</strong> <?php echo htmlspecialchars($row['water_frequency']); ?></p>
                        <div class="price">Rs. <?php echo number_format($row['price'], 2); ?></div>
                    </div>

                <?php } 
            } else {
                echo "<p>No plants found to generate codes for.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>