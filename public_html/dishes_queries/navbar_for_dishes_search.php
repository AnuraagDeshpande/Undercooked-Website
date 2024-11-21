<?php
    $our_root ='/~pyuri';
    $php_root='/home/pyuri/repo/public_html'; 
    //$php_root='C:\Users\kosto\Desktop\repo\public_html'; 
    //$our_root ='/public_html'; 
    //$our_root ='';
    //$php_root='/home/tim/repo/public_html';
    include $php_root . '/maintenance/variables.php';
?>
<link href="<?php echo $our_root?>/styles.css" rel="stylesheet"/>
<link href="<?php echo $our_root?>/dishes_queries/dishes_page.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<?php
//HERE WE FETCH DATA FOR AUTOCOMPLETE:

//INITIAL CONNECTION
try {        
    // Database connection settings

    //We create a pdo instance to connect to the database
    //$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn_nav = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);

    //set the PDO error mode to exception
    $conn_nav->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

//FETCHING THE DATA
$json = [];
try {
    $dishesN_sql="SELECT name
    FROM dishes";
    $dishNQ = $conn_nav->prepare($dishesN_sql);
    $dishNQ->execute();                
    $json = $dishNQ->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    echo "Fetching data: " . $e->getMessage();
}
?>

<style>
    .ui-autocomplete {
        z-index: 1000; /* Ensure this is higher than other elements like the navbar */
        background-color: #ffffff; /* Background color for readability */
        border: 1px solid #ddd;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>

<nav class="navbar">
        <div class="navbar_container">
            <img src="<?php echo $our_root?>/images/logo3.png" alt="logo" class="navbar_item">
            <a href="<?php echo $our_root?>/" id="navbar_logo" class="logo"><h1>Undercooked</h1></a>
            <div class="navbar_toggle" id="mobile_menu">
                <span class="bar"></span><span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar_menu">
                <li class="navbar_item">
                    <a href="<?php echo $our_root?>/" class="navbar_links">Home</a>
                </li>
                <li class="navbar_item">
                    <a href="<?php echo $our_root?>/dishes_queries/dishes_page.php" class="navbar_links">Dishes</a>
                </li>
                <li class="navbar_item">
                    <a href="<?php echo $our_root?>/review_queries/review_page.php" class="navbar_links">Reviews</a>
                </li>
                <li class="navbar_item">
                    <a href="<?php echo $our_root?>/" class="navbar_links">This week</a>
                </li>
                <li class="navbar_item">
                    <a href="<?php echo $our_root?>/maintenance/maintenance.php" class="navbar_links">Maintenance</a>
                </li>
                <li class="navbar_item">
                    <a href="<?php echo $our_root?>/users_queries/user_page.php" class="navbar_links">Users</a>
                </li>
                <li class="navbar_btn">
                    <a href="<?php echo $our_root?>/" class="button">Login/Sign up</a>
                </li>
                <li class="navbar_item">
                    <a href="<?php echo $our_root?>/Map/map_page_new.php" class="navbar_links">Map</a>
                </li>
            </ul>
        <div class="box">
            <form action="<?php echo $our_root?>/dishes_queries/dishes_page.php" method="GET" id="search-form"> <!-- Change the action as needed -->
                <input type="text" placeholder="Search..." id="search" name="search_query" required>
                <button type="submit" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
                <script>
                    const dishes = <?php echo json_encode($json); ?>;
                    $(document).ready(function() {
                        $("#search").autocomplete({
                            source: dishes,
                            minLength: 2
                        });
                    });

                </script>
            </form>
        </div>  
    </nav>