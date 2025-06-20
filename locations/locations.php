<!DOCTYPE html>
<html>
    <body>
        <h1>
            Locations
        </h1>
        
        <a href="../items/inventory.php">
            <button>Return to Inventory Page</button>
        </a>

        <a href="../locations/insert_location.php">
            <button>Add New Location</button>
        </a>
            
        <h2>Floors List:</h2>

        <?php
        include '../db.php';
        $result = $conn->query("SELECT * FROM locations WHERE type = 'floor'");
        
        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>ID</th><th>Type</th><th>Number/Name</th><th>Description</th></tr>";
        while ($row = $result->fetch_assoc()) {

        
            echo "<tr>";
            echo "<td>" . $row['id'] .'</td>';
            echo "<td>" . $row["type"] .'</td>';
            echo "<td><a href='get_location_by_id.php?id=" . $row['id'] . "'>" . $row["number"] .'</td>';
            echo "<td>" . $row["description"] .'</td>';
            echo "</tr>";
        }

        $conn->close()
        ?>
    </body>
</html>