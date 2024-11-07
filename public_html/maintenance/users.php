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
        include $_SERVER['DOCUMENT_ROOT'] . '/maintenance/variables.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/maintenance/security.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/logger.php';
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
            $usersQ = $conn->prepare("SELECT U.uid, U.isCritic, U.login, U.password, U.isAdmin
            FROM users U
            ");
            $usersQ->execute();
            $users = $usersQ->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed or query: " . $e->getMessage();
        }        
    ?>
    <body>
        <div  class="secondary text">
        <!--We fetch all the users-->
        <h1>Registered users:</h1>
        <table class="background">
            <tr class="secondary">
                <th>uid</th>
                <th>isCritic</th>
                <th>login</th>
                <th>password</th>
                <th>isAdmin</th>
            </tr>
            <!--We take data in a loop-->
            <?php if (is_array($users)>0  && count($users) > 0):?>
                <?php foreach ($users as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['uid']); ?></td>
                        <td><?php echo $row['isCritic'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo htmlspecialchars($row['login']); ?></td>
                        <td><?php echo htmlspecialchars($row['password']); ?></td>
                        <td><?php echo htmlspecialchars($row['isAdmin']); ?></td>     
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No users found</td>
                </tr>
            <?php endif; ?>
        </table>        
        <a href="/maintenance/maintenance.php">back to maintenance</a>
        </div>
    </body>
</html>
