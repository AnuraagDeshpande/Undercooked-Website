<?php
        include '../navbar.php';
        global $our_root;
        include $php_root . '/maintenance/security.php';
        include $php_root . '/logger.php';
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="<?php echo $our_root?>/styles.css" rel="stylesheet"/>
    </head>
    <body>
        <div class = "secondary text">
        <h1>Review was submitted!</h1>
        <ul>
            <a href="<?php echo $our_root?>/maintenance/maintenance.php">back to maintenance</a>
        </ul>
        </div>
    </body>
</html>