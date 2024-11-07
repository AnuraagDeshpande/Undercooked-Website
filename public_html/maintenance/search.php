<?php 
    include '../navbar.php';
    include $php_root . '/maintenance/variables.php';
    global $our_root;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undercooked Website - Search Drinks</title>
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
        <input type="text" name="drink_name" placeholder="Enter drink name or type" required>
        <button type="submit">Search</button>
    </form>

    <?php
        include $php_root . '/maintenance/variables.php';
        include $php_root . '/logger.php';
        include $php_root . '/maintenance/security.php';
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
        if (isset($_POST['drink_name'])) {
            $drink_name = $_POST['drink_name'];
            $drinks = [];

            try {
                // database connection
                $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // to make it so capitalization is ignored
                $normalized_name = ucfirst(strtolower($drink_name));

                // Prepare the query based on user input
                //checks if search is a type if not, checks if name matches drink
                if (array_key_exists($normalized_name, $types)) {
                    if ($normalized_name == "Cold" || $normalized_name == "Hot") {
                        $column = $types[$normalized_name];
                        $drinkQ = $conn->prepare("
                            SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, DR.isCold, DR.isHot
                            FROM dishes D
                            INNER JOIN drinks DR ON D.did = DR.did
                            WHERE DR.$column = 1
                        ");
                    } else {
                        $column = $types[$normalized_name];
                        $drinkQ = $conn->prepare("
                            SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, DR.isCold, DR.isHot
                            FROM dishes D
                            INNER JOIN drinks DR ON D.did = DR.did
                            WHERE D.$column = 1
                        ");
                    }
                } else {
                    $drinkQ = $conn->prepare("
                        SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, DR.isCold, DR.isHot
                        FROM dishes D
                        INNER JOIN drinks DR ON D.did = DR.did
                        WHERE LOWER(D.name) LIKE LOWER(:drink_name)
                    ");
                    $search_name = '%' . $drink_name . '%'; // For partial matches
                    $drinkQ->bindParam(':drink_name', $search_name, PDO::PARAM_STR);
                }

                // Execute the query
                $drinkQ->execute();
                $drinks = $drinkQ->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            // Display the drinks table if results are found
            if (is_array($drinks) && count($drinks) > 0): ?>
                <h2>Drinks found:</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Vegan</th>
                        <th>Vegetarian</th>
                        <th>Halal</th>
                        <th>Cold</th>
                        <th>Hot</th>
                    </tr>
                    <?php foreach ($drinks as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['price']); ?></td>
                            <td><?php echo $row['isVegan'] ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $row['isVegetarian'] ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $row['isHalal'] ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $row['isCold'] ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $row['isHot'] ? 'Yes' : 'No'; ?></td>
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
