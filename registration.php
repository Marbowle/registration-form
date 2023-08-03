<?php
    session_start();

    if(isset($_POST['email']))
    {
        //Udana walidacja 
        $correctWalidation = true;

        //sprawdzenie nickname
        $nick = $_POST['nick'];
        //Sprawdzenie długości nicka
        if((strlen($nick)<3)||(strlen($nick)>20))
        {
            $correctWalidation = false;
            $_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków";
        }

        //Poprawność alfanumerczyna
        if(ctype_alnum($nick)==false)
        {
            $correctWalidation=false;
            $_SESSION['e_nick']="Nick może składać się tylkoz liter i cyfr  
             (bez polskich znaków)";
        }    

        //Sprawdzenie emaila
        $email = $_POST['email'];
        $sanitEmail = filter_var($email,FILTER_SANITIZE_EMAIL);

        if((filter_var($sanitEmail,FILTER_VALIDATE_EMAIL)==false)|| 
         ($sanitEmail!=$email))
        {
            $correctWalidation=false;
            $_SESSION['e_mail']="Niepoprawny e-mail";
        }
        
        //Sprawdzenie haseł 
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if((strlen($password1)<8)||(strlen($password1)>20))
        {
            $correctWalidation=false;
            $_SESSION['e_password']="Hasło musi posiadać od 8 do 20 znaków";
        }
        if($password1!=$password2)
        {
            $correctWalidation=false;
            $_SESSION['e_password']="Podane hasła nie są identyczne";
        }
        
        $hashPassword = password_hash($password1,PASSWORD_DEFAULT);
        
        //Zaznaczenie checkboxa
        if(!isset($_POST['statute']))
        {
            $correctWalidation=false;
            $_SESSION['e_statute']="Brak akceptacji regulaminu";
        }

        //Tutaj dodać recaptcha

        //Zabezpieczenie przed duplikatami

        require_once "connect.php";

            mysqli_report(MYSQLI_REPORT_STRICT);

        try
        {
            $connection = new mysqli($host, $db_user, $db_password ,
             $db_name); 
             if ($connection->connect_errno!=0)
	        {
                throw new Exception(mysqli_connect_errno());
	        }   
            else
            {
                //Czy istnieje email
                $result = $connection->query("SELECT id FROM uzytkownicy 
                 where email='$email'");

                if(!$result) throw new Exception($connection->error);

                $howManyEmails = $result->num_rows;
                if($howManyEmails>0)
                {
                    $correctWalidation=false;
                    $_SESSION['e_mail']="Istnieje już kont połączone z takim 
                    e-mailem";
                }
                //Sprawdzanie czy nick nie jest zajęty
                $result = $connection->query("SELECT id FROM uzytkownicy 
                 where user='$nick'");

                if(!$result) throw new Exception($connection->error);

                $howManyNicks = $result->num_rows;
                if($howManyNicks>0)
                {
                    $correctWalidation=false;
                    $_SESSION['e_nick']="Istnieje już kont z takim nickiem";
                }
                //Wszystko poszło okej udaje się dodać gracza do bazy
                 if($correctWalidation==true)
                    {
                       if($connection->query("INSERT INTO uzytkownicy 
                        VALUES(NULL,'$nick', '$hashPassword', '$email', 100,  
                         100, 100, now() + INTERVAL 14 DAY)"))
                         {
                            $_SESSION['correctRegistration']=true;
                            header('Location: welcome.php');
                            
                         }
                        else 
                        {
                            throw new Exception($connection->error);
                        }
                        
                    }

                $connection->close();
            }
        }
        catch(Exception $e)
        {
            echo '<span style="color:red">Błąd serwera!</span>';
            echo '<p>Informacja deweloperska</p>'.$e;
        }

           
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form - Osadnicy</title>
     
     <style>
        .error 
        {
            color:red;
            margin-top: 10px;
            margin-bottom: 10px;
        }
     </style>
</head>
<body>
    
<form method="post">

    <p>Nickname: <input type="text" name="nick"></p>
    <?php
        if(isset($_SESSION['e_nick']))
        {
            echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
            unset($_SESSION['e_nick']);
        }
    ?>
    <p>E-mail <input type="text" name="email"></p>
    <?php
        if(isset($_SESSION['e_mail']))
        {
            echo '<div class="error">'.$_SESSION['e_mail'].'</div>';
            unset($_SESSION['e_mail']);
        }
    ?>
    <p>Password: <input type="password" name="password1"></p>
     <?php
        if(isset($_SESSION['e_password']))
        {
            echo '<div class="error">'.$_SESSION['e_password'].'</div>';
            unset($_SESSION['e_password']);
        }
    ?>
    <p>Repeat password: <input type="password" name="password2"></p>
    <label><input type="checkbox" name="statute"> Statute accept</label>
     <?php
        if(isset($_SESSION['e_statute']))
        {
            echo '<div class="error">'.$_SESSION['e_statute'].'</div>';
            unset($_SESSION['e_statute']);
        }
    ?>
    <p><input type="submit" value="Zarejestruj się"></p>
    
</form>
 
</body>
</html>