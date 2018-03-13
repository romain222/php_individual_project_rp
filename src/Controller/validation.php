<?php
require_once __DIR__ . '/../../Service/DBConnector.php';
$configs = require __DIR__ . '/../../config/app.conf.php';
use Service\DBConnector;
DBConnector::setConfig($configs['indiv_db']);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    
    session_start();
    
    // registration
    $username = $_POST['username'] ?? null;
    $password1 = $_POST['password_1'] ?? null;
    $password2 = $_POST['password_2'] ?? null;
    
    $usernameError = false;
    $passwordError = false;
    
    $connection = DBConnector::getConnection();
    if(isset($username)){
    
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
                // update $allResults (if someone registered)
                $statement = $connection->prepare($sql1);
                $statement->execute();
                $allResults = $statement->fetchAll();
                
                $_SESSION['userId'] = $allResults[0]['id'];
                $_SESSION['username'] = $allResults[0]['username'];
                
                include __DIR__.'/dashboard.php';
            } else {
                echo 'Invalid data. Username must have at least 4 characters';
                include __DIR__.'/register.php';
            }
        } else {
            echo 'user already exists';
            include __DIR__.'/register.php';
        }
    } else{
        // login
        
        $usernameLogin = $_POST['usernameLogin'] ?? null;
        $passwordLogin = $_POST['passwordLogin'] ?? null;
        
        $sql = "SELECT * FROM user WHERE username = \"$usernameLogin\" AND password = \"$passwordLogin\";";
        $statement2 = $connection->prepare($sql);
        $statement2->execute();
        $allResults2 = $statement2->fetchAll();
        
        
        if(!empty($allResults2)){
            $_SESSION['userId'] = $allResults2[0]['id'];
            $_SESSION['username'] = $allResults2[0]['username'];
            
            include __DIR__.'/dashboard.php';
            
        } else {
            echo 'Invalid login data';
            include __DIR__.'/register.php';
        }
    }
}
?>