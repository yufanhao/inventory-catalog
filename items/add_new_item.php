<html>
    <h2>Add new item:</h2>
        <form action="insert_item.php" method="POST" enctype="multipart/form-data">
            Serial Number: <input type="text" name="serial_number"><br>
            Model Name: <input type="text" name="model_name"><br>
            Expiration: <input type="date" id="expiration" name="expiration"><br>
            Location Type: <select name="location_type">
                <option value="box">Box</option>
                <option value="cabinet">Cabinet</option>
                <option value="shelf">Shelf</option>
                <option value="floor">Floor</option>
                <option value="other">Other</option></select><br>
            Location Number(i.e. box number, etc): <input type="number" name="number"><br>
            <input type="submit">
        </form>

        <form action="bulk_insert_item.php" method="POST">
            Add items in bulk from a file spreadsheet: 
            <input type="file" id="fileInput" name="table_file"><br>
            <input type="submit">
        </form>
        
    <h2>Cancel and redirect:</h2>
        <a href="../welcome_page.php">
            <button>Return to welcome page</button>
        </a>

        <a href="../models/view_models.php">
            <button>View Inventory</button>
        </a>
</html>