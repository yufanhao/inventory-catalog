<?php 
// commonly used functions
function get_location($conn, $location_id) {
    $flag = FALSE;
    $location_sql = "SELECT * FROM locations WHERE id = $location_id";
    $location = $conn->query($location_sql)->fetch_assoc();
    $location_type = $location["type"];
    $location_array = array(
        'box' => "",
        'cabinet' => "",
        'shelf' => "",
        'floor' => "",
        'building' => "",
        'cubicle' => "",
        'customer' => "",
    );

    // Traverse up the location hierarchy to get all location types and numbers
    while ($location_type != 'ancestor' AND $flag == FALSE) {
        if (!$location) {
            $flag = TRUE;
            break;
        }
        $location_name = $location['name'];
        $location_array[$location_type] = $location_name;

        $parent_id = $location['parent_id'];
        $parent_sql = "SELECT * FROM locations WHERE id = $parent_id";
        $parent = $conn->query($parent_sql)->fetch_assoc();
        $location = $parent;
        $location_type = $location["type"];
    }
    return $location_array;
}

function fetch_row_data($conn, $table, $id, $column) {
    $sql = "SELECT $column FROM $table WHERE id = $id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row[$column];
    } else {
        return null;
    }
}

function getChildLocationIds($conn, $parent_id) {
    $ids = array();
    $ids[] = $parent_id;

    $query = "SELECT id FROM locations WHERE parent_id = $parent_id";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $child_id = $row['id'];
        if ($child_id == 0) {
            continue;
        }
        $ids = array_merge($ids, getChildLocationIds($conn, $child_id));
    }
    return $ids;
}

function getImmediateChildLocationIds($conn, $parent_id) {
    $ids = array();
    $query = "SELECT id FROM locations WHERE parent_id = $parent_id";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        if ($row['id'] == 0) {
            continue; // Skip if id is 0
        }
        $ids[] = $row['id'];
    }
    return $ids;
}

?>