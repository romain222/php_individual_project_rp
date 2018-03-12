<?php
    include __DIR__ . '/../../Service/DBConnector.php';
    $configs = require __DIR__ . '/../../config/app.conf.php';
    use Service\DBConnector;

    DBConnector::setConfig($configs['indiv_db']);

    if(!empty($_SESSION)){
        session_destroy();

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $username = $_POST['username'] ?? null;
        $password1 = $_POST['password_1'] ?? null;
        $password2 = $_POST['password_2'] ?? null;

        $usernameError = false;
        $passwordError = false;

        $connection = DBConnector::getConnection();

        $sql1 = "SELECT * FROM user WHERE username = \"$username\"";
        $statement = $connection->prepare($sql1);
        $statement->execute();

        $allResults = $statement->fetchAll();

        if(empty($allResults)){

            $usernameError = !is_string($username) || strlen($username) < 4;
            $passwordError = $password1 !== $password2 || !is_string($password1);

            if(!$usernameError && !$passwordError){
                $sql = "INSERT INTO user(username, password) VALUES(\"$username\" , \"$password1\" );";
                $affected = $connection->exec($sql);



                if(!$affected){
                    echo implode(', ', $connection->errorInfo());
                }
            }
        }

        session_start();

        $usernameLogin = $_POST['usernameLogin'] ?? null;
        $passwordLogin = $_POST['passwordLogin'] ?? null;
        $userId = $_POST['id'] ?? null;

        $sql = "SELECT * FROM user WHERE username = \"$usernameLogin\" AND password = \"$passwordLogin\";";
        $statement2 = $connection->prepare($sql);
        $statement2->execute();
        $allResults2 = $statement2->fetchAll();

        $statement = $connection->prepare($sql1);
        $statement->execute();
        $allResults = $statement->fetchAll();

        //print_r($allResults);
        if(!empty($allResults2 || !empty($allResults))){
            $_SESSION['userId'] = $allResults2[0]['id'] ?? $allResults[0]['id'];
            $_SESSION['username'] = $allResults2[0]['username'] ?? $allResults[0]['username'];
            ?>

			<p><?php echo "WELCOME ".$_SESSION['username']." with ID: " . $_SESSION['userId'] . PHP_EOL;?></p>
			<?php 
        } else {
            echo "BAD LOGIN";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../css/style.min.css">
        <title>Indentify sourself</title>
    </head>
<body>
	<?php if(empty($_SESSION)){ ?>
	<div>
	    <h1>Register here</h1>
	    <form action="/src/Controller/register.php" method="post" style="border: 5px dashed orange; border-radius: 15px; padding: 10px; background-color: lightgrey">

	    	<?php
	        if($usernameError ?? false){?>
    	    	<p>Something went wrong with your username.</p>
    		<?php } ?>

        	<label for="username"> Username :</label>
        	<input type="text" name="username"/>

        	<br>

        	<?php
    	     if($passwordError ?? false){?>
    	    <p>Something went wrong with your password.</p>
    		<?php } ?>

        	<label for="password_1"> Password :</label>
        	<input type="password" name="password_1">

        	<br>

        	<label for="password_2"> Confirm password :</label>
        	<input type="password" name="password_2">

        	<br>

        	<input type="submit">

    	</form>
    </div>
    <?php } ?>

    <?php if(empty($_SESSION)){ ?>
    <div>
    <h1>Login here</h1>
    <form action="/src/Controller/register.php" method="post" style="border: 5px dashed lightblue; border-radius: 15px; padding: 10px; background-color: lightgrey">

    	<label for="usernameLogin"> Username :</label>
        <input type="text" name="usernameLogin"/>

        <br>

        <label for="passwordLogin"> Password :</label>
        <input type="password" name="passwordLogin">

        <br>

        <input type="submit">

    </form>
    </div>
	<?php }?>


    <?php
    if($_SESSION['userId'] ?? false){ ?>
        <a href="dashboard.php">View Dashboard here !</a>
    <?php }
    ?>
</body>
</html>
