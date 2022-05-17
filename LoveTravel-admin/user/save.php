<?php

include 'config.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email'");

   if(mysqli_num_rows($select) > 0){
      $message[] = 'User already exist'; 
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm password not matched!';
      }elseif($image_size > 2000000){
         $message[] = 'Image size is too large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `user_form`(name, email, password, image) VALUES('$name', '$email', '$pass', '$image')") or die('query failed');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Registered successfully!';
            header('location:login.php');
         }else{
            $message[] = 'Registeration failed!';
         }
      }
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
   <title>Register</title>

   <!-- custom css file link  -->
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
   <link rel="stylesheet" href="css/additional.css">

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

               <span class="container-right__welcome">Register</span>

               <form id ="form-1" class="container-right__form" action="" method="post" enctype="multipart/form-data">
               <?php
                  if(isset($message)){
                  foreach($message as $message){
                     echo '<div class="message">'.$message.'</div>';
                  }
                  }
               ?>
                  <div class="form-group">
                     <label class="label-form" for="">Username</label>
                     <input id ="username" class="input-form" type="text" name="name" placeholder="Your username..." required>
                     <span class="form-message"></span>
                  </div>
                  <div class="form-group">
                     <label class="label-form" for="">Email</label>
                     <input id ="email" class="input-form" type="email" name="email" placeholder="Your email..." required>
                     <span class="form-message"></span>
                  </div>
                  <div class="form-group">
                     <label class="label-form" for="">Password</label>
                     <input id ="password" class="input-form" type="password" name="password" placeholder="Your password..." required>
                     <span class="form-message"></span>
                  </div>
                  <div class="form-group">
                     <span class="form-message"></span>
                     <label id ="repassword" class="label-form" for="">Repassword</label>
                     <input class="input-form" type="password" name="cpassword" placeholder="Confirm your password..." required>
                  </div>
                  <label class="label-form" for="">Avatar</label>
                  <input class="input-form input-form--img" type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
                  
                  <div class="btn-form__container">
                     <input type="submit" name="submit" value="Register now" class="btn form-btn">
                  </div>
                  <p class="suggested-text">Already have an account? <a class="suggested-link" href="login.php">Login now</a></p>
               </form>
            </div>
         </div>
      </div>
   </div>

   <script src="./validator.js"></script>

   <script>

      Validator({
         form: '#form-1',
         rules: [
            Validator.isRequired('#username'),
            Validator.isEmail('#email'),
            Validator.isRequired('#password'),
            Validator.isRequired('#repassword'),
         ]
      })
   </script>
</body>
</html>