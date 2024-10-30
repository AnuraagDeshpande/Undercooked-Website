<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Dish Pairings</title>
    <link href="../styles.css" rel="stylesheet"/>
    <link href="../dishes_queries/dishes_page.css" rel="stylesheet"/>
    <style>
        input {
            margin: 5px;
            padding: 5px;
        }
        label {
            font-size: 25px;
        }
        div.review p {
            margin: 10px;
            font-size: 20px;
        }
        p.error {
            margin: 10px;
            font-size: 40px;
            align-items: center;
            text-align: center;
        }
    </style>
</head>
<?php
    include './maintenance/variables.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    /*
    First we need to connect to our server, which as we 
    know is hosted locally
    */
    $errorCode=0;
    try {
        $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
    
        //set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login = $_POST['login'];
        try {
            $sql = "SELECT U.login, U.password
            FROM users U
            WHERE U.login=:login";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':login', $login);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e){
            echo "Fetching data failed" . $e->getMessage();
        }
        if (isset($_POST['pass'])){
            $pass = $_POST['pass'];
            if ($data!=NULL && $data['password']==$pass){
                //the user should be logged in
                $errorCode=-1;
            } elseif ($data!=NULL && $data['password']!=$pass){
                $errorCode=1;
            } else {
                $errorCode=2;
            }
        } elseif (isset($_POST['pass1'])){
            if ($data!=NULL){
                $errorCode=3;
            } else {
                try{
                    //we get data an analyze it
                    
                    $pass1 = $_POST['pass1'];
                    $pass2 = $_POST['pass2'];
                    $critic = 0;
                    
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
                        $errorCode=4;
                        $error_message = "Passwords do not match.";
                    }         
                } catch(PDOException $e){
                    $errorCode=5;
                    echo "Insertion failed: " . $e->getMessage();
                }
            }
        }
    }    
?>
<body class="secondary">
    <?php include './navbar.php'; ?>
    <!--Here a registered user can login-->
    <?php if($errorCode==-1):?>
        <p class="error">
            User successfully loged in
        </p>
    <?php elseif($errorCode==1):?>
        <p class="error">
            Wrog password entered
        </p>
    <?php elseif($errorCode==2):?>
        <p class="error">
            No such user found
        </p>
    <?php elseif($errorCode==3):?>
        <p class="error">
            Such user already exists
        </p>
    <?php endif;?>
    <form  method="POST" class="secondary">
        <div class="review">
            <h1>Enter your credentials:</h1>
            <p>
                Only English alphabet and numbers can be entered.
            </p>
            <!--The user has to input the login-->
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" pattern="[A-Za-z0-9]+" minlength="5" maxlength="20" required>
            <!--Password has to be entered here-->
            <h2></h2>
            <label for="pass">Password:</label>
            <input type="password" name="pass" id="pass" pattern="[A-Za-z0-9]+" minlength="5" maxlength="20" required>
            <!--The user can submit the form contents by pressing a button-->
            <h2></h2>
            <input type="submit" value="Login" class="background">
            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>
    </form>

    <!--Here a new user can join-->
    <form class="secondary" method="POST">
        <div class="review">
        <h1>Register:</h1>
            <p>
                Don't have an account yet? Create one today!
            </p>
            <!--The user has to input the login-->
            <h2>New login:</h2>
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" pattern="[A-Za-z0-9]+" minlength="5" maxlength="20"equired>
            <!--Password has to be entered twice in order to check-->
            <h2>Enter your password twice to confirm</h2>
            <label for="pass1">Password:</label>
            <input type="password" name="pass1" id="pass1" pattern="[A-Za-z0-9]+" minlength="5" maxlength="20"required>
            <h2></h2>
            <label for="pass2">Password:</label>
            <input type="password" name="pass2" id="pass2" pattern="[A-Za-z0-9]+" minlength="5" maxlength="20"required>
            <!--The user can submit the form contents by pressing a button-->
            <h2></h2>
            <input type="submit" value="register" class="background">

            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>
    </form>
</body>
</html>
