
<?php 
    include './navbar.php';
    global $our_root;
    include $php_root.'/maintenance/variables.php';

    // Fetch usernames from the database
    $usernames = [];
    try {
        $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT login FROM users");
        $stmt->execute();
        $usernames = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo $our_root?>/styles.css" rel="stylesheet"/>
    <link href="<?php echo $our_root?>/dishes_queries/dishes_page.css" rel="stylesheet"/>
    <title>Undercooked Website - Search Users</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
    <?php
        include $php_root . '/logger.php';
    ?>
    <h1>Search Users:</h1>
    <form action="" method="POST">
        <input type="text" name="user_login" id="user_login" placeholder="Enter user login or type" required>
        <button type="submit">Search</button>
    </form>

    <script>
        // Embed PHP array into JavaScript for autocomplete
        const usernames = <?php echo json_encode($usernames); ?>;
        
        $(document).ready(function() {
            $("#user_login").autocomplete({
                source: usernames, // Use the preloaded usernames array
                minLength: 2 // Start autocomplete after typing two characters
            });
        });
    </script>

    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        if (isset($_POST['user_login'])) {
            $user_login = $_POST['user_login'];

            try {
                $conn = new PDO("mysql:unix_socket=$socket;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $normalized_login = ucfirst(strtolower($user_login));

                if ($normalized_login == "critic") {
                    $userQ = $conn->prepare("
                        SELECT U.uid, U.login, U.isCritic
                        FROM users U
                        WHERE U.isCritic = 1
                    ");
                } else {
                    $userQ = $conn->prepare("
                        SELECT U.uid, U.login, U.isCritic
                        FROM users U
                        WHERE LOWER(U.login) LIKE LOWER(:user_login)
                    ");
                    $search_login = '%' . $user_login . '%';
                    $userQ->bindParam(':user_login', $search_login, PDO::PARAM_STR);
                }

                $userQ->execute();
                $users = $userQ->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }

            if (is_array($users) && count($users) > 0): ?>
                <h2>Users found:</h2>
                <?php foreach ($users as $row): ?>
                    <div class="dish-card secondary review">
                        <div class="card-header">
                            <h3 class="review_header">
                                <a href="<?php echo $our_root?>/user_queries/user_result.php?uid=<?php echo urlencode($row['uid']); ?>">
                                    <?php echo htmlspecialchars($row['login']); ?>: 
                                    <?php echo htmlspecialchars($row['isCritic'] ? 'Is a Critic' : 'Is not a Critic'); ?>
                                </a>
                            </h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No users found matching that login or type.</p>
            <?php endif; 
        }
    ?>
</body>
</html>
