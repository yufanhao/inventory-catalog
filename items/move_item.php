<?php
require_once '../db.php';

class LocationManager {
    private $db;
    
    public function __construct($database_connection) {
        $this->db = $database_connection;
    }
    
    /**
     * Get full hierarchical path for a location
     */
    public function getLocationPath($location_id) {
        $path = array();
        $current_id = $location_id;
        
        while ($current_id) {
            $query = "SELECT id, name, parent_id FROM locations WHERE id = " . intval($current_id);
            $result = $this->db->query($query);
            
            if ($row = $result->fetch_assoc()) {
                array_unshift($path, $row['name']);
                $current_id = $row['parent_id'];
            } else {
                break;
            }
        }
        
        return implode(' > ', $path);
    }
    
    /**
     * Get all locations as hierarchical tree
     */
    public function getLocationTree($exclude_location_id = 0) {
        // Get all locations
        $query = "SELECT id, name, parent_id FROM locations ORDER BY parent_id, name";
        $result = $this->db->query($query);
        
        $locations = array();
        while ($row = $result->fetch_assoc()) {
            $locations[] = $row;
        }
        
        // Build tree structure
        return $this->buildTree($locations, 0, $exclude_location_id);
    }
    
    /**
     * Build tree structure recursively
     */
    private function buildTree($locations, $parent_id = 0, $exclude_id = 0) {
        $tree = array();
        
        foreach ($locations as $location) {
            if ($location['parent_id'] == $parent_id && $location['id'] != $exclude_id  && $location['id'] != 0) {
                $location['children'] = $this->buildTree($locations, $location['id'], $exclude_id);
                $tree[] = $location;
            }
        }
        
        return $tree;
    }
    
    /**
     * Check if location can contain items (no circular reference)
     */
    public function isValidDestination($source_location_id, $destination_location_id) {
        // Prevent moving to same location
        if ($source_location_id == $destination_location_id) {
            return false;
        }
        
        // Check if destination is a child of source (circular reference)
        $current_id = $destination_location_id;
        while ($current_id) {
            $query = "SELECT parent_id FROM locations WHERE id = " . intval($current_id);
            $result = $this->db->query($query);
            
            if ($row = $result->fetch_assoc()) {
                if ($row['parent_id'] == $source_location_id) {
                    return false;
                }
                $current_id = $row['parent_id'];
            } else {
                break;
            }
        }
        
        return true;
    }
    
    /**
     * Move item to new location
     */
    public function moveItem($item_id, $new_location_id) {
        $item_id = intval($item_id);
        $new_location_id = intval($new_location_id);
        
        $query = "UPDATE items SET location_id = $new_location_id WHERE id = $item_id";
        return $this->db->query($query);
    }
    
    /**
     * Get item details
     */
    public function getItem($item_id) {
        $query = "SELECT i.*, l.name as location_name 
                  FROM items i 
                  LEFT JOIN locations l ON i.location_id = l.id 
                  WHERE i.id = " . intval($item_id);
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }
}

$locationManager = new LocationManager($conn);

// Handle form submission
$message = '';
$error = '';

if ($_POST['action'] == 'move_item' && $_POST['item_id'] && $_POST['new_location_id']) {
    $item_id = intval($_POST['item_id']);
    $new_location_id = intval($_POST['new_location_id']);
    
    // Get current item details
    $item = $locationManager->getItem($item_id);
    
    if ($item) {
        if ($locationManager->isValidDestination($item['location_id'], $new_location_id)) {
            if ($locationManager->moveItem($item_id, $new_location_id)) {
                $new_path = $locationManager->getLocationPath($new_location_id);
                $message = "Item '{$item['name']}' successfully moved to: $new_path";
                
                // Refresh item data
                $item = $locationManager->getItem($item_id);
            } else {
                $error = "Database error occurred while moving item.";
            }
        } else {
            $error = "Invalid destination location selected.";
        }
    } else {
        $error = "Item not found.";
    }
}

// Get item for display
$item_id = intval($_POST['item_id']);
$item = null;

