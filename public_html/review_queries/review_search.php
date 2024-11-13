<?php
        include '../navbar.php';
        global $our_root;
        include $php_root . '/maintenance/variables.php';
        include $php_root . '/logger.php';
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Reviews</title>
    <link href="<?php echo $our_root?>/styles.css" rel="stylesheet"/>
    <link href="<?php echo $our_root?>/dishes_queries/dishes_page.css" rel="stylesheet"/>

    <style>
        body h1 {
            align-items: center;
        }
        form {
            align-items: left;
        }
    </style>
</head>
<body class="secondary">
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        try {        
            // Database connection settings

            //We create a pdo instance to connect to the database
            //$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
        
            //set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo json_encode(["error"=>"Connection failed: " . $e->getMessage()]);
        }

        
            
    ?>
</body>
</html>
