<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="styles.css" rel="stylesheet"/>
    </head>
    <?php

        //ini_set('display_errors', 1);
        //ini_set('display_startup_errors', 1);
        //error_reporting(E_ALL);
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
        /*
        Now we insert the data based on type, because of our schema we 
        have a certain amount of branching present
        */
        try{
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sql = "INSERT INTO dishes (name, isHalal, isVegan, isVegetarian, price) 
            VALUES (:name, :halal, :vegan, :vegetarian, :price)";

            $stmt = $conn->prepare($sql);
            //we get values
            $name = $_POST['name'];
            $type = $_POST['dish_type'];
            $vegan = isset($_POST['vegan']) ? 1 : 0;
            $vegetarian = isset($_POST['vegetarian']) ? 1 : 0;
            $halal = isset($_POST['halal']) ? 1 : 0;
            $price = $_POST['price'];
            //We bind the parameters to the SQL query
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':halal', $halal, PDO::PARAM_BOOL);
            $stmt->bindParam(':vegan', $vegan, PDO::PARAM_BOOL);
            $stmt->bindParam(':vegetarian', $vegetarian, PDO::PARAM_BOOL);
            $stmt->bindParam(':price', $price);;
            //execute
            $stmt->execute();

            $id = $conn->lastInsertId();
            //DRINKS
            if ($type == "drink"){
                $cold = isset($_POST['cold']) ? 1 : 0;
                $hot = isset($_POST['hot']) ? 1 : 0;
                //we insert a drink following a similar logic
                $sql = "INSERT INTO drinks (did, isCold, isHot) VALUES (:did, :isCold, :isHot)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':did', $id);
                $stmt->bindParam(':isCold', $cold, PDO::PARAM_BOOL);
                $stmt->bindParam(':isHot', $hot, PDO::PARAM_BOOL);
                $stmt->execute();
            //NON DRINKS
            } else {
                $bowl = isset($_POST['bowl']) ? 1 : 0;
                $plate = isset($_POST['plate']) ? 1 : 0;
                //we insert a non drink following a similar  as before
                $sql = "INSERT INTO non_drinks (did, inBowl, onPlate) VALUES (:did, :inBowl, :onPlate)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':did', $id);
                $stmt->bindParam(':inBowl', $bowl, PDO::PARAM_BOOL);
                $stmt->bindParam(':onPlate', $plate, PDO::PARAM_BOOL);
                $stmt->execute();
                //MAIN
                if ($type == "main"){
                    $meat = isset($_POST['meat']) ? 1 : 0;
                    $fish = isset($_POST['fish']) ? 1 : 0;
                    $chicken = isset($_POST['chicken']) ? 1 : 0;
                    //we insert a drink following a similar logic
                    $sql = "INSERT INTO main_dishes (did, hasMeat, hasFish, hasChicken) VALUES (:did, :hasMeat, :hasFish, :hasChicken)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':did', $id);
                    $stmt->bindParam(':hasMeat', $meat, PDO::PARAM_BOOL);
                    $stmt->bindParam(':hasFish', $fish, PDO::PARAM_BOOL);
                    $stmt->bindParam(':hasChicken', $chicken, PDO::PARAM_BOOL);
                    $stmt->execute();
                //SIDE
                } else if ($type == "side"){
                    $vegetables = isset($_POST['vegetables']) ? 1 : 0;
                    //we insert a drink following a similar logic
                    $sql = "INSERT INTO side_dishes (did, hasVegetables) VALUES (:did, :hasVegetables)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':did', $id);
                    $stmt->bindParam(':hasVegetables', $vegetables, PDO::PARAM_BOOL);
                    $stmt->execute();
                //DESERT
                } else {
                    $coldD = isset($_POST['coldD']) ? 1 : 0;
                    $fruit = isset($_POST['fruit']) ? 1 : 0;
                    //we insert a drink following a similar logic
                    $sql = "INSERT INTO desert_dishes (did, isCold, hasFruit) VALUES (:did, :isCold, :hasFruit)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':did', $id);
                    $stmt->bindParam(':isCold', $coldD, PDO::PARAM_BOOL);
                    $stmt->bindParam(':hasFruit', $fruit, PDO::PARAM_BOOL);
                    
                    $stmt->execute();
                }
            }
            header("Location: addedDish.html");
            }
        } catch(PDOException $e){
            echo "Insertion failed: " . $e->getMessage();
        }
    ?>
    <body>
        <form  method="POST" class="db_query secondary">
            <h1>Add a dish:</h1>
            <!--The user has to input the name-->
            <h2>Input the name of the new dish</h2>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required minlength="5" maxlength="100">
            <h2></h2>
            <label for="number">Price:</label>
            <input type="number" name="price"  id="price" step="0.1" min="0" max="10" required>
            <!--Here the user can select the dish type-->
            <h2>Type of dish:</h2>
            <input type="radio" onclick="([].slice.call(document.getElementsByTagName('input'))).filter(x => x.type == 'checkbox' && x.parentElement.className != 'db_query secondary').forEach(x => x.checked = 0)" name="dish_type" id="main" value="main" required>
            <label for="main">Main</label>
            <input type="radio" onclick="([].slice.call(document.getElementsByTagName('input'))).filter(x => x.type == 'checkbox' && x.parentElement.className != 'db_query secondary').forEach(x => x.checked = 0)" name="dish_type" id="side" value="side" required>
            <label for="side">Side</label>
            <input type="radio" onclick="([].slice.call(document.getElementsByTagName('input'))).filter(x => x.type == 'checkbox' && x.parentElement.className != 'db_query secondary').forEach(x => x.checked = 0)" name="dish_type" id="drink" value="drink" required>
            <label for="drink">Drink</label>
            <input type="radio" onclick="([].slice.call(document.getElementsByTagName('input'))).filter(x => x.type == 'checkbox' && x.parentElement.className != 'db_query secondary').forEach(x => x.checked = 0)" name="dish_type" id="desert" value="desert" required>
            <label for="desert">Desert</label>
            <!--The user can set the basic dish charasteristics-->
            <h2>Dish propperties:</h2>
            <input type="checkbox" name="vegan" id="vegan">
            <label for="vegan">Is it Vegan:</label>
            <input type="checkbox" name="vegetarian" id="vegetarian">
            <label for="vegetarian">Is it Vegetarian:</label>
            <input type="checkbox" name="halal" id="halal">
            <label for="halal">Is it Halal:</label>
            <!--Some stuff is specific  to the type of the dish-->
            <!--DRINK-->
            <div class="drink section background">
                <input type="checkbox" name="cold" id="cold">
                <label for="cold">Cold</label>
                <input type="checkbox" name="hot" id="hot">
                <label for="hot">Hot</label>
            </div>
            <!--ELSE-->
            <div class="nond section background">
                <input type="checkbox" name="bowl" id="bowl">
                <label for="bowl">Bowl</label>
                <input type="checkbox" name="plate" id="plate">
                <label for="plate">Plate</label>
            </div>            
            <!--MAIN-->
            <div class="main section background">
                <input type="checkbox" name="meat" id="meat">
                <label for="meat">Meat</label>
                <input type="checkbox" name="fish" id="fish">
                <label for="fish">Fish</label>
                <input type="checkbox" name="chicken" id="chicken">
                <label for="chicken">Chicken</label>
            </div>
            <!--SIDE-->
            <div class="side section background">
                <input type="checkbox" name="vegetables" id="vegetables">
                <label for="vegetables">Vegetables</label>
            </div>
            <!--DESERT-->
            <div class="desert section background">
                <input type="checkbox" name="coldD" id="coldD">
                <label for="coldDs">Cold</label>
                <input type="checkbox" name="fruit" id="fruit">
                <label for="fruit">Fruit</label>
            </div>
            <!--The user can submit the form contents by pressing a button-->
            <h2></h2>
            <input type="submit" value="add" class="accent">
        </form>
    </body>
    
</html>
