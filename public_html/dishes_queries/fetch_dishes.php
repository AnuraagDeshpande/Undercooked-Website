<?php
include '../maintenance/variables.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {        
    // Database connection
    $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch the dishes with rating
    $dishes_sql = "SELECT D.did, D.name, D.price, D.isHalal, D.isVegan, D.isVegetarian, R.rating
                   FROM dishes D, dish_ratings R
                   WHERE R.did = D.did";
    $dishesQ = $conn->prepare($dishes_sql);
    $dishesQ->execute();
    $dishes = $dishesQ->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the result as JSON
    header('Content-Type: application/json');
    echo json_encode($dishes);
    
} catch (PDOException $e) {
    // If there's an error, return an error message as JSON
    echo json_encode(['error' => $e->getMessage()]);
}
?>