<html>
    <?php
    require_once('../db.php');

    $id =  $_POST["id"];
    $model_id =  $_POST["model_id"];
    //$name =  $_GET["name"];
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
