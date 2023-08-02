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
        echo $hashPassword; exit();
            if($correctWalidation==true)
            {
                //Wszystko oke, gracz do bazy xd
                echo "udana walidacja";
                exit();
                
            }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form - Osadnicy</title>
     <script src="https://www.google.com/recaptcha/api.js?render=6Lc3-3QnAAAAABlyQnEoPv8GVdY3E2u38fLbFCVU"></script>
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
    <p><input type="submit" value="Zarejestruj się"></p>
</form>
   <script>
      function onClick(e) {
        e.preventDefault();
        grecaptcha.ready(function() {
          grecaptcha.execute('6Lc3-3QnAAAAABlyQnEoPv8GVdY3E2u38fLbFCVU', 
           {action: 'submit'}).then(function(token) {
          });
        });
      }
  </script>

</body>
</html>