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
    error_reporting(E_ALL); //Useful for reporting errors during development

    // Database connection settings

    try {        
        // Establish connection
        $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
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
    } catch(PDOException $e){
        echo "Fetching data failed" . $e->getMessage();
    }
?>
<body>
    <form method="POST" action="" class="db_query secondary goes_well_with">
    <h1>Link Dishes Together</h1>
        <h2>Dsih 1:</h2>
        <select name="name1" required>
            <?php if (is_array($dishes)>0  && count($dishes) > 0):?>
                <?php foreach ($dishes as $row): ?>
                    <option value="<?php echo $row['did']; ?>" ><?php echo htmlspecialchars($row['name']); ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <h2>Dish 2:</h2>
        <select name="name2" required>
            <?php if (is_array($dishes)>0  && count($dishes) > 0):?>
                <?php foreach ($dishes as $row): ?>
                    <option value="<?php echo $row['did']; ?>" ><?php echo htmlspecialchars($row['name']); ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        <h2></h2>
        <input type="submit" value="add" class="accent">
        <a href="./maintenance.php">back to maintenance</a>
    </form>
    <?php
    /*
    <label for="name1">Enter First Dish Name:</label>
        <input type="text" id="name1" name="name1" required><br><br>

        <label for="name2">Enter Second Dish Name:</label>
        <input type="text" id="name2" name="name2" required><br><br>

        <input type="submit" value="Submit">*/ 
    try {
        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get dish names from POST request
            $dish1_id = $_POST['name1'];
            $dish2_id = $_POST['name2'];            
            

            // Ensure dishes are not the same
            if ($dish1_id != $dish2_id) {
                // Insert the pair into the goes_with table
                $stmt_insert = $conn->prepare("INSERT INTO goes_with (did1, did2) VALUES (:dish1_id, :dish2_id)");
                $stmt_insert->bindParam(':dish1_id', $dish1_id);
                $stmt_insert->bindParam(':dish2_id', $dish2_id);
                $stmt_insert->execute();

                $stmt_insert = $conn->prepare("INSERT INTO goes_with (did1, did2) VALUES (:dish1_id, :dish2_id)");
                $stmt_insert->bindParam(':dish1_id', $dish2_id);
                $stmt_insert->bindParam(':dish2_id', $dish1_id);
                $stmt_insert->execute();
                header("Location: addedgoesWith.php");
                exit(); 
            } else {
                echo "<p>You cannot link a dish to itself. Please choose two different dishes.</p>";
            }
        }
    } 
    catch (PDOException $e){
        echo "Inserting data failed" . $e->getMessage();
    }
    
    ?>

</body>
</html>