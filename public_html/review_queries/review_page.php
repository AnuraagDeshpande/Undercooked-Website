<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Reviews</title>
    <link href="../styles.css" rel="stylesheet"/>
    <link href="../dishes_queries/dishes_page.css" rel="stylesheet"/>

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
</head>
<body>
    <h1>Search Drinks:</h1>
    <form action="" method="POST">
        <input type="text" name="dish_name" placeholder="Enter the dish name" required>
        <button type="submit">Search</button>
    </form>

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

        // check if form is submitted
        if (isset($_POST['dish_name'])) {
            $dish_name = $_POST['dish_name'];
            $reviews = [];

            try {
                // to make it so capitalization is ignored
                $normalized_name = ucfirst(strtolower($dish_name));

                // Prepare the query based on user input
                //checks if search is a type if not, checks if name matches drink
                $reviews_sql="SELECT u.content, u.name, u.login, u.did, u.uid, u.isCritic
                FROM user_reviews u
                WHERE LOWER(u.name) LIKE LOWER(:dish_name)";
                $reviewsQ = $conn->prepare($reviews_sql);
                $search_name = '%' . $dish_name . '%'; // For partial matches
                $reviewsQ->bindParam(':dish_name', $search_name, PDO::PARAM_STR);
                $reviewsQ->execute();                

                // Execute the query
                $reviews = $reviewsQ->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            // Display the drinks table if results are found
            if (is_array($reviews) && count($reviews) > 0): ?>
                <h2>Drinks found:</h2>
                <table>
                    <tr>
                        <th>Name</th>
                    </tr>
                    <?php foreach ($reviews as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No drinks found matching that name or type.</p>
            <?php endif;
        }
    ?>
</body>
</html>
