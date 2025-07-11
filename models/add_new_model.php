<html>
    <h2>Add new model:</h2>
        <form action="insert_model.php" method="POST" enctype="multipart/form-data">
            Name: <input type="text" name="name"><br>   
            Part Number: <input type="text" name="part_number"><br>
            Category: <input type="text" name="category"><br>
            Image: <input type="file" name="image" width="50" height="50"><br>
            <input type="submit">
        </form>

        <form action="bulk_insert_model.php" method="POST">
            Add models in bulk from a file spreadsheet: 
            <input type="text" hidden type="model"><br>   
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