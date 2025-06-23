<html>
    <body>
        <form action="./users/insert_user.php" method="POST">
            Username: <input type="text" name="username"><br>
            Email: <input type="text" name="email"><br>
            Password: <input type="password" name="password"><br>
            <input type="submit">
        </form>
        <a href="welcome_page.php">
            <!-- This works now, but should it be here? Welcome page should be seen after log in/sign up -->
            <button>Return to welcome page</button>
        </a>
    </body>
</html>