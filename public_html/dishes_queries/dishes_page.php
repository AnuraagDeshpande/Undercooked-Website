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
    <link href="../styles.css" rel="stylesheet"/>
    <link href="./dishes_page.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <?php include './navbar_for_dishes_search.php';?>

    <h1>Search Dishes:</h1>
    <?php
        include '../maintenance/variables.php';
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $types = array(
            "Vegan" => "isVegan",
            "Vegetarian" => "isVegetarian",
            "Halal" => "isHalal",
            "Cold" => "isCold",
            "Hot" => "isHot"
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
                        SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, DR.isCold, DR.isHot
                        FROM dishes D
                        INNER JOIN drinks DR ON D.did = DR.did
                        WHERE DR.$column = 1
                    ");
                } else {
                    $dishQ = $conn->prepare("
                        SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, DR.isCold, DR.isHot
                        FROM dishes D
                        INNER JOIN drinks DR ON D.did = DR.did
                        WHERE LOWER(D.name) LIKE LOWER(:search_query)
                    ");
                    $search_name = '%' . $search_query . '%'; // For partial matches
                    $dishQ->bindParam(':search_query', $search_name, PDO::PARAM_STR);
                }

                // Execute the query
                $dishQ->execute();
                $dishes = $dishQ->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            // Display the dishes table if results are found
            if (is_array($dishes) && count($dishes) > 0): ?>
                <h2>Dishes found:</h2>
                    <?php foreach ($reviews as $row): ?>
                        <div class="dish-card secondary review">
                            <div class="card-header">
                                <h3 class="review_header">
                                    <a href="./dishes_queries/dish_result.php?did=<?php echo urlencode($row['did']); ?>">
                                            <?php 
                                                echo htmlspecialchars($row['dish_name']); 
                                                echo ": ";
                                                echo htmlspecialchars($row['dish_rating']); 
                                            ?>
                                    </a>
                                </h3>
                    <?php endforeach; ?> 
            <?php else: ?>
                <p>No dishes found matching that name or type.</p>
            <?php endif;
        }
    ?>
</body>
</html>