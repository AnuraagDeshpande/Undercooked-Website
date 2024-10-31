<?php
    
    session_start();
?>
<nav class="navbar">
        <div class="navbar_container">
            <img src="/images/logo3.png" alt="logo" class="navbar_item">
            <a href="/" id="navbar_logo" class="logo"><h1>Undercooked</h1></a>
            <div class="navbar_toggle" id="mobile_menu">
                <span class="bar"></span><span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar_menu">
                <li class="navbar_item">
                    <a href="/" class="navbar_links">Home</a>
                </li>
                <li class="navbar_item">
                    <a href="/dishes_queries/dishes_page.php" class="navbar_links">Dishes</a>
                </li>
                <li class="navbar_item">
                    <a href="/review_queries/review_page.php" class="navbar_links">Reviews</a>
                </li>
                <li class="navbar_item">
                    <a href="/" class="navbar_links">This week</a>
                </li>
                <li class="navbar_item">
                    <a href="/maintenance/maintenance.php" class="navbar_links">Maintenance</a>
                </li>
                <li class="navbar_item">
                    <a href="/users_queries/user_page.php" class="navbar_links">Users</a>
                </li>
                <li class="navbar_btn">
                    <a href="/login.php" class="button">
                        <?php if (isset($_SESSION['user_id'])):?>
                            <?php echo htmlspecialchars($_SESSION['user_id']);?>
                        <?php else:?>
                            Login/Sign up
                        <?php endif;?>
                    </a>
                </li>
            </ul>
        <div class="box">
            <form action="" method="GET" id="search-form"> <!-- Change the action as needed -->
                <input type="text" placeholder="Search dishes" id="search" name="search_query" required>
                <button type="submit" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>  
    </nav>