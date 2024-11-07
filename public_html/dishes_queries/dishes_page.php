<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undercooked Website - Search Dishes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #D6D6F2;
        }
        table, th, td {
            border: 1px solid #999;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #EEE;
        }
    </style>
    <link href="<?php echo $our_root?>/styles.css" rel="stylesheet"/>
    <link href="<?php echo $our_root?>/dishes_queries/dishes_page.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php include './navbar_for_dishes_search.php';?>

    <h1>Search Dishes:</h1>
    <?php
        include $php_root . '/maintenance/variables.php';
        include $php_root . '/logger.php';
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $types = array(
            "Vegan" => "isVegan",
            "Vegetarian" => "isVegetarian",
            "Halal" => "isHalal",
        );

        // check if form is submitted
        if (isset($_GET['search_query'])) {
            $search_query = $_GET['search_query'];
            $dishes = []; // Use $dishes instead of $drinks

            try {
                // database connection
                $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Normalize the search query
                $normalized_name = ucfirst(strtolower($search_query));

                // Prepare the query based on user input
                if (array_key_exists($normalized_name, $types)) {
                    $column = $types[$normalized_name];
                    $dishQ = $conn->prepare("
                        SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian
                        FROM dishes D
                        WHERE D.$column = 1
                    ");
                } else {
                    $dishQ = $conn->prepare("
                        SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian
                        FROM dishes D
                        WHERE LOWER(D.name) LIKE LOWER(:search_query)
                    ");
                    $search_name = '%' . $search_query . '%'; // For partial matches
                    $dishQ->bindParam(':search_query', $search_name, PDO::PARAM_STR);
                }

                

                // Execute the query
                $dishQ->execute();
                $dishes = $dishQ->fetchAll(PDO::FETCH_ASSOC);

                $ratings_sql="SELECT R.did, R.rating
                FROM dish_ratings R
                WHERE R.did=:did";
                $ratingsQ = $conn->prepare($ratings_sql);
                $ratingsQ->bindParam(':did', $did,PDO::PARAM_INT);
                $ratingsQ->execute();
                $rating = $ratingsQ->fetch(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            // Display the dishes table if results are found
            if (is_array($dishes) && count($dishes) > 0): ?>
                <h2>Dishes found:</h2>
                <?php foreach ($dishes as $row): ?>
                    <div class="dish-card secondary review">
                        <div class="card-header">
                            <h3 class="review_header">
                                <a href="<?php echo $our_root?>/dishes_queries/dish_result.php?did=<?php echo urlencode($row['did']); ?>">
                                    <?php echo htmlspecialchars($row['name']); ?>
                                </a>
                                <?php
                                // Fetch and display rating
                                try {
                                    $ratings_sql = "SELECT rating FROM dish_ratings WHERE did = :did";
                                    $ratingsQ = $conn->prepare($ratings_sql);
                                    $ratingsQ->bindParam(':did', $row['did'], PDO::PARAM_INT);
                                    $ratingsQ->execute();
                                    $rating = $ratingsQ->fetch(PDO::FETCH_ASSOC);
                                    echo "rated";
                                    echo isset($rating['rating']) ? ": " . htmlspecialchars($rating['rating']) : ": No rating";
                                } catch (PDOException $e) {
                                    echo ": Rating unavailable";
                                }
                                ?>
                            </h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No dishes found matching that name or type.</p>
            <?php endif;
        }
    ?>

<a href="<?php echo $our_root?>/goesWithQueries/goesWith_page.php" class="link"><h1>Dish Pairings<h1></a>
</body>
</html>