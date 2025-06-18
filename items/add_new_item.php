<html>
    <h2>Add new item:</h2>
        <form action="insert_item.php" method="POST">
            Name: <input type="text" name="name"><br>
            Expiration: <input type="text" name="expiration"><br>
            <!-- Box Number: <input type="number" name="box_number"><br>-->
            <input type="submit">
        </form>

        <form action="bulk_insert.php" method="POST">
            Add items in bulk from a file spreadsheet: 
            <input type="file" id="fileInput" name="table_file"><br>
            <input type="submit">
        </form>
        
    <h2>Cancel and redirect:</h2>
        <a href="../welcome_page.php">
            <button>Return to welcome page</button>
        </a>

        <a href="inventory.php">
            <button>View Inventory</button>
        </a>
</html>