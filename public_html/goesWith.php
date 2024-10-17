<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undercooked Website</title>
    <link href="styles.css" rel="stylesheet"/>
</head>
<body>

    <h1>Link Dishes Together</h1>

    <form method="POST" action="" class="goes_well_with">
        <label for="name1">Enter First Dish Name:</label>
        <input type="text" id="name1" name="name1" required><br><br>

        <label for="name2">Enter Second Dish Name:</label>
        <input type="text" id="name2" name="name2" required><br><br>

        <input type="submit" value="Submit">
    </form>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL); //Useful for reporting errors during development

    // Database connection settings
    $host = 'localhost';
    $dbname = 'test';
    $username = 'root';        
    $password = ''; 
    $socket = '/opt/lampp/var/mysql/mysql.sock'; 

    try {        
        // Establish connection
        $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get dish names from POST request
            $name1 = $_POST['name1'];
            $name2 = $_POST['name2'];

            // Fetch the details of the first dish
            $stmt1 = $conn->prepare("SELECT did FROM dishes WHERE name = :name1");
            $stmt1->bindParam(':name1', $name1);
            $stmt1->execute();
            $dish1 = $stmt1->fetch(PDO::FETCH_ASSOC);

            // Fetch the details of the second dish
            $stmt2 = $conn->prepare("SELECT did FROM dishes WHERE name = :name2");
            $stmt2->bindParam(':name2', $name2);
            $stmt2->execute();
            $dish2 = $stmt2->fetch(PDO::FETCH_ASSOC);

            // Check if both dishes are found
            if ($dish1 && $dish2) {
                $dish1_id = $dish1['did'];
                $dish2_id = $dish2['did'];

                // Ensure dishes are not the same
                if ($dish1_id != $dish2_id) {
                    // Insert the pair into the goes_with table
                    $stmt_insert = $conn->prepare("INSERT INTO goes_with (did1, did2) VALUES (:dish1_id, :dish2_id)");
                    $stmt_insert->bindParam(':dish1_id', $dish1_id);
                    $stmt_insert->bindParam(':dish2_id', $dish2_id);
                    $stmt_insert->execute();

                    echo "<p>Dishes <strong>$name1</strong> and <strong>$name2</strong> have been successfully linked!</p>";
                } else {
                    echo "<p>You cannot link a dish to itself. Please choose two different dishes.</p>";
                }

                // Query to get dish statistics (times paired, average rating)
                $query = "
                    SELECT d.did, d.name, COUNT(gw.did1) AS times_paired,
                      (SELECT AVG(r.rating) FROM rated r WHERE r.did = d.did) AS avg_rating
                    FROM dishes d
                    LEFT JOIN goes_with gw ON d.did = gw.did1 OR d.did = gw.did2
                    GROUP BY d.did;
                ";

                $stmt_stats = $conn->prepare($query);
                $stmt_stats->execute();
                $dish_stats = $stmt_stats->fetchAll(PDO::FETCH_ASSOC);

                // Display the stats of dishes
                echo "<h2>Dish Pairing Stats:</h2>";
                echo "<table border='1'>
                        <tr>
                            <th>Dish Name</th>
                            <th>Times Paired</th>
                            <th>Average Rating</th>
                        </tr>";
                foreach ($dish_stats as $row) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['times_paired']}</td>
                            <td>" . (isset($row['avg_rating']) ? round($row['avg_rating'], 2) : 'No Rating') . "</td>
                          </tr>";
                }
                echo "</table>";

            } else {
                echo "<p>One or both dishes were not found in the database. Please check the names and try again.</p>";
            }
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    ?>

</body>
</html>