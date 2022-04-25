<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

   mysqli_query($conn, "UPDATE `user_form` SET name = '$update_name', email = '$update_email' WHERE id = '$user_id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

   if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'Old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'Confirm password not matched!';
      }else{
         mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
         $message[] = 'Password updated successfully!';
      }
   }

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'Image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET image = '$update_image' WHERE id = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'Image updated succssfully!';
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
   <title>Update profile</title>

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
   <style>
      input[type=file]::file-selector-button {
         border: none;
         padding: .2em .4em;
         border-radius: .2em;
         background-color: #029e91;
         height: 30px;
         width: 120px;
         color: #fff;
      }
   
      input[type=file]::file-selector-button:hover {
         opacity: 0.2;
      }
      
      .label-form {
         font-size: 1.6rem;
         letter-spacing: 1.5px;
      }

      .label-form__avt,
      .label-form:first-child {
         margin-top: 20px;
      }
   </style>
</head>
<body>
   <div class="web">
      <div class="update-profile">
         <div class="update-profile__content">
            <?php
               $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
               if(mysqli_num_rows($select) > 0){
                  $fetch = mysqli_fetch_assoc($select);
               }
            ?>
      
            <form action="" method="post" enctype="multipart/form-data">
               <p class="update-profile__heading">EDIT INFORMATION</p>
               <?php
                  if($fetch['image'] == ''){
                     echo '<img class="update-profile__img" src="images/default-avatar.png">';
                  }else{
                     echo '<img class="update-profile__img" src="uploaded_img/'.$fetch['image'].'">';
                  }

                  echo '<label class="label-form label-form__avt">Update yor avatar</label>';
                  echo '<input class="update-profile__img-btn" type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">';
                  if(isset($message)){
                     foreach($message as $message){
                        echo '<div class="message">'.$message.'</div>';
                     }
                  }
               ?>
               <div class="flex">
                  <div class="inputBox">
                     <label class="label-form">Username :</label>
                     <input class="input-form" type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="box">
                     <label class="label-form">Email :</label>
                     <input class="input-form" type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
                     
                     
                  </div>
                  <div class="inputBox">
                     <input class="input-form" type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
                     <label class="label-form">Old password :</label>
                     <input class="input-form" type="password" name="update_pass" placeholder="Enter previous password" class="box">
                     <label class="label-form">New password :</label>
                     <input class="input-form" type="password" name="new_pass" placeholder="Enter new password" class="box">
                     <label class="label-form">Confirm password :</label>
                     <input class="input-form" type="password" name="confirm_pass" placeholder="Confirm new password" class="box">
                  </div>
               </div>
               <input style = "background-color:#029e91; width: 100%;" type="submit" value="Update profile" name="update_profile" class="btn form-btn">
               <a href="../entered/html/index.php" class="btn form-btn">Back to home</a>
            </form>
         </div>
   
      </div>

   </div>

</body>
</html>