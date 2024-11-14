<?php
    include '../navbar.php';
    global $our_root;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Dish Pairings</title>
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
<body class="secondary">

    <?php
        include $php_root . '/maintenance/variables.php';
        include $php_root . '/logger.php';
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        try {        
            // Database connection settings
            $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        //WE FETCH THE DATA FOR AUTOCOMPLETE
        $json = [];
        try {
            $goesWith_sql= "
            SELECT D1.name AS dish_name
            FROM goes_with G
            JOIN dishes D1 ON G.did1 = D1.did
            UNION
            SELECT D2.name AS dish_name
            FROM goes_with G
            JOIN dishes D2 ON G.did2 = D2.did
            ";
            $gWQ = $conn->prepare($goesWith_sql);
            $gWQ->execute();                
            $json = $gWQ->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            echo "Fetching data: " . $e->getMessage();
        }

        ?>

        <h1>Search for dish pairings:</h1>
    <form action="" method="POST">
        <input type="text" name="dish_name" placeholder="Enter the dish name" id = "goesWithSearch" required>
        <button type="submit">Search</button>
    </form>

    <script>
        const goesWithRelations = <?php echo json_encode($json); ?>;
        const goesWithSet = new Set(goesWithRelations)
        $(document).ready(function() {
            $("#goesWithSearch").autocomplete({
                source: Array.from(goesWithSet),
                minLength: 2
            });
        });

    </script>

    <?php
        // Check if the form is submitted
        if (isset($_POST['dish_name'])) {
            $dish_name = $_POST['dish_name'];
            $pairings = [];

            try {
                // Normalize the name for consistent matching
                $normalized_name = ucfirst(strtolower($dish_name));

                // Prepare the query to find pairings
                $pairing_sql = "
                SELECT G.did1, D1.name AS dish1, G.did2, D2.name AS dish2
                FROM goes_with G
                JOIN dishes D1 ON G.did1 = D1.did
                JOIN dishes D2 ON G.did2 = D2.did
                WHERE LOWER(D1.name) LIKE LOWER(:dish_name) OR LOWER(D2.name) LIKE LOWER(:dish_name)";
                
                $pairingQ = $conn->prepare($pairing_sql);
                $search_name = '%' . $dish_name . '%'; // For partial matches
                $pairingQ->bindParam(':dish_name', $search_name, PDO::PARAM_STR);
                $pairingQ->execute();                

                // Fetch the pairings
                $pairings = $pairingQ->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            // Display the pairings if results are found
            if (is_array($pairings) && count($pairings) > 0): ?>
                <h2>Dish Pairings Found:</h2>
                    <?php foreach ($pairings as $row): ?>
                        <div class="dish-card secondary pairing">
                            <div class="card-header">
                                <h3 class="pairing_header">
                                    <?php 
                                        echo htmlspecialchars($row['dish1']);
                                        echo " goes well with ";
                                        echo htmlspecialchars($row['dish2']); 
                                    ?>
                                </h3>
                            </div>
                        </div>
                    <?php endforeach; ?>         
            <?php else: ?>
                <p>No pairings found for "<?php echo htmlspecialchars($dish_name); ?>"</p>
            <?php endif;
        }
    ?>
</body>
</html>
