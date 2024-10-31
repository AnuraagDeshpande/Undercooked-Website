<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="../styles.css" rel="stylesheet"/>
    </head>
    <?php
        include '../navbar.php';
        include 'security.php';
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

            //USERS
            $reviewQ = $conn->prepare("SELECT u.login, u.uid, r.content, d.name, d.did
            FROM users u, reviews r, reviewed rv, has_review hr, dishes d
            WHERE u.uid = rv.uid 
            AND rv.rid = r.rid 
            AND r.rid = hr.rid 
            AND hr.did = d.did;
            ");
            $reviewQ->execute();
            $review = $reviewQ->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed or query: " . $e->getMessage();
        }        
    ?>
    <body class="secondary text">
        <!--We fetch all the users-->
        <h1>Review data:</h1>
        <table class="background">
            <tr class="secondary">
                <th>did</th>
                <th>name</th>
                <th>uid</th>
                <th>login</th>
                <th>review</th>
            </tr>
            <!--We take data in a loop-->
            <?php if (is_array($review)>0  && count($review) > 0):?>
                <?php foreach ($review as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['did']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['uid']); ?></td>
                        <td><?php echo htmlspecialchars($row['login']); ?></td>  
                        <td><?php echo htmlspecialchars($row['content']); ?></td> 
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No reviews left by users yet</td>
                </tr>
            <?php endif; ?>
        </table>        
        <a href="./maintenance.php">back to maintenance</a>
    </body>
</html>
