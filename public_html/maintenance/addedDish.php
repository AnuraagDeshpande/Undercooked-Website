<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="/styles.css" rel="stylesheet"/>
    </head>
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/navbar.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/maintenance/security.php';
    ?>
    <body>
        <div  class = "secondary text">
        <h1>A dish was successfully added</h1>
        <ul>
            <a href="/maintenance/maintenance.php">back to maintenance</a>
        </ul>
        </div>
    </body>
</html>