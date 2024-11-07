<?php 
    include '../navbar.php';
    global $our_root;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Dish Pairings</title>
    <link href="<?php echo $our_root?>/styles.css" rel="stylesheet"/>
</head>
<style>
        div.text h1 {
            margin: 10px;
            font-size: 70px;
            align-items: center;
            text-align: center;
        }
    </style>
<body class="secondary">
    <?php
        include $php_root . '/logger.php';
    ?>
    <div class="text">
    <h1>Ouch!</h1>
    <h2>This page is not meant for you! Return back to safety.</h2>
    </div>
</body>
</html>
