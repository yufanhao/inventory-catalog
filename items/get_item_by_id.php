<html>
    <?php
    require_once('../db.php');


    $id =  $_GET["id"];
    $sql = "SELECT * from items WHERE id = $id";

    if ($conn->query($sql) !== FALSE) {
        $result = $conn->query($sql);
        echo "Item retrieved successfully! <br>";
        while ($row = $result->fetch_assoc()) {
            $location_id = $row['location_id'];
            $location_array = get_location($conn, $location_id);
            echo "Item ID: " . htmlspecialchars($row['id']) . "<br>";
            echo "Serial Number: " . htmlspecialchars($row['serial_number']) . "<br>";
            echo "Model Name: " . htmlspecialchars(fetch_row_data($conn, 'models', $row['model_id'], 'name')) . "<br>";
            echo "Expiration: " . htmlspecialchars($row['expiration']) . "<br>";
            $location = fetch_row_data($conn, 'locations', $row['location_id'], 'number');
            $location_type = fetch_row_data($conn, 'locations', $row['location_id'], 'type');
            echo "Location: " . htmlspecialchars($location_type." - ".$location) . "<br>";

        //    echo "Category: " . htmlspecialchars($row['category']) . "<br>";
        //    echo "Image: " . htmlspecialchars($row['image_url']) . "<br>";
            echo 'Box: '. htmlspecialchars($location_array['box']) . "<br>";
            echo "Cabinet: ". htmlspecialchars($location_array['cabinet']) . "<br>";
            echo "Shelf: ". htmlspecialchars($location_array['shelf']) . "<br>";
            echo "Floor: ". htmlspecialchars($location_array['floor']) . "<br>";
            
            $name = htmlspecialchars($row['name']);
            echo '<a href="get_item_by_name.php?name=' . $name . '">
                  <button type="button">Return to Inventory</button>
                  </a>';

        }         
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    ?>
</html>
