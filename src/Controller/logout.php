<?php
if(!empty($_SESSION)){
    session_destroy();
}
include __DIR__.'/register.php';
?>