<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="<?php echo $our_root?>/styles.css" rel="stylesheet"/>
    </head>
    <?php
        include  '../navbar.php';
        include $php_root . '/maintenance/variables.php';
        include $php_root . '/maintenance/security.php';
        include $php_root . '/logger.php';
    ?>
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        /*
        First we need to connect to our server, which as we 
        know is hosted locally
        */
        try {        
            // Database connection settings

            //We create a pdo instance to connect to the database
            //$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
        
            //set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //USERS
            $relQ = $conn->prepare("SELECT G.did1, D1.name AS name1, G.did2, D2.name AS name2
            FROM goes_with G, dishes D1, dishes D2
            WHERE G.did1 = D1.did AND G.did2 = D2.did
            ");
            $relQ->execute();
            $rel = $relQ->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed or query: " . $e->getMessage();
        }        
    ?>
    <body>
        <div  class="secondary text">
        <!--We fetch all the users-->
        <h1>Pairs of dishes that go well with one another:</h1>
        <table class="background">
            <tr class="secondary">
                <th>did1</th>
                <th>name</th>
                <th>did2</th>
                <th>name</th>
            </tr>
            <!--We take data in a loop-->
            <?php if (is_array($rel)>0  && count($rel) > 0):?>
                <?php foreach ($rel as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['did1']); ?></td>
                        <td><?php echo htmlspecialchars($row['name1']); ?></td>
                        <td><?php echo htmlspecialchars($row['did2']); ?></td>
                        <td><?php echo htmlspecialchars($row['name2']); ?></td>   
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No pairs found</td>
                </tr>
            <?php endif; ?>
        </table>        
        <a href="<?php echo $our_root?>/maintenance/maintenance.php">back to maintenance</a>
        </div>
    </body>
</html>
