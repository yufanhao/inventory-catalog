<?php
function fetch_item_data($conn, $id, $col) {
    // TODO: add proper validation later.

$sql = "SELECT " . $col . " from items where id = " . $id ; 

$result = $conn->query($sql)->fetch_assoc();

return $result[$col];
}
?>