<?php
    //require_once __DIR__.'/../../vendor/autoload.php';
    require_once __DIR__ . '/../../Service/DBConnector.php';
    $configs = require __DIR__ . '/../../config/app.conf.php';
    use Service\DBConnector;
    DBConnector::setConfig($configs['indiv_db']);

    if(!empty($_SESSION)){
        session_destroy();
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
	    <form action="/src/Controller/validation.php" method="post" style="border: 5px dashed orange; border-radius: 15px; padding: 10px; background-color: lightgrey">

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
    <form action="/src/Controller/validation.php" method="post" style="border: 5px dashed lightblue; border-radius: 15px; padding: 10px; background-color: lightgrey">

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

</body>
</html>
