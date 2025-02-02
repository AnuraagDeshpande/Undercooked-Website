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
    <title>Search Reviews</title>
    <link href="<?php echo $our_root?>/styles.css" rel="stylesheet"/>
    <link href="<?php echo $our_root?>/dishes_queries/dishes_page.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <style>
        body h1 {
            align-items: center;
        }
        form {
            align-items: left;
        }
    </style>
</head>
<?php
    //INITIAL CONNECTION
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
    //WE FETCH THE DATA FOR AUTOCOMPLETE
    $json = [];
    try {
        $reviews_sql="SELECT name
        FROM user_reviews u";
        $reviewsQ = $conn->prepare($reviews_sql);
        $reviewsQ->execute();                
        $json = $reviewsQ->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        echo "Fetching data: " . $e->getMessage();
    }
?>
<body class="secondary">
    <h1>Search reviews:</h1>
    <form action="" method="POST">
        <input type="text" name="dish_name" placeholder="Enter the dish name" id="review_search" required>
        <button type="submit">Search</button>
    </form>
    <script>
        const reviews = <?php echo json_encode($json); ?>;
        const reviewsSet = new Set(reviews)
        $(document).ready(function() {
            $("#review_search").autocomplete({
                source: Array.from(reviewsSet),
                minLength: 2
            });
        });

    </script>


    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        

        // check if form is submitted
        if (isset($_POST['dish_name'])) {
            $dish_name = $_POST['dish_name'];
            $reviews = [];

            try {
                // to make it so capitalization is ignored
                $normalized_name = ucfirst(strtolower($dish_name));
                //I search based on dish name
                // Prepare the query based on user input
                //checks if search is a type if not, checks if name matches drink
                $reviews_sql="SELECT u.content, u.name, u.login, u.did, u.uid, u.isCritic, u.rid
                FROM user_reviews u
                WHERE LOWER(u.name) LIKE LOWER(:dish_name) OR LOWER(u.content) LIKE LOWER(:dish_name) OR LOWER(u.login) LIKE LOWER(:dish_name)";
                $reviewsQ = $conn->prepare($reviews_sql);
                $search_name = '%' . $dish_name . '%'; // For partial matches
                $reviewsQ->bindParam(':dish_name', $search_name, PDO::PARAM_STR);
                $reviewsQ->execute();                

                // Execute the query
                $reviews = $reviewsQ->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Fetching data: " . $e->getMessage();
            }

            // Display the reviews table if results are found
            if (is_array($reviews) && count($reviews) > 0): ?>
                <h2>Reviews found:</h2>
                    <?php foreach ($reviews as $row): ?>
                        <div class="dish-card secondary review">
                            <div class="card-header">
                                <h3 class="review_header">
                                    <a href="<?php echo $our_root?>/review_queries/review_result.php?rid=<?php echo urlencode($row['rid']); ?>">
                                            <?php 
                                                echo htmlspecialchars($row['login']); 
                                                echo ": ";
                                                echo htmlspecialchars($row['name']); 
                                            ?>
                                    </a>
                                </h3>
                                <p>
                                    <?php 
                                        echo htmlspecialchars($row['content']); 
                                    ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>         
            <?php else: ?>
                <p>No reviews found</p>
            <?php endif;
        }
    ?>
</body>
</html>
