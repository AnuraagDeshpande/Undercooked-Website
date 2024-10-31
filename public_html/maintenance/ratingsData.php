<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="/styles.css" rel="stylesheet"/>
    </head>
    <?php
        include 'security.php';
    ?>
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/navbar.php';
    ?>
    <?php
        include 'variables.php';
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

            //RATINGS
            $ratingsQ = $conn->prepare("SELECT U.uid, U.login, R.rating, D.did, D.name
            FROM users U, rated R, dishes D
            WHERE U.uid=R.uid and R.did=D.did
            ");
            $ratingsQ->execute();
            $ratings = $ratingsQ->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed or query: " . $e->getMessage();
        }        
    ?>
    <body class="secondary text">
        <!--We fetch all the ratings data-->
        <h1>Ratings:</h1>
        <table class="background">
            <tr class="secondary">
                <th>uid</th>
                <th>login</th>
                <th>rating</th>
                <th>did</th>
                <th>dish</th>
            </tr>
            <!--We take data in a loop-->
            <?php if (is_array($ratings)>0  && count($ratings) > 0):?>
                <?php foreach ($ratings as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['uid']); ?></td>
                        <td><?php echo htmlspecialchars($row['login']); ?></td>
                        <td><?php echo htmlspecialchars($row['rating']); ?></td>     
                        <td><?php echo htmlspecialchars($row['did']); ?></td>  
                        <td><?php echo htmlspecialchars($row['name']); ?></td>  
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No ratings found</td>
                </tr>
            <?php endif; ?>
        </table>        
        <a href="./maintenance.php">back to maintenance</a>
    </body>
</html>
