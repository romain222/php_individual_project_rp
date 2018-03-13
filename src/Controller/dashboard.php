<?php
require_once __DIR__ . '/../../Service/DBConnector.php';
use Service\DBConnector;
$configs = require __DIR__ . '/../../config/app.conf.php';
DBConnector::setConfig($configs['indiv_db']);

session_start();
$userId = $_SESSION['userId'] ?? null;
$username = $_SESSION['username'] ?? null;
$password = $_SESSION['password'] ?? null;
$favNumber = null;

// SELECT favNumber query
$connection = DBConnector::getConnection();
$sql = "SELECT favNumber FROM user WHERE id = $userId;";
$statement = $connection->prepare($sql);
$statement->execute();

$allResults = $statement->fetchAll();

// 
if(!empty($allResults)){
    $favNumber = $allResults[0]['favNumber'];
}

// if new favNumber has been send to be updated
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $favNumberTemp = $_POST['favNumber'] ?? null;
    $favNumberError = !is_numeric($favNumberTemp);
    
    if(!$favNumberError){
        $favNumber = $favNumberTemp;
        
        $sql = "UPDATE user SET favNumber = $favNumber WHERE id = $userId;";
        $statement = $connection->prepare($sql);
        $statement->execute();
    }
}

//session_destroy();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Dashboard from <?php echo $username;?></title>
    </head>
	<body>
    	<h1>Welcome <?php echo $username; ?></h1>
    	<?php 
    	if(!$favNumber ?? $favNumberError ?? false){ ?>
    	   <p>Something went wrong saving new favourite Number</p>
    	<?php }?>
    	<h2>Your favourite number is <?php echo $favNumber ?? 'not set'; ?></h2>
    	
    	<form action="/src/Controller/dashboard.php" method="post">
    		<label for="favNumber">Favorite Number: </label>
    		<input type="number" name="favNumber">
    		<input type="submit">
    	</form> 
    	
    	<a href="logout.php">Logout here</a>
    </body>
</html>
