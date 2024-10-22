<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="../styles.css" rel="stylesheet"/>
        <link href="../dishes_queries/dishes_page.css" rel="stylesheet"/>
    </head>
    <?php
        include '../maintenance/variables.php';
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $uid=16;
        $uid = $_GET['uid'];
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
            //USER DATA
            $users_sql="SELECT U.login, U.isCritic
            FROM users U
            WHERE U.uid=:uid";
            $usersQ = $conn->prepare($users_sql);
            $usersQ->bindParam(':uid', $uid,PDO::PARAM_INT);
            $usersQ->execute();
            $user = $usersQ->fetch(PDO::FETCH_ASSOC);

            //RATINGS
            $ratings_sql="SELECT R.name, R.rating, R.did
            FROM user_ratings R
            WHERE R.uid=:uid";
            $ratingsQ = $conn->prepare($ratings_sql);
            $ratingsQ->bindParam(':uid', $uid,PDO::PARAM_INT);
            $ratingsQ->execute();
            $ratings = $ratingsQ->fetchAll(PDO::FETCH_ASSOC);
 
            //REVIEWS
            $reviews_sql="SELECT u.content, u.name, u.did, u.rid
            FROM user_reviews u
            WHERE u.uid=:uid";
            $reviewsQ = $conn->prepare($reviews_sql);
            $reviewsQ->bindParam(':uid', $uid,PDO::PARAM_INT);
            $reviewsQ->execute();
            $reviews = $reviewsQ->fetchAll(PDO::FETCH_ASSOC);
        }  catch (PDOException $e){
            echo "Fetching data failed: " . $e->getMessage();
        }
    ?>
    <body class="secondary text">
        <!--We print the most omportant information as headers-->
        <h1 class="item_main_info"><?php echo htmlspecialchars($user['login']); ?></h1>
        <?php if ($user['isCritic']):?>
            <p>This user is a critic</p>
        <?php endif; ?>
        <div class="item_main_info">
            <h2>Ratings left: <?php echo htmlspecialchars(count($ratings));?></h2>
            <h2>Reviews left: <?php echo htmlspecialchars(count($reviews));?></h2>
        </div>
        
        <!--Ratings have a section below-->
        <h2>Ratings:</h2>
        <?php if (is_array($ratings)>0  && count($ratings) > 0):?>
            <?php foreach ($ratings as $row): ?>
                <div class="review">
                    <h3 class="review_header">
                        <a href="../dishes_queries/dish_result.php?did=<?php echo urlencode($row['did']); ?>">
                            <?php echo htmlspecialchars($row['name']); ?>:
                        </a>
                    </h3>
                    <p><?php echo htmlspecialchars($row['rating']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="review">
                <p> This user has not left ratings yet</p>
            </div>
        <?php endif; ?>
        
        <!--Reviews have a section below-->
        <h2>Reviews:</h2>
        <?php if (is_array($reviews)>0  && count($reviews) > 0):?>
            <?php foreach ($reviews as $row): ?>
                <div class="review">
                    <h3 class="review_header">
                        <a href="../dishes_queries/dish_result.php?did=<?php echo urlencode($row['did']); ?>">
                            <?php echo htmlspecialchars($row['name']); ?>:
                        </a>
                    </h3>
                    <p>
                        <a href="../review_queries/review_result.php?rid=<?php echo urlencode($row['rid']); ?>">
                            <?php echo htmlspecialchars($row['content']); ?>
                        </a>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="review">
                <p> This user has not left reviews yet</p>
            </div>
        <?php endif; ?>
    </body>
</html>
