<!--Redirects non admin users to ouch.php-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="/styles.css" rel="stylesheet"/>
    </head>
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/navbar.php';
        include $_SERVER['DOCUMENT_ROOT'] . '/maintenance/security.php';
    ?>
    <body class = "secondary text">
        
        <h1>Maintence page:</h1>
        <a href="./..">to main</a>
        <p>
            This page is meant to be only accessible by the admins/maintainers of the page.
            Here data can be onputed directly into the table and viewed afterwards on a view 
            page in order to see the results.
        </p>
        <h3>Input pages for admin:</h3>
            <ul>
                <li><a href="./add_dish.php">Add a dish</a></li>
                <li><a href="./signup.php">Sign up</a></li>
                <li><a href="./rate.php">Rate dish</a></li>
                <li><a href="./goesWith.php">Add two dishes that go well with each other</a></li>
                <li><a href="./addReviews.php">Add a review</a></li>
            </ul>
        <h3>View pages for admin:</h3>
        <ul>
            <li><a href="./dishes.php">All menu</a></li>
            <li><a href="./users.php">Users</a></li>
            <li><a href="./ratingsData.php">Ratings</a></li>
            <li><a href="./goesWithData.php">Goes with data</a></li>
            <li><a href="./reviewData.php">Reviews</a></li>
            <li><a href="./search.php">Drink Search</a></li>
            <li><a href="../dishes_queries/dishes_page.php">Dishes search using the topbar</a></li>
        </ul>
    </body>
</html>