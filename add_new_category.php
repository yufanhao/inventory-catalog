<html>
    <h2>Add new category:</h2>
        <form action="insert_category.php" method="POST" enctype="multipart/form-data">
            Name: <input type="text" name="name"><br>   
            <input type="submit">
        </form>
        
    <h2>Cancel and redirect:</h2>
        <a href="welcome_page.php">
            <button>Return to welcome page</button>
        </a>

        <a href="models/view_models.php">
            <button>View Inventory</button>
        </a>
</html>