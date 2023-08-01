<?php

    require_once "connect.php";

   $connection = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connection->connect_errno!=0)
	{
		echo "Error: ".$connection->connect_errno;
	}
	else
	{
		$login = $_POST['login'];
		$password = $_POST['password'];
           
       $sql = " SELECT * FROM uzytkownicy WHERE 
       user='$login' AND 
       pass='$password'";

       if($result = @$connection->query($sql))
       {
            $howManyUsers = $result->num_rows;
            if($howManyUsers>0)
            {
                $row = $result->fetch_assoc();
                $user = $row['user'];
                

                $result->close();
                header('Location: game.php');
            }
            else 
            {

            }
       }

        $connection->close();
    }



?>