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
        'floor' => ""
    );

    // Traverse up the location hierarchy to get all location types and numbers
    while ($location_type != 'ancestor' AND $flag == FALSE) {
        if (!$location) {
            echo "Location not found for item. Please check the database.";
            $flag = TRUE;
            break;
        }
        $location_number = $location['number'];
        $location_array[$location_type] = $location_number;

        $parent_id = $location['parent_id'];
        $parent_sql = "SELECT * FROM locations WHERE id = $parent_id";
        $parent = $conn->query($parent_sql)->fetch_assoc();
        $location = $parent;
        $location_type = $location["type"];
    }
    return $location_array;
}
?>