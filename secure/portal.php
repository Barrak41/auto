<?php
    require_once("./components/user_acess.php");
    if(check_right("welcome message")){
        echo "Welkom!";
    }
    if(check_right("upload image")){
        echo "Je kan afbeeldingen uploaden";
    }

    function check_right($right_name){
        if(in_array($right_name, $_SESSION["user_rights"])){
            return true;
        } else {
            return false;
        }
    }
?>