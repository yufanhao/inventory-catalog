<html>
    <body>
    

    <?php
    require_once('../db.php');
    require('../functions.php');

    $name = $_GET["name"];
    echo"<h2>".$name."</h2>";
    $flag = FALSE;

    $items = $conn->query("SELECT * FROM items WHERE name = '$name'");
    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>Model Name</th><th>Image</th><th>Expiration</th>
          <th>Box</th><th>Cabinet</th><th>Shelf</th><th>Floor</th><th>Delete Item</th></tr>";
    while ($row = $items->fetch_assoc()) {
        $location_id = $row['location_id'];
        $location_array = get_location($conn, $location_id);

        echo "<tr>";
        echo "<td><a href='get_item_by_id.php?id=" . $row['id'] . "'>" . $row['name'] ."</td>";
        //echo "<td>" . $row['category'] ."</td>";
        echo '<td> <img src="' . $row["image_url"] .'" width="75" height="75" > </td>';
        echo "<td>" . $row['expiration'] ."</td>";
        echo "<td>" . $location_array['box'] . "</td>";
        echo "<td>". $location_array["cabinet"] ."</td>";
        echo "<td>". $location_array["shelf"] ."</td>";
        echo "<td>". $location_array["floor"] ."</td>";
        echo "<td><a href='delete_item.php?id=" . $row['id'] . "'>Delete Item</a></td>";
        echo "</tr>";
    }
    echo "<br><form action ='../models/view_models.php' method = 'get'>
                <button type = 'submit'>Return to Inventory</button><br><br>
                </form>";

    $conn->close();
    ?>
    </body>
</html>