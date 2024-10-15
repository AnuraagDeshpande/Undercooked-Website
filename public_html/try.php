<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="styles.css" rel="stylesheet"/>
    </head>
    <?php
        print_r($_POST);
        $name = $_POST['name'];
        echo "\n";
        echo $name;
        echo "\n";
        echo $vegan;
    ?>
    <body>
        <form  method="POST" class="db_query secondary">
            <h1>Add a dish:</h1>
            <!--The user has to input the name-->
            <h2>Input the name of the new dish</h2>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required minlength="5" maxlength="100">
            <!--Here the user can select the dish type-->
            <h2>Type of dish:</h2>
            <input type="radio" name="dish_type" id="main" value="main" required>
            <label for="main">Main</label>
            <input type="radio" name="dish_type"  id="side" value="side" required>
            <label for="side">Side</label>
            <input type="radio" name="dish_type"  id="drink" value="drink" required>
            <label for="drink">Drink</label>
            <input type="radio" name="dish_type"  id="desert" value="desert" required>
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
                <input type="checkbox" name="cold" id="coldD">
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
