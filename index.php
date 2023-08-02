<?php
    session_start();

    if(isset($_SESSION['loginToGame'])&&($_SESSION['loginToGame']==true))
    {
        header('Location: game.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Osadnicy - gra przeglądarkowa</title>
</head>
<body>
   Tylko martiw ujrzeli koniec wojny - Platon
    <p><a href="registration.php">Rejestracja - załóż darmowe konto!</a></p>
     
    <form action="login.php" method="post">
    <p>Login: <input type="text" name="login">
    </p>
    <p>Password: <input type="password" name="password">
    </p>
    <input type="submit" value="Log in" >
    </form>

        <?php
            if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
        ?>

</body>
</html>