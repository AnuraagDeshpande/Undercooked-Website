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
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        try{
            //we get the names of dishes
            $dishesQ = $conn->prepare("SELECT D.did, D.name
            FROM dishes D
            ");
            $dishesQ->execute();
            $dishes = $dishesQ->fetchAll(PDO::FETCH_ASSOC);
            //we get the users
            $usersQ = $conn->prepare("SELECT U.uid, U.login, U.password
            FROM users U
            ");
            $usersQ->execute();
            $users = $usersQ->fetchAll(PDO::FETCH_ASSOC);   
        } catch(PDOException $e){
            echo "Fetching data failed" . $e->getMessage();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try{
                $did = $_POST['dish'];
                $uid = $_POST['user'];
                $rating = $_POST['rating'];
              
                $sql = "INSERT INTO rated (uid, did,rating) VALUES (:uid, :did, :rating)";

                $stmt = $conn->prepare($sql);            
                //We bind the parameters to the SQL query
                $stmt->bindParam(':uid', $uid);
                $stmt->bindParam(':did', $did);
                $stmt->bindParam(':rating', $rating);
                //execute
                $stmt->execute();

                header("Location: rated.html");
                exit();
                       
            } catch(PDOException $e){
                echo "Insertion failed: " . $e->getMessage();
            }
        }
        
    ?>
    <body>
        <form  method="POST" class="db_query secondary">
            <h1>Rate a dish:</h1>
            <!--The user has to choose the login-->
            <!--This is ok for now since its for maintenance page-->
            <h2>Choose user:</h2>
            <select name="user" required>
                <?php if (is_array($users)>0  && count($users) > 0):?>
                    <?php foreach ($users as $row): ?>
                        <option value="<?php echo $row['uid']; ?>" ><?php echo htmlspecialchars($row['login']); ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <!--The user has to choose a dish-->
            <h2>Choose a dish to rate:</h2>
            <select name="dish" required>
            <?php if (is_array($dishes)>0  && count($dishes) > 0):?>
                    <?php foreach ($dishes as $row): ?>
                        <option value="<?php echo $row['did']; ?>" ><?php echo htmlspecialchars($row['name']); ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <!--The user has rate the dish-->
            <h2>Give your rating:</h2>
            <p>the scale goes 1 to 5:</p>
            <input type="range" name="rating" class="accent" min=1 max=5 step="1" id="rating" required>            
            <!--The user can submit the form contents by pressing a button-->
            <h2></h2>
            <input type="submit" value="add" class="accent">

            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </form>
        <a href="./maintenance.html">back to maintenance</a>
    </body>
</html>
