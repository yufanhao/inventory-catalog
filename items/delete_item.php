<?php
session_start();
require_once('../db.php');
?>
<html>
    <?php
    $id =  $_POST["id"];
    $model_id =  $_POST["model_id"];
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        echo $_SESSION['role'];
        echo $_SESSION['user_id'];
        echo '<a href="get_item_by_model_id.php?model_id=' . $model_id . '">
                  <button type="button">Return to View Items</button>
                  </a>';
        die("Access denied. Only admins can delete items.");
    }
   
    $sql = "DELETE from items WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            window.location.href = './get_item_by_model_id.php?model_id=$model_id';
        </script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    ?>
</html>
