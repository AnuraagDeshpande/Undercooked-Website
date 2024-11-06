<link href="<?php echo $html_root?>styles.css" rel="stylesheet"/>
<link href="./dishes_page.css" rel="stylesheet"/>
<nav class="navbar">
        <div class="navbar_container">
            <img src="/images/logo3.png" alt="logo" class="navbar_item">
            <a href="<?php echo $html_root?>" id="navbar_logo" class="logo"><h1>Undercooked</h1></a>
            <div class="navbar_toggle" id="mobile_menu">
                <span class="bar"></span><span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar_menu">
                <li class="navbar_item">
                    <a href="<?php echo $html_root?>" class="navbar_links">Home</a>
                </li>
                <li class="navbar_item">
                    <a href="<?php echo $html_root?>dishes_queries/dishes_page.php" class="navbar_links">Dishes</a>
                </li>
                <li class="navbar_item">
                    <a href="<?php echo $html_root?>review_queries/review_page.php" class="navbar_links">Reviews</a>
                </li>
                <li class="navbar_item">
                    <a href="<?php echo $html_root?>" class="navbar_links">This week</a>
                </li>
                <li class="navbar_item">
                    <a href="<?php echo $html_root?>maintenance/maintenance.php" class="navbar_links">Maintenance</a>
                </li>
                <li class="navbar_item">
                    <a href="<?php echo $html_root?>users_queries/user_page.php" class="navbar_links">Users</a>
                </li>
                <li class="navbar_btn">
                    <a href="<?php echo $html_root?>" class="button">Login/Sign up</a>
                </li>
            </ul>
        <div class="box">
            <form action="/dishes_queries/dishes_page.php" method="GET" id="search-form"> <!-- Change the action as needed -->
                <input type="text" placeholder="Search..." id="search" name="search_query" required>
                <button type="submit" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>  
    </nav>