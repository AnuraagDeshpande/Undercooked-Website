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
                    <a href="/maintenance/maintenance.html" class="navbar_links">Maintenance</a>
                </li>
                <li class="navbar_item">
                    <a href="/users_queries/user_page.php" class="navbar_links">Users</a>
                </li>
                <li class="navbar_btn">
                    <a href="/" class="button">Login/Sign up</a>
                </li>
            </ul>
            <div class="box">
                <input type="text" placeholder="search" id="search">
                <a href="#">
                    <i class="fas fa-search"></i>
                </a>
            </div>
            <!-- Card Container (This is where the dish cards will be dynamically displayed) -->
            <div id="card-container"></div>
        </div>
    </nav>