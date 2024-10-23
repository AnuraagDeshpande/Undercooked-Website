<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undercooked Website</title>
    <link href="../styles.css" rel="stylesheet"/>
    <link href="../dishes_queries/dishes_page.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<?php
    include '../maintenance/variables.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

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
        //DISHES WITH RATING
        $dishes_sql="SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, R.rating
        FROM dishes D, dish_ratings R
        WHERE R.did=D.did";
        $dishesQ = $conn->prepare($dishes_sql);
        $dishesQ->execute();
        $dishes = $dishesQ->fetchAll(PDO::FETCH_ASSOC);
    }  catch (PDOException $e){
        echo "Fetching data failed: " . $e->getMessage();
    }
    // Output data in JSON format
    header('Content-Type: application/json');
    echo json_encode($dishes);

    // Close connection
    $conn->close();
?>
<body>
    <nav class="navbar">
        <div class="navbar_container">
            <img src="images/logo3.png" alt="logo" class="navbar_item">
            <a href="/" id="navbar_logo" class="logo"><h1>Undercooked</h1></a>
            <div class="navbar_toggle" id="mobile_menu">
                <span class="bar"></span><span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar_menu">
                <li class="navbar_item">
                    <a href="index.html" class="navbar_links">Home</a>
                </li>
                <li class="navbar_item">
                    <a href="/" class="navbar_links">Dishes</a>
                </li>
                <li class="navbar_item">
                    <a href="/" class="navbar_links">Reviews</a>
                </li>
                <li class="navbar_item">
                    <a href="/" class="navbar_links">This week</a>
                </li>
                <li class="navbar_item">
                    <a href="./maintenance/maintenance.html" class="navbar_links">Maintenance</a>
                  </li>
                <li class="navbar_btn">
                    <a href="/" class="button">Login/Sign up</a>
                </li>
            </ul>
            <div class="box">
                <input type="text" placeholder="search">
                <a href="#">
                    <i class="fas fa-search"></i>
                </a>
            </div>
        </div>
    </nav>
    <div class="dishes-cards">
    <?php if(is_array($dishes) && count($dishes)>0):?>
        <?php foreach ($dishes as $dish):?>
            <div class="dish-card secondary">
                <div class="card-header">
                    <h3 class="review_header">
                        <a href="../dishes_queries/dish_result.php?did=<?php echo urlencode($dish['did']); ?>">
                                <?php 
                                    echo htmlspecialchars($dish['name']); 
                                    echo " ";
                                    echo htmlspecialchars(number_format($dish['rating'], 2)); 
                                ?>
                        </a>
                    </h3>
                </div>
            </div>
        <?php endforeach;?>
    <?php endif;?>
    <div class="dish-card">
        <div class="card-header">Dish_name</div>
        <div class="card-body">rating</div>
    </div>
    <div class="dish-card">
        <div class="card-header">Dish_name</div>
        <div class="card-body">rating</div>
    </div>
    <div class="dish-card">
        <div class="card-header">Dish_name</div>
        <div class="card-body">rating</div>
    </div>
    <div class="dish-card">
        <div class="card-header">Dish_name</div>
        <div class="card-body">rating</div>

    </div>

    <script>
        // Function to fetch dishes from PHP
        function fetchDishes() {
            $.ajax({
                url: 'dishes_page.php', // The PHP script to fetch the dishes
                method: 'GET',
                dataType: 'json',
                success: function(dishes) {
                    renderCards(dishes);
                },
                error: function() {
                    console.error('Error fetching data from PHP');
                }
            });
        }

        // Function to render the dishes as cards
        function renderCards(dishes) {
            const container = $('.dishes_cards');
            container.empty(); // Clear the existing content

            dishes.forEach(dish => {
                // Create a card for each dish
                const card = `
                    <div class="card">
                        <h2>${dish.name}</h2>
                        <p>Rating: ${dish.rating}</p>
                    </div>
                `;
                container.append(card);
            });
        }

        // Filter functionality
        $('#search').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();

            // Fetch the dishes again and filter them
            $.ajax({
                url: 'fetch_dishes.php',
                method: 'GET',
                dataType: 'json',
                success: function(dishes) {
                    const filteredDishes = dishes.filter(dish => dish.name.toLowerCase().includes(searchTerm));
                    renderCards(filteredDishes);
                },
                error: function() {
                    console.error('Error fetching data');
                }
            });
        });

        // Initial fetch when the page loads
        $(document).ready(function() {
            fetchDishes();
        });
    </script>   
</div>
</body>