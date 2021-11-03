<?php

// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'Chocolate321';
$DATABASE_NAME = 'php_mandatory_2';

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Make sure the submitted registration values are not empty.
if (empty($_POST['itemName']) ||
    empty($_POST['rrp']) ||
    empty($_POST['quantity']) ||
    empty($_POST['description']) ||
    empty($_POST['price'])) {
    // One or more values are empty.
    exit('Please enter a value in EVERY field');
}


// Validate input first

/*
// check for invalid characters in item name
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['itemName']) == 0) {
    exit('itemName is not valid!');
}

// check for invalid characters in description
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['description']) == 0) {
    exit('description is not valid!');
}

if($_POST['price'] < 0 || $_POST['rrp'] < 0){
    exit('price and rrp cant be negative');
}
*/

// We need to check if the item with that name already exists.
if ($stmt = $con->prepare('SELECT name FROM products WHERE name = ?')) {
    $stmt->bind_param('s', $_POST['itemName']);
    $stmt->execute();
    $stmt->store_result();

    // Store the result so we can check if the item already exists in the database.
    if ($stmt->num_rows > 0) {
        // Username already exists
        echo 'Item already exists, please choose another name!';
    }
    else
    {
        // Prepare + format date
        $date = date('Y-m-d H:i:s');
        echo $date;

        // Item is not a duplicate, add the new item
        if ($stmt = $con->prepare('INSERT INTO products (id, name, desc, price, rrp, quantity, img, date_added) VALUES (?, ?, ?, ?, ?, ?, ?)'))
        {
            $stmt->bind_param('ssddiss',
                $_POST['itemName'],
                $_POST['description'],
                $_POST['price'],
                $_POST['rrp'],
                $_POST['quantity'],
                null,
                $date);

            $stmt->execute();
            echo 'Welcome! You can now login.';

        } else {
            // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
            echo 'Could not prepare statement!';

            // TO DO: create a 'go back' button/link here
        }
    }
    $stmt->close();
} else {
    // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
    echo 'Could not prepare statement!';
}
$con->close();
?>