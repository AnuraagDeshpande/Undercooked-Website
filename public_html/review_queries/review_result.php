<?php
        include '../navbar.php';
        global $our_root;
        include $php_root . '/maintenance/variables.php';
        include $php_root . '/logger.php';
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="<?php echo $our_root?>/styles.css" rel="stylesheet"/>
        <link href="<?php echo $our_root?>/dishes_queries/dishes_page.css" rel="stylesheet"/>
    </head>
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $rid=7;
        $rid=$_GET['rid'];
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
            //REVIEWS
            $reviews_sql="SELECT u.content, u.name, u.login, u.did, u.uid, u.isCritic
            FROM user_reviews u
            WHERE u.rid=:rid";
            $reviewsQ = $conn->prepare($reviews_sql);
            $reviewsQ->bindParam(':rid', $rid,PDO::PARAM_INT);
            $reviewsQ->execute();
            $review = $reviewsQ->fetch(PDO::FETCH_ASSOC);
        }  catch (PDOException $e){
            echo "Fetching data failed: " . $e->getMessage();
        }
    ?>
    <body>
        <div class="secondary text">
            <!--We print the most omportant information as headers-->
            <h1 class="item_main_info">
                <a href="<?php echo $our_root?>/dishes_queries/dish_result.php?did=<?php echo urlencode($review['did']); ?>">
                    Review of: <?php echo htmlspecialchars($review['name']); ?>
                </a>
            </h1>
            <!--We print review content-->
            <div class="item_main_info">
                <h2>
                    <a href="<?php echo $our_root?>/users_queries/user_result.php?uid=<?php echo urlencode($review['uid']); ?>">
                        username: <?php echo htmlspecialchars($review['login']);?>
                    </a>
                </h2>
                <?php if($review['isCritic']):?>
                    <p>This review was left by a critic</p>
                <?php endif;?>
                <p><?php echo htmlspecialchars($review['content']);?></p>
            </div>
        </div>
    </body>
</html>
