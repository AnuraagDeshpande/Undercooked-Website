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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try{
                //we get data an analyze it
                $login = $_POST['login'];
                $pass1 = $_POST['pass1'] ?? "no";
                $pass2 = $_POST['pass2'] ?? "no";;
                $critic = isset($_POST['critic']) ? 1 : 0;

                if($pass1 == $pass2){
                    $sql = "INSERT INTO users (isCritic, login, password) VALUES (:isCritic, :login, :password)";

                    $stmt = $conn->prepare($sql);            
                    //We bind the parameters to the SQL query
                    $stmt->bindParam(':login', $login);
                    $stmt->bindParam(':isCritic', $critic, PDO::PARAM_BOOL);
                    $stmt->bindParam(':password', $pass1);
                    //execute
                    $stmt->execute();

                    header("Location: signupSuc.html");
                    exit();
                } else {
                    $error_message = "Passwords do not match.";
                }         
            } catch(PDOException $e){
                echo "Insertion failed: " . $e->getMessage();
            }
        }
        
    ?>
    <body>
        <form  method="POST" class="db_query secondary">
            <h1>Sign Up to Undercooked:</h1>
            <!--The user has to input the login-->
            <h2>Enter your desired login:</h2>
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" required minlength="5" maxlength="20" class="background" required>
            <!--Password has to be entered twice in order to check-->
            <h2>Enter your password twice to confirm</h2>
            <label for="pass1">Password:</label>
            <input type="password" name="pass1" id="pass1" required minlength="5" maxlength="20" class="background" required>
            <h2></h2>
            <label for="pass2">Password:</label>
            <input type="password" name="pass2" id="pass2" required minlength="5" maxlength="20" class="background" required>
            <h2></h2>
            <input type="checkbox" name="critic" id="critic">
            <label for="critic">become critic</label>

            <!--The user can submit the form contents by pressing a button-->
            <h2></h2>
            <input type="submit" value="add" class="accent">

            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </form>
    </body>
</html>
