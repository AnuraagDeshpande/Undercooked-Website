<?php
    include '../navbar.php';
    global $our_root;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map page</title>
    <link href="<?php echo $our_root?>/styles.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/> <!-- Leaflet CSS -->
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script> <!-- Leaflet JavaScript file -->
</head>
<body class = "secondary">
    <?php
            include $php_root . '/map_functions.php';
            include $php_root . '/logger.php';
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            ?>

    <div class="text secondary">
            <p>
                <h3>This is a map displaying the location of users, made using the OpenStreetMap functionality 
                inside the leaflet.js JavaScript library. We extract the geolocation of users from their ip address using
                ipinfo.</h3>
            </p>
        </div>
    <div class="map" id="map"></div>
    <div class="text secondary">
            <p>
                <h2><a href="./..">Back to homepage!</a></h2>
            </p>
</body>
<?php
    $current_loc=getUserLoc();
    $loc = json_encode($current_loc);
?>
<script>
    var map = L.map('map').setView([51.505, -0.09], 13); //call and set the view of map (coordinates and zoom level)

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map); //loads the data of the map, to be set to the coordinates and zoom level defined earlier

    navigator.geolocation.getCurrentPosition(success);

    let marker, circle; //declare them in the global scope

    function success(pos) { //function in case the live location of the user is sucessfully accessed
        //fetch the relevant data about the user's location
        var position = <?php echo $current_loc?>;
        position = text.split(",");

        if (marker) { //removes the previous marker and circle when user location is updated
            map.removeLayer(marker);

        }

        marker = L.marker([position]).addTo(map); //create a marker
    }

    /* function error(err) { //error function in case the user does not allow us to access their location

    if (err.code === 1) {
        alert("Please allow geolocation access");
        // Runs if user refuses access
    } else {
        alert("Cannot get current location");
        // Runs if there was a technical problem.
    } */

</script>
</html>