<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Dish Pairings</title>
    <link href="../styles.css" rel="stylesheet"/>
    <link href="../dishes_queries/dishes_page.css" rel="stylesheet"/>
</head>
<body class="secondary">
    <?php include './navbar.php'; ?>
    <form  method="POST" class="db_query secondary">
        <div class="dish-card secondary">
            <h1>Enter your credentials:</h1>
            <!--The user has to input the login-->
            <h2>Login:</h2>
            <label for="login">Login:</label>
            <input type="text" name="login" id="login" required minlength="5" maxlength="20" class="background" required>
            <!--Password has to be entered twice in order to check-->
            <h2>Enter your password twice to confirm</h2>
            <label for="pass1">Password:</label>
            <input type="password" name="pass1" id="pass1" required minlength="5" maxlength="20" class="background" required>
            <h2></h2>
            <label for="pass2">Password:</label>
            <input type="password" name="pass2" id="pass2" required minlength="5" maxlength="20" class="background" required>
            <h2></h2>
            <input type="checkbox" name="critic" id="critic">
            <label for="critic">become critic</label>

            <!--The user can submit the form contents by pressing a button-->
            <h2></h2>
            <input type="submit" value="add" class="accent">

            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>
    </form>

    
    <form>
        <div class="dish-card secondary">

        </div>
    </form>
</body>
</html>
