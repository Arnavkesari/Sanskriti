<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="user_dashboard.css">
</head>
<body>

<header>
    <?php include 'header.php'; ?>
</header>

<main class="container">
    <h2>User Dashboard</h2>

        <form action="user_dashboard_action.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name">

        <label for="userId">UserId:</label>
        <input type="text" id="userId" name="userId" disabled >
        <div id="note" >! (cannot update)</div>

        <label for="password">Pass:</label>
        <input type="password" id="password" name="password" placeholder="(xxxxx)">

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <h4 id="address">Address</h4>

        <label for="street">Street:</label>
        <input type="text" id="street" name="street">

        <label for="city">City:</label>
        <input type="text" id="city" name="city">

        <label for="state">State:</label>
        <input type="text" id="state" name="state">

        <label for="pincode">Pincode:</label>
        <input type="text" id="pincode" name="pincode">

        <div id="save">
            <button type="submit" class="submit-button">Update</button>
        </div>
    </form>
</main>

<footer>
    <?php include 'footer.php'; ?>
</footer>

</body>
</html>
