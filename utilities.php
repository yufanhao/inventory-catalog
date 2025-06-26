<?php

// Function to look up a column from a given table, for a specific id.
// TODO: temporary for ease of development. Can get rid of later.
function fetch_row_data($conn, $table, $id, $col) {
    // TODO: add proper validation later.

$sql = "SELECT " . $col . " from " . $table . " where id = " . $id ; 

$result = $conn->query($sql)->fetch_assoc();

return $result[$col];
}

// Function to look up a column from a given table, for a specific id.
function get_sql_query_row($conn, $sql, $row) {
    // TODO: add proper validation later.

return $conn->query($sql)->fetch_assoc();

return $result[$row];
}
?>