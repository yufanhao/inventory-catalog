<!DOCTYPE html>
<html>
    <body>
        <h1>
            Locations
        </h1>
        
        <a href="../items/inventory.php">
            <button>Return to inventory page</button>
        </a>

        <a href="../locations/insert_location.php">
            <button>Add new storage location</button>
        </a>
            
        <h2>Locations list:</h2>

        <?php
        include '../db.php';
        $result = $conn->query("SELECT * FROM locations");

        
        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>ID</th><th>Type</th><th>Number/Name</th><th>Description</th><th>Parent ID</th></tr>";
        while ($row = $result->fetch_assoc()) {

        
            echo "<tr>";
            echo "<td>" . $row['id'] .'</td>';
            echo "<td>" . $row["type"] .'</td>';
            echo "<td>" . $row["number"] .'</td>';
            echo "<td>" . $row["description"] .'</td>';
            echo "<td>" . $row["parent_id"] .'</td>';
            echo "</tr>";
        }

        $conn->close()
        ?>
    </body>
</html>