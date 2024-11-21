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
     crossorigin=""></script> <!-- Leaflet JavaScript file --> <!-- can change to 1.9.4 leaflet version -->
</head>
<body class = "secondary">
    <?php
            include $php_root . '/logger.php';
            include $php_root . '/map_functions.php';
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            ?>

    <div class="text secondary">
            <p>
                This is a map displaying the live location of users, made using the OpenStreetMap functionality 
                inside the leaflet.js JavaScript library. We extract the geolocation of users from their ip address using
                ipinfo.
            </p>
        </div>
        <div id="map"></div>
        <div class="text secondary">
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
    //NEW:
    //fetch the relevant data about the user's location
    const phpLoc = "<?php echo $current_loc; ?>";
    const defaultLoc = [53.0758, 8.8072];//deafult location

    // Parse the location from PHP
    let userLoc;
    try {
        const coords = phpLoc.split(',');
        userLoc = [parseFloat(coords[0]), parseFloat(coords[1])];//turn to array
    } catch (error) {
        console.error('Error parsing user location from PHP:', error);
        userLoc = defaultLoc; // Fallback to default location
    }

    // Initialize the map with a default view
    const map = L.map('map').setView(userLoc, 13);

    const tileLayer = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

tileLayer.on('tileload', (event) => {
    console.log(`Tile loaded:`, event.tile.src);
});

map.whenReady(() => {
    console.log('Map is ready!');
});

map.invalidateSize(); // Force the map to redraw


// geolocation data from PHP proxy
fetch('./proxy.php')
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error, status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {

        const loc = data.loc.split(',');
        const lat = parseFloat(loc[0]);
        const lng = parseFloat(loc[1]);
        const ip = data.ip;

        // Updates map view to your location
        map.setView([lat, lng], 13);

        //  Marker and popup
        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup(`IP Address: ${ip}`).openPopup();
    })
    .catch(error => {
        console.error('Error fetching location data or updating the map:', error);
        alert("Unable to fetch location. Default location is shown.");
    });


</script>
</html>