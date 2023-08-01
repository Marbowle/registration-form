<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osadnicy - game panel</title>
</head>
<body>
    <?php

        echo "<p>Witaj ".$_SESSION['user'].'![<a href="logout.php">Wyloguj  
         się!</a>]</p>';
        echo "<p><b>Drewno</b> ".$_SESSION['drewno'];
        echo "|<b> Kamień</b> ".$_SESSION['kamien'];
        echo "|<b> Zboże</b> ".$_SESSION['zboze']."</p>";

        echo "<p><strong>E-mail</strong>: ".$_SESSION['email']."</p>";
        echo "<p><strong>Dni premium</strong>: ".$_SESSION['dnipremium']."  
         </p>";


    ?>


</body>
</html>