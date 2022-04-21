<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:../entered/index.html');
   }else{
      $message[] = 'Incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/additional.css">
   
</head>
<body>
   
   <div class="form-container">
      <a href= "../index.php" class="content-logo">
            <img src="../assets/img/homelogo.png" alt="" class="content-img">
      </a>
      <form action="" method="post" enctype="multipart/form-data">
         <h3 class="form-heading">Login</h3>
         <?php
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
         ?>
         <input id="email-input" type="email" name="email" placeholder="Your email..." class="box user-input" required>
         <input type="password" name="password" placeholder="Your password..." class="box user-input" required>
         <input type="submit" name="submit" value="Login now" class="btn">
         <p class="suggest-text" >Not registered yet? <a class="suggest-link" href="register.php">Create an account</a></p>
      </form>

   </div>

</body>
</html> 