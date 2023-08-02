<?php
        session_start();
        if(!isset($_SESSION['correctRegistration']))
        {
            header('Location: index.php ');
            exit();
        }
        else 
        {
            unset($_SESSION['correctRegistration']);
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welocem to Osadnicy</title>
</head>
<body>
     <h1>Dziękujemy za rejestracje w serwisie</h1>
     <p><a href="index.php">Zaloguj się do konta</a></p>
</body>
</html>