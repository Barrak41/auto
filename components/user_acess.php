<?php
session_start();
if(isset($_SESSION["login"])){
    if(!$_SESSION["login"]){
        header('Location: ../login.php');
        exit();
    }
} else {
    header('Location: ../login.php');
    exit();
}
?>