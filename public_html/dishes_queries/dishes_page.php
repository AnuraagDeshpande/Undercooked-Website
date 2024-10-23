<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undercooked Website</title>
    <link href="styles.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
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
    
</div>
</body>