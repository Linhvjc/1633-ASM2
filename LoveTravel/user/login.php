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
      header('location:../entered/html/index.php');
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
   <link rel="icon" type="image/x-icon" href="../assets/img/Icon.jpg">
   <title>Login</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
   
   <link rel="stylesheet" href="../assets/css/base.css">
   <link rel="stylesheet" href="../assets/css/main.css">
   <link rel="stylesheet" href="../assets/css/grid.css">
   <link rel="stylesheet" href="../assets/css/responsive.css">
   <!-- fa icon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
   
   <!-- Themify icon -->
   <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css">
   <!-- Roboto font -->
   <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="css/style.css">
   
</head>
<body>
   <div class="web">
      <div class="page-container">
         <div class="container-left">
            <div class="container-left__content">
               <span class="container-left__content-main">Travel</span>
               <span class="container-left__content-sub">
                  It is a long edtablished fact that a reader will that distracted the content
               </span>
            </div>
         </div>
   
         <div class="container-right">
            <div class="container-right__content">
               <a href= "../index.php" class="container-right__logo">
                     <img src="../assets/img/logo-footer.png" alt="" class="container-right__logo-img">
               </a>
      
               <span class="container-right__welcome">Welcome to Love Travel</span>
               <form class="container-right__form" action="" method="post" enctype="multipart/form-data">
                  <?php
                  if(isset($message)){
                     foreach($message as $message){
                        echo '<div class="message">'.$message.'</div>';
                     }
                  }
                  ?>
                  <label class="label-form" for="email-input">Email</label>
                  <input class="input-form" id="email-input" type="email" name="email" placeholder="Your email..." class="box user-input" required>
                  <label class="label-form" for="password-input">Password</label>
                  <input class="input-form" id="password-input" type="password" name="password" placeholder="Your password..." class="box user-input" required>
                  <div class="btn-form__container">
                     <input type="submit" name="submit" value="Login now" class="btn form-btn">
                  </div>
                  <p class="suggested-text" >Not registered yet? <a class="suggested-link" href="register.php">Create an account</a></p>
               </form>

            </div>
         </div>

      </div>
   </div>

</body>
</html> 