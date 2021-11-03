<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
include 'functions.php';

$pdo = pdo_connect_mysql();
// Get the 4 most recently added products
$stmt = $pdo->prepare('SELECT * FROM products ORDER BY date_added DESC LIMIT 4');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}
?>


<?=template_header('Home')?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body class="loggedin">

<div class="content">
    <h2>Home</h2>
    <p>Welcome back, <?=$_SESSION['name']?>!</p>
</div>
</body>
</html>

<!--
<div class="featured">
    <h2>Gadgets</h2>
    <p>Essential gadgets for everyday use</p>
</div>
-->

<div class="recentlyadded content-wrapper">
    <h2>Recently Added Products</h2>
    <div class="products">
        <?php foreach ($recently_added_products as $product): ?>
            <a href="index.php?page=product&id=<?=$product['id']?>" class="product">
                <img src="imgs/<?=$product['img']?>" width="200" height="200" alt="<?=$product['name']?>">
                <span class="name"><?=$product['name']?></span>
                <span class="price">
                &dollar;<?=$product['price']?>
                    <?php if ($product['rrp'] > 0): ?>
                        <span class="rrp">&dollar;<?=$product['rrp']?></span>
                    <?php endif; ?>
            </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<?=template_footer()?>