if ($item_id) {
    $item = $locationManager->getItem($item_id);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Move Item - Inventory Management</title>
    <style>
        .location-children { margin-left: 20px; display: none; }
        .location-children.expanded { display: block; }
        .expand-icon { display: inline-block; width: 20px; }
        .selectable-location { cursor: pointer; }
        .selectable-location.selected { background-color: #ccc; }
    </style>
    <script>
        var selectedLocationId = null;
        
        function toggleLocation(element, locationId) {
            var children = element.nextElementSibling;
            var icon = element.querySelector('.expand-icon');
            
            if (children.classList.contains('expanded')) {
                children.classList.remove('expanded');
                icon.innerHTML = '+';
            } else {
                children.classList.add('expanded');
                icon.innerHTML = '-';
            }
        }
        
        function selectLocation(element, locationId, locationName) {
            // Remove previous selection
            var previous = document.querySelector('.selectable-location.selected');
            if (previous) {
                previous.classList.remove('selected');
            }
            
            // Select new location
            element.classList.add('selected');
            selectedLocationId = locationId;
            
            // Update form and button
            document.getElementById('new_location_id').value = locationId;
            document.getElementById('selected_location_name').innerHTML = locationName;
            document.getElementById('move_button').disabled = false;
        }
        
        function confirmMove() {
            if (selectedLocationId) {
                var locationName = document.getElementById('selected_location_name').innerHTML;
                return confirm('Move item to: ' + locationName + '?');
            }
            return false;
        }
    </script>
</head>
<body>
    <div>
        <h1>Move Item</h1>
        
        <?php if ($message): ?>
            <p style="color: green;"><strong><?php echo htmlspecialchars($message); ?></strong></p>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <p style="color: red;"><strong><?php echo htmlspecialchars($error); ?></strong></p>
        <?php endif; ?>
        
        <?php if ($item): ?>
            <!-- Current Location Panel -->
            <h3>Current Item Location</h3>
            <p><strong>Item:</strong> <?php echo htmlspecialchars($item['name']); ?></p>
            <p><strong>Current Location:</strong> <?php echo htmlspecialchars($locationManager->getLocationPath($item['location_id'])); ?></p>
            
            <!-- Destination Panel -->
            <h3>Select New Location</h3>
            <p>Click on a location below to select it as the destination:</p>
            <p><strong>Selected:</strong> <span id="selected_location_name">None</span></p>
                <div>
                    <?php
                    function renderLocationTree($tree, $current_location_id) {
                        foreach ($tree as $location) {
                            $has_children = !empty($location['children']);
                            $is_current = ($location['id'] == $current_location_id);
                            
                            if ($has_children) {
                                echo '<div onclick="toggleLocation(this, ' . $location['id'] . ')" style="cursor: pointer;">';
                                echo '<span class="expand-icon">+</span>';
                                echo '<strong>' . htmlspecialchars($location['name']) . '</strong>';
                                if ($is_current) echo ' <em>(current)</em>';
                                echo '</div>';
                                
                                echo '<div class="location-children">';
                                renderLocationTree($location['children'], $current_location_id);
                                echo '</div>';
                            } else {
                                if (!$is_current) {
                                    echo '<div class="selectable-location" onclick="selectLocation(this, ' . $location['id'] . ', \'' . htmlspecialchars($location['name']) . '\')">';
                                    echo '<span class="expand-icon">&nbsp;</span>';
                                    echo htmlspecialchars($location['name']);
                                    echo '</div>';
                                } else {
                                    echo '<div>';
                                    echo '<span class="expand-icon">&nbsp;</span>';
                                    echo htmlspecialchars($location['name']) . ' <em>(current)</em>';
                                    echo '</div>';
                                }
                            }
                        }
                    }
                    
                    $tree = $locationManager->getLocationTree(isset($item['location_id']) && $item['location_id'] ? $item['location_id'] : null);
                    renderLocationTree($tree, $item['location_id']);
                    ?>
                </div>
            </div>
            
            <form method="post" onsubmit="return confirmMove()">
                <input type="hidden" name="action" value="move_item">
                <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                <input type="hidden" name="new_location_id" id="new_location_id" value="">
                
                <p>
                    <button type="submit" id="move_button" disabled>Move Item</button>
                </p>
            </form>
            <form action ='../models/view_models.php' method = 'get'>
                <button type = 'submit'>Return to Full Inventory</button><br>
            </form>
            
        <?php else: ?>
            <p style="color: red;"><strong>No item specified. Please select an item to move.</strong></p>
        <?php endif; ?>
    </div>
</body>
</html>