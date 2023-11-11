<?php
    require_once("../components/user_access.php");

    if (check_right("view_users")) {
     
        require_once("../components/db_con.php");

        
        $sql = "SELECT `users`.`name`, `users`.`active`, `roles`.`name`
                FROM `users`
                INNER JOIN `user_has_roles` AS `roles` ON `users`.`id` = `roles`.`id`";

        $result = $db_conn->query($sql);

        if ($result) {
            echo "<h1>User lijst</h1>";
            echo "<table border='1'>";
            echo "<tr>
                    <th>Naam</th>
                    <th>Blocked</th>
                    <th>User Role</th>
                  </tr>";

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $blocked = $row['active'] ? 'Yes' : 'No';

                echo "<tr>
                        <td>" . $row['name'] . "</td>
                        <td>" . $blocked . "</td>
                        <td>" . $row['name'] . "</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "Er ging iets mis met de data";
        }
    } else {
        echo "Je hebt geen toegang om users de bekijken";
    }

    function check_right($right_name) {
        if (in_array($right_name, $_SESSION["user_rights"])) {
            return true;
        } else {
            return false;
        }
    }
?>
