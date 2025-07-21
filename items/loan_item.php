<?php
    session_start();
    require_once('../db.php');

    function set_item_user($conn, $item, $new_user_id) {
        //echo $new_user_id;
        $sql = "UPDATE items SET user_id = $new_user_id WHERE id = $item";
        //echo 'debug ' .$sql;
        $i = $conn->query($sql);
    }

    //echo "HGSDAFSveac";
    $item_id =  $_POST["id"];         // item ID to update
    $model_id =  $_POST["model_id"];  // for return landing page.
    $action = $_POST["user_action"];  // to determine loan vs return

    if ($action === 'Loan') {
        //echo '1';
        set_item_user($conn, $item_id, $_SESSION["user_id"]);
    }
    else if ($action === 'Return') {
        //echo '2';
        set_item_user($conn, $item_id, 0);
    }
    else {
        //echo '3';
        echo "User Action $action Unrecognized.<br>";
    }

    //echo $sql;

    echo "<script>
           window.location.href = './get_item_by_model_id.php?model_id=$model_id';
           </script>";
    
        // TODO: error handling.
    $conn->close();
?>