<?php
  //Open the session
  session_start();
  if (isset($_SESSION["user"])) {
    //SESSION ALREADY CREATED
    //SHOW SESSION DATA
    var_dump($_SESSION);
  } else {
    session_destroy();
    header("Location: login.php");
  }
 ?>

 <!DOCTYPE html>
 <html lang="en">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title></title>
     <link rel="stylesheet" type="text/css" href="estilos.css">
   </head>
   <body>

     <?php
         //FORM SUBMITTED
         if (isset($_POST["user"])) {
           //CREATING THE CONNECTION
           $connection = new mysqli("192.168.1.78", "root", "3316", "liberty");
           //TESTING IF THE CONNECTION WAS RIGHT
           if ($connection->connect_errno) {
               printf("Connection failed: %s\n", $connection->connect_error);
               exit();
           }
           //MAKING A SELECT QUERY
           //Password coded with md5 at the database. Look for better options
           $consulta="select * from USUARIOS where
           username='".$_POST["user"]."' and password=md5('".$_POST["password"]."');";
           //Test if the query was correct
           //SQL Injection Possible
           //Check http://php.net/manual/es/mysqli.prepare.php for more security
           if ($result = $connection->query($consulta)) {
               //No rows returned
               if ($result->num_rows===0) {
                 echo "LOGIN INVALIDO";
               } else {
                 //VALID LOGIN. SETTING SESSION VARS
                 $_SESSION["user"]=$_POST["user"];
                 $_SESSION["language"]="es";
                 header("Location: index.php");
               }
           } else {
             echo "Wrong Query";
           }
       }
     ?>

     <form action="login.php" method="post">

       <p><input name="user" required></p>
       <p><input name="password" type="password" required></p>
       <p><input type="submit" value="Log In"></p>

     </form>



   </body>
 </html>
