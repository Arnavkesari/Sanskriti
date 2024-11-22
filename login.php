<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
</head>
   
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>

    <?php if (isset($_GET['newuser']) && $_GET['newuser'] == 'true'): ?>
    <p style="color: green; text-align: center; font-weight: bold; margin-top: 20px;">User created successfully, login now</p>
    <?php endif; ?>

    <main class="container" >
        <h2>LOGIN</h2>
        <form class="form-container" action="login_action.php" method="POST">
            <label for="ID">User ID:</label>
            <input type="text" id="ID" name="ID" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <div id="save">
                <button type="button" class="register-button" ><a href="register.php" > Register</a> </button>
                <button type="submit" class="submit-button">Login Now</button>
            </div>
        </form>
    </main>
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>
