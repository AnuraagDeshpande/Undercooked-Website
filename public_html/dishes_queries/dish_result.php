<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="../styles.css" rel="stylesheet"/>
        <link href="./dishes_page.css" rel="stylesheet"/>
    </head>
    <?php
        include '../maintenance/variables.php';
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $did=29;
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

           

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        //WE FETCH RELEVANT DATA
        try {
             //MAIN DISHES
             $main_sql="SELECT M.did, M.name, M.price, M.isHalal, M.isVegan, M.isVegetarian, M.inBowl, M.onPlate, M.hasMeat, M.hasFish, M.hasChicken
             FROM mains_combined M
             WHERE M.did=:did";
             $mainQ = $conn->prepare($main_sql);
             $mainQ->bindParam(':did', $did,PDO::PARAM_INT);
             $mainQ->execute();
             $main = $mainQ->fetch(PDO::FETCH_ASSOC);
 
             //SIDE DISHES
             $side_sql="SELECT S.did, S.name, S.price, S.isHalal, S.isVegan, S.isVegetarian, S.inBowl, S.onPlate, S.hasVegetables
             FROM sides_combined S
             WHERE S.did=:did";
             $sideQ = $conn->prepare($side_sql);
             $sideQ->bindParam(':did', $did,PDO::PARAM_INT);
             $sideQ->execute();
             $side = $sideQ->fetch(PDO::FETCH_ASSOC);
             //DESERTS
             $desert_sql="SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, D.inBowl, D.onPlate, D.isCold, D.hasFruit
             FROM deserts_combined D
             WHERE D.did=:did";
             $desertQ = $conn->prepare($desert_sql);
             $desertQ->bindParam(':did', $did,PDO::PARAM_INT);
             $desertQ->execute();
             $desert = $desertQ->fetch(PDO::FETCH_ASSOC);
             //DRINKS
             $drinks_sql="SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, D.isCold, D.isHot
             FROM drinks_combined D
             WHERE D.did=:did";
             $drinksQ = $conn->prepare($drinks_sql);
             $drinksQ->bindParam(':did', $did,PDO::PARAM_INT);
             $drinksQ->execute();
             $drinks = $drinksQ->fetch(PDO::FETCH_ASSOC);
 
             //RATINGS
             $ratings_sql="SELECT R.did, R.rating
             FROM dish_ratings R
             WHERE R.did=:did";
             $ratingsQ = $conn->prepare($ratings_sql);
             $ratingsQ->bindParam(':did', $did,PDO::PARAM_INT);
             $ratingsQ->execute();
             $rating = $ratingsQ->fetch(PDO::FETCH_ASSOC);
 
             //REVIEWS
             $reviews_sql="SELECT u.login, u.content, u.name, u.uid, u.did
             FROM user_reviews u
             WHERE u.did=:did";
             $reviewsQ = $conn->prepare($reviews_sql);
             $reviewsQ->bindParam(':did', $did,PDO::PARAM_INT);
             $reviewsQ->execute();
             $reviews = $reviewsQ->fetchAll(PDO::FETCH_ASSOC);
        }  catch (PDOException $e){
            echo "Fetching data failed: " . $e->getMessage();
        }
        $dish;
        $type=0;
        if($main==TRUE){
            $type=1;
            $dish=$main;
        } elseif ($desert==TRUE){
            $type=2;
            $dish=$desert;
        } elseif ($side==TRUE){
            $type=3;
            $dish=$side;
        } else{
            $type=4;
            $dish=$drinks;
        }

    ?>
    <body class="secondary text">
        <!--We print the most omportant information as headers-->
        <h1><?php echo htmlspecialchars($dish['name']); ?></h1>
        <div class="background dish_info">
            <h2>
                Rating:
                <?php if($rating==TRUE): ?>
                    <?php echo htmlspecialchars(number_format($rating['rating'], 2)); ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </h2>
            <h2>Price: <?php echo htmlspecialchars($dish['price']); ?>€</h2>
        </div>
        <!--Here we print all common properties-->
        <h2>Description:</h2>
        <p>
            This dish is: 
            <?php $dish['isVegan'] ? 'vegan' : ''; ?> 
            <?php echo $dish['isVegetarian'] ? 'vegetarian' : ''; ?>
            <?php echo $dish['isHalal'] ? 'halal' : ''; ?>
        </p>
        <!--Drink properties are listed below-->
        <?php if($type==4): ?>
            <p>
                This drink might be served: 
                <?php echo $dish['isCold'] ? 'cold' : ''; ?>
                <?php echo $dish['isHot'] ? 'hot' : ''; ?>
            </p>
        <?php endif; ?>
        <!--Non drinks and their properties are printed below-->
        <?php if(($type>=1) && ($type<=3)): ?>
            <p>
                This dish might be served: 
                <?php echo $dish['inBowl'] ? 'in a bowl' : ''; ?>
                <?php echo $dish['onPlate'] ? 'on a plate' : ''; ?>
            </p>
            <p>
                The following are inside the dish: 
                <?php if($type==1): ?>
                    <?php echo $dish['hasMeat'] ? 'meat' : ''; ?>
                    <?php echo $dish['hasFish'] ? 'fish' : ''; ?>
                    <?php echo $dish['hasChicken'] ? 'chicken' : ''; ?>
                <?php elseif($type==2): ?>
                    <?php echo $dish['hasFruit'] ? 'fruit' : ''; ?>
                <?php elseif($type==3): ?>
                    <?php echo $dish['hasVegetbles'] ? 'vegetables' : ''; ?>
                <?php endif; ?>
            </p>
        <?php endif; ?>
        <!--Is a desert cold?-->
        <?php if(($type==2)&&($dish['isCold'])): ?>
            <p>
                This is a cold desert.
            </p>
        <?php endif; ?>
        <h2>Reviews:</h2>
        <!--Reviews have a section below-->
        <?php if (is_array($reviews)>0  && count($reviews) > 0):?>
                <?php foreach ($reviews as $row): ?>
                    <div class="review background">
                        <h3 class="review_username">
                            <?php echo htmlspecialchars($row['login']); ?>:
                        </h3>
                        <p><?php echo htmlspecialchars($row['content']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <p> No reviews left for the dish yet</p>
                </tr>
            <?php endif; ?>
    </body>
</html>
