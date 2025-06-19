<!DOCTYPE html>
<html>
    <body>
        <h1>
            Models
        </h1>
        
        <a href="../items/inventory.php">
            <button>Return to inventory page</button>
        </a>

        <a href="../models/insert_model.php">
            <button>Add new model</button>
        </a>
            
        <h2>Models list:</h2>

        <?php
        include '../db.php';
        $result = $conn->query("SELECT * FROM models");

        
        echo "<table border='1' cellpadding='8'>";
        echo "<tr><th>ID</th><th>Name</th><th>Category</th><th>Image</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            //echo "<td>" . $row['id'] .'</td>';
            echo "<td>" . $row["name"] .'</td>';
            echo "<td>" . $row["category"] .'</td>';
            echo "<td>" . $row["image"] .'</td>';
            echo "</tr>";
        }

        $conn->close()
        ?>
    </body>
</html>