<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarVista</title>
    <link rel="stylesheet" href="../auto/css/template.css">
</head>
<body>
    <main class="main_container">

    </main>

    <?php
    $error = [
        "main" => "",
        "username" => "",
        "password" => "",
        "email" => "",
        "conf_password" => ""
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!isset($_POST["user_name"]) || !isset($_POST["password"]) || !isset($_POST["email"]) || !isset($_POST["date"])) {
            $error["main"] = "Er liep iets mis bij het versturen van de gegevens";
        }else {
            $user_name = $_POST["user_name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $conf_password = $_POST["conf_password"];
            if(empty(trim($user_name))){
                $error["username"] = "Gelieve het gebruikersnaamveld niet leeg te laten.";
                echo $error["username"];
            }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error["email"] = "Uw e-mailadres is niet geldig.";
                echo $error["email"];
            } 
            if(empty(trim($password))){
                $error["password"] = "Gelieve het wachtwoordveld niet leeg te laten.";
                echo $error["password"];
            } else if(strlen(trim($password)) < 8){
                $error["password"] = "Het wachtwoord moet uit minstens 8 tekens bestaan.";
                echo $error["password"];
            }

            if($conf_password !== $password){
                $error["conf_password"] = "Uw wachtwoorden komen niet overeen";
                echo $error["conf_password"];
            } else {
                require_once("components\db_con.php");

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $query = "INSERT INTO `users` (`name`, `email`,`password`,`birth_date`, `user_type` ) VALUES (:name, :email, :password, :birth_date, :user_type)";

                $stmt = $db_conn->prepare($query);

                $stmt->bindParam(":name", $user_name);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":password", $hashed_password);
                $stmt->bindParam(":birth_date", $_POST["date"]);
                $stmt->bindParam(":user_type", $_POST["Sub_type"]);

                if ($stmt->execute()) {
                    echo "Signd up"; 
                } else {
                    echo "Error signing up";
                }
                
                }
            }
            
        }
            
    ?>

    <form action="" novalidate="novalidate" method="POST">
        <input type="text" placeholder="Naam" name="user_name" class="inputs">
        <input type="email" placeholder="Email" name="email" class="inputs">
        <input type="password" placeholder="Wachtwoord" name="password" class="inputs">
        <input type="password" placeholder="Herhaal Wachtwoord" name="conf_password" class="inputs">
        <input type="date" placeholder="Geboortedatum" name="date" class="inputs">
            
        <label for="selectoption"></label>
        <select name="Sub_type" id="select_sub" class="inputs">
            <option value="klant">Klant</option>
            <option value="Leverancier">Leverancier</option>
        </select>
        <input type="submit" value="Enter" class="submit">
    </form>
</body>
</html>
