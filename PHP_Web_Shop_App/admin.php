<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
include 'functions.php';
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'Chocolate321';
$DATABASE_NAME = 'php_mandatory_2';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT password, email, isAdmin FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $isAdmin);
$stmt->fetch();
$stmt->close();

?>

<?=template_header('Admin Interface')?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Add New Item</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    </head>
    <body class="loggedin">

    <div class="content">
        <h2>Add New Item</h2>
        <div>
            <p>Enter item details below:</p>
            <form action="authenticateItem.php" method="post">
                <table>
                    <tr>
                        <td> <input type = "text" name = "itemName" placeholder="Item Name" id = "itemName"></td>
                    </tr>
                    <tr>
                        <td>  <input type = "text" name = "description" placeholder="Description" id = "description"></td>
                    </tr>
                    <tr>
                        <td>  <input type = "number" name = "price" placeholder="Price" id = "price"></td>
                    </tr>
                    <tr>
                        <td>  <input type = "number" name = "rrp" placeholder="RRP" id = "rrp"></td>
                    </tr>
                    <tr>
                        <td>  <input type = "number" name = "quantity" placeholder="Quantity" id = "quantity"></td>
                    </tr>
                    <tr>
                        <td>  <input type="submit" value="Add Item"></td>
                    </tr>

                </table>
            </form>

        </div>
    </div>
    </body>
    </html>

<?=template_footer()?>