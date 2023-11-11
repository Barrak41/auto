<?php
session_start();
$_SESSION["login"] = false;

$error = [
    "main" => "",
    "username" => "",
    "password" => ""
];

if($_SERVER["REQUEST_METHOD"] == "POST"){ 
    if(!isset($_POST["username"]) || !isset($_POST["password"])){ 
        $error["main"] = "Er liep iets mis bij het versturen van de gegevens.";
    } else {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        if(empty($username)){
            $error["username"] = "Gelieve het gebruikersnaamveld niet leeg te laten.";
        } else if(!filter_var($username, FILTER_VALIDATE_EMAIL)){
            $error["username"] = "Uw gebruikersnaam is geen geldig e-mailadres.";
        } 
        
        if(empty($password)){
            $error["password"] = "Gelieve het wachtwoordveld niet leeg te laten.";
        } else if(strlen($password) < 8){
            $error["password"] = "Het wachtwoord moet uit minstens 8 tekens bestaan.";
        }

        $errorCount = 0;
        foreach($error as $item){
            if(!empty($item)){
                $errorCount++;
            }
        }

        if($errorCount === 0){
            require_once("components\db_con.php");
            $temp = $db_conn->prepare("SELECT * FROM `users` WHERE `email` = :email LIMIT 1");
            $temp->execute(["email" => $username]);
            $user_data = $temp->fetch(); 
            
            if(!isset($user_data["id"])){
                $error["username"] = "Je gegevens zijn mogelijk niet correct.";
            } else if(!password_verify($password, $user_data["password"])){
                $error["password"] = "Uw wachtwoors is niet correct.";
            } else {
                $_SESSION["login"] = true;

                
                header("Location: portal.php");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="css/template.css" rel="stylesheet" type="text/css">
</head>
<body>
   
    <?php
        
    ?>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
        <p class="error"><?php echo $error["main"];?></p>
        <input type="text" placeholder="Gebruikersnaam" name="username">
        <p class="error"><?php echo $error["username"];?></p><br>
        <input type="password" placeholder="Wachtwoord" name="password">
        <p class="error"><?php echo $error["password"];?></p><br>
        <input type="submit" value="Aanmelden">
    </form>
</body>
</html>