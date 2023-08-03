<?php
    session_start();
    if(!isset($_SESSION['loginToGame']))
    {
        header('Location: index.php');
        exit();
    }
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
        echo "<p><strong>Data wygaśnięcia premium</strong>: ".$_SESSION['dnipremium']."  
         </p>";

         $countTime = new DateTime('2026-02-13 12:14:21');
         echo "Data i czas serwera ".$countTime->format('Y-m-d H:i:s');
        
         $endOfPremium = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['dnipremium']);

         $diffrentTime = $countTime->diff($endOfPremium);
         
         if($countTime<$endOfPremium)
          echo "Pozostało ci jeszcze ",$diffrentTime->format('%d dni, %h godz, %i min, %s s');
           else 
           echo "Premium nieakatywne od: ",$diffrentTime->format('%d dni, %h 
           godz, %i min, %s s');

    ?>
</body>
</html>