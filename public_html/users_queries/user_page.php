<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undercooked Website</title>
        <link href="../styles.css" rel="stylesheet"/>
    </head>
    <?php
        include 'variables.php';
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        try {
            $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
        
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        

            
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }