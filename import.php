<?php
// Include your database connection
require 'db_connect.php';

if (isset($_POST["import"])) {
    $fileName = $_FILES["file"]["tmp_name"];

    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($fileName, "r");
        
        // Skip the first row (the header row with column names)
        fgetcsv($file); 

        $count = 0;
        // Read the CSV row by row
        // Assuming your CSV columns are exactly in this order:
        // plant_id(0), plant_name(1), category(2), type(3), light(4), water(5), temp_min(6), temp_max(7), maintenance(8), growth(9), price(10), stock(11), expert_score(12)
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            // We skip column 0 (plant_id) so the database can auto-generate it safely
            $name = $conn->real_escape_string($column[1]);
            $category = $conn->real_escape_string($column[2]);
            $type = $conn->real_escape_string($column[3]);
            $light = $conn->real_escape_string($column[4]);
            $water = $conn->real_escape_string($column[5]);
            $temp_min = (int)$column[6];
            $temp_max = (int)$column[7];
            $maintenance = $conn->real_escape_string($column[8]);
            $growth = $conn->real_escape_string($column[9]);
            $price = (float)$column[10];
            $stock = (int)$column[11];
            $score = (float)$column[12];

            $sqlInsert = "INSERT INTO plants (plant_name, category, type, light_requirement, water_frequency, temp_min, temp_max, maintenance_level, growth_rate, price, stock_quantity, expert_score) 
                          VALUES ('$name', '$category', '$type', '$light', '$water', $temp_min, $temp_max, '$maintenance', '$growth', $price, $stock, $score)";
            
            if ($conn->query($sqlInsert) === TRUE) {
                $count++;
            }
        }
        echo "<h3 style='color: green;'>Success! Imported $count plants into the database.</h3>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Import Plants to Swat Garden Center</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .upload-box { border: 2px dashed #ccc; padding: 30px; width: 400px; text-align: center; }
    </style>
</head>
<body>

    <h2>Upload Plant Inventory</h2>
    <div class="upload-box">
        <form class="form-horizontal" action="" method="post" name="uploadCSV" enctype="multipart/form-data">
            <input type="file" name="file" accept=".csv" required>
            <br><br>
            <button type="submit" name="import" style="padding: 10px 20px; background-color: #28a745; color: white; border: none; cursor: pointer;">Upload and Import CSV</button>
        </form>
    </div>

</body>
</html>