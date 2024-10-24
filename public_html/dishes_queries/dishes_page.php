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

<body>
    <?php include '../navbar.php';?>

    <!-- <div class="dishes-cards">
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
        </div> -->

    <!-- Card Container (This is where the dish cards will be dynamically displayed) -->
    <div id="card-container" class="dishes-cards"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
        // JavaScript to fetch and display the dishes
        $(document).ready(function() {
            fetchDishes();
        });
    <script>

        // Function to fetch dishes from PHP
        function fetchDishes() {
            $.ajax({
                url: 'fetch_dishes.php', // The PHP script to fetch the dishes
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

        function renderCards(dishes) {
        const container = $('#card-container');
        container.empty(); // Clear the existing content

        dishes.forEach(dish => {
            // Create a card for each dish with the appropriate structure and classes
            const card = `
                <div class="dish-card review">
                    <div class="text">
                        <h3 class="review_header">
                            <a href="../dishes_queries/dish_result.php?did=${encodeURIComponent(dish.did)}">
                                ${dish.name}
                            </a>
                        </h3>
                        <div class="item_main_info">
                            <h1>${dish.price} USD</h1>
                            <p>Rating: ${dish.rating}</p>
                        </div>
                    </div>
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