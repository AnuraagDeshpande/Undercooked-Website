<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="styles.css" rel="stylesheet"/>
    </head>
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
            $host = 'localhost';
            $dbname = 'test';
            $username = 'root';        
            $password = ''; 
            $socket = '/opt/lampp/var/mysql/mysql.sock'; 

            //We create a pdo instance to connect to the database
            //$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
        
            //set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //MAIN DISHES
            $mainQ = $conn->prepare("SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, ND.inBowl, ND.onPlate, M.hasMeat, M.hasFish, M.hasChicken
            FROM dishes D, non_drinks ND, main_dishes M
            WHERE D.did = ND.did AND ND.did = M.did
            ");
            $mainQ->execute();
            $main = $mainQ->fetchAll(PDO::FETCH_ASSOC);

            //SIDE DISHES
            $sideQ = $conn->prepare("SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, ND.inBowl, ND.onPlate, S.hasVegetables
            FROM dishes D, non_drinks ND, side_dishes S
            WHERE D.did = ND.did AND ND.did = S.did
            ");
            $sideQ->execute();
            $side = $sideQ->fetchAll(PDO::FETCH_ASSOC);
            //DESERTS
            $desertQ = $conn->prepare("SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, ND.inBowl, ND.onPlate, DS.isCold, DS.hasFruit
            FROM dishes D, non_drinks ND, desert_dishes DS
            WHERE D.did = ND.did AND ND.did = DS.did
            ");
            $desertQ->execute();
            $desert = $desertQ->fetchAll(PDO::FETCH_ASSOC);
            //DRINKS
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }        
    ?>
    <body class="secondary text">
        <!--We fetch all the main dishes-->
        <h1>Main dishes:</h1>
        <table class="background">
            <tr class="secondary">
                <th>name</th>
                <th>price</th>
                <th>halal</th>
                <th>vegan</th>
                <th>vegetarian</th>
                <th>bowl</th>
                <th>plate</th>
                <th>meat</th>
                <th>fish</th>
                <th>chicken</th>
            </tr>
            <!--We take data in a loop-->
            <?php if (is_array($main)>0  && count($main) > 0):?>
                <?php foreach ($main as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo $row['isVegan'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['isVegetarian'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['isHalal'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['inBowl'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['onPlate'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['hasMeat'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['hasFish'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['hasChicken'] ? 'Yes' : 'No'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No dishes found.</td>
                </tr>
            <?php endif; ?>
        </table>

        <!--We fetch all the side dishes-->
        <h1>Desert dishes:</h1>
        <table class="background">
            <tr class="secondary">
                <th>name</th>
                <th>price</th>
                <th>halal</th>
                <th>vegan</th>
                <th>vegetarian</th>
                <th>bowl</th>
                <th>plate</th>
                <th>cold</th>
                <th>fruit</th>
            </tr>
            <!--We take data in a loop-->
            <?php if (is_array($desert)>0  && count($desert) > 0):?>
                <?php foreach ($desert as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo $row['isVegan'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['isVegetarian'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['isHalal'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['inBowl'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['onPlate'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['isCold'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['hasFruit'] ? 'Yes' : 'No'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No dishes found.</td>
                </tr>
            <?php endif; ?>
        </table>

        <!--We fetch all the side dishes-->
        <h1>Side dishes:</h1>
        <table class="background">
            <tr class="secondary">
                <th>name</th>
                <th>price</th>
                <th>halal</th>
                <th>vegan</th>
                <th>vegetarian</th>
                <th>bowl</th>
                <th>plate</th>
                <th>vegetables</th>
            </tr>
            <!--We take data in a loop-->
            <?php if (is_array($side)>0  && count($side) > 0):?>
                <?php foreach ($side as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo $row['isVegan'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['isVegetarian'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['isHalal'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['inBowl'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['onPlate'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo $row['hasVegetables'] ? 'Yes' : 'No'; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No dishes found.</td>
                </tr>
            <?php endif; ?>
        </table>
        <a href="./maintenance.html">back to maintenance</a>
    </body>
</html>
