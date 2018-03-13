<?php
require_once __DIR__ . '/../../Service/DBConnector.php';
use Service\DBConnector;
$configs = require __DIR__ . '/../../config/app.conf.php';
DBConnector::setConfig($configs['indiv_db']);

session_start();
$userId = $_SESSION['userId'] ?? null;

$connection = DBConnector::getConnection();
$sql = "DELETE FROM user WHERE id = $userId;";
$statement = $connection->prepare($sql);
$statement->execute();


?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8">
		<title>Deleting account</title>
	</head>
	<body>
		<a href="/src/Controller/register.php">Good bye...</a>
	</body>
</html>