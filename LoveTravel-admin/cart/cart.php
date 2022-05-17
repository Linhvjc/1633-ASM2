<?php
    session_start();
    if(!isset($_SESSION['giohang'])) $_SESSION['giohang']=[];
    //làm rỗng giỏ hàng
    if(isset($_GET['delcart'])&&($_GET['delcart']==1)) unset($_SESSION['giohang']);
    //xóa sp trong giỏ hàng
    if(isset($_GET['delid'])&&($_GET['delid']>=0)){
       array_splice($_SESSION['giohang'],$_GET['delid'],1);
    }
    //lấy dữ liệu từ form
    if(isset($_POST['addcart'])&&($_POST['addcart'])){
        $hinh=$_POST['hinh'];
        $tensp=$_POST['tensp'];
        $gia=$_POST['gia'];
        $soluong=$_POST['soluong'];

        //kiem tra sp co trong gio hang hay khong?

        $fl=0; //kiem tra sp co trung trong gio hang khong?

        for ($i=0; $i < sizeof($_SESSION['giohang']); $i++) { 
            
            if($_SESSION['giohang'][$i][1]==$tensp){
                $fl=1;
                $soluongnew=$soluong+$_SESSION['giohang'][$i][3];
                $_SESSION['giohang'][$i][3]=$soluongnew;
                break;

            }
            
        }
        //neu khong trung sp trong gio hang thi them moi
        if($fl==0){
            //them moi sp vao gio hang
            $sp=[$hinh,$tensp,$gia,$soluong];
            $_SESSION['giohang'][]=$sp;
        }

       // var_dump($_SESSION['giohang']);
    }

    function showgiohang(){
        if(isset($_SESSION['giohang'])&&(is_array($_SESSION['giohang']))){
            if(sizeof($_SESSION['giohang'])>0){
                $tong=0;
                for ($i=0; $i < sizeof($_SESSION['giohang']); $i++) { 
                    $tt=$_SESSION['giohang'][$i][2] * $_SESSION['giohang'][$i][3];
                    $tong+=$tt;
                    echo '<tr>
                            <td>'.($i+1).'</td>
                            <td><img src="./images/'.$_SESSION['giohang'][$i][0].'" alt=""></td>
                            <td>'.$_SESSION['giohang'][$i][1].'</td>
                            <td>'.$_SESSION['giohang'][$i][2].'</td>
                            <td>'.$_SESSION['giohang'][$i][3].'</td>
                            <td>
                                <div>'.$tt.'</div>
                            </td>
                            <td ">
                                <a style="color: red;" href="cart.php?delid='.$i.'">Delete</a>
                            </td>
                        </tr>';
                }
                echo '<tr>
                        <th style="color: red;" colspan="5">Total</th>
                        <th>
                            <div style="color: red;">'.$tong.'</div>
                        </th>
    
                    </tr>';
            }else{
                echo '<span style="color: red; font-size: 18px;">Cart is empty!</span>';
            }    
        }
    }
    

    ini_set('display_errors','Off');
    ini_set('error_reporting', E_ALL );
    define('WP_DEBUG', false);
    define('WP_DEBUG_DISPLAY', false);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | View Cart</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/Icon.jpg">

    <!-- reset css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/destination.css">
    <link rel="stylesheet" href="../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/destinationresponsive.css">
     <!-- fa icon -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    
     <!-- Themify icon -->
     <link rel="stylesheet" href="../assets/themify-icons/themify-icons.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

     <!-- Roboto font -->
     <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="preloading">
    <div class="web">
        <!-- <div class="loader">
            <span class="fas fa-spinner xoay icon"></span>
        </div> -->
        <!-- Header -->
        <header class="header-destination" style="background-image: url(../assets/img/cartbr.jpg);">
            <div class="navbar">
                <div class="grid wide navbar--grid">
                    <div class="row navbar--wrap">
                        <a href="../entered/html/index.php" class="navbar__logo-link">
                            <img src="../assets/img/homelogo.png" alt="" class="navbar__logo-img">
                        </a>
    
                        <ul class="navbar__list hide-on-tablet-mobile">
                            <li class="navbar__item">
                                <a href="../entered/html/index.php" class="navbar__item-link">HOME</a>
                            </li>
                            <li class="navbar__item">
                                <a href="#" class="navbar__item-link">PACKAGES</a>
                                <ul class="navbar__item-list">
                                    <li class="navbar__item-item navbar__item-item--hot">
                                        <a href="#" class="navbar__item-item-link">Search 1</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item navbar__item-item--new">
                                        <a href="#" class="navbar__item-item-link">Search 2</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item navbar__item-item--row">
                                        <a href="#" class="navbar__item-item-link">Tour Package</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                            <ul class="navbar-list__additional">
                                                <li class="navbar-list__additional-item">
                                                    <a href="#" class="navbar-list__additional-item-link">Carousel</a>
                                                </li>
                                                <li class="navbar-list__additional-item">
                                                    <a href="#" class="navbar-list__additional-item-link">Custom map</a>
                                                </li>
                                                <li class="navbar-list__additional-item">
                                                    <a href="#" class="navbar-list__additional-item-link">360 Panorama</a>
                                                </li>
                                                <li class="navbar-list__additional-item">
                                                    <a href="#" class="navbar-list__additional-item-link">Default</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item">
                                        <a href="#" class="navbar__item-item-link">Destination</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item">
                                        <a href="#" class="navbar__item-item-link">Topology</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="navbar__item">
                                <a href="#" class="navbar__item-link">SHOP</a>
                                <ul class="navbar__item-list">
                                    <li class="navbar__item-item ">
                                        <a href="#" class="navbar__item-item-link">Archive</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item ">
                                        <a href="#" class="navbar__item-item-link">Single Product</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item">
                                        <a href="#" class="navbar__item-item-link">Cart</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item">
                                        <a href="#" class="navbar__item-item-link">Checkout</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="navbar__item">
                                <a href="#" class="navbar__item-link">ABOUT US</a>
                                <ul class="navbar__item-list">
                                    <li class="navbar__item-item navbar__item-item--new">
                                        <a href="#" class="navbar__item-item-link">About Us</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item ">
                                        <a href="#" class="navbar__item-item-link">About Us 2</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item">
                                        <a href="#" class="navbar__item-item-link">About Us 3</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="navbar__item">
                                <a href="#" class="navbar__item-link">PAGES</a>
                                <ul class="navbar__item-list">
                                    <li class="navbar__item-item ">
                                        <a href="#" class="navbar__item-item-link">Services</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item ">
                                        <a href="#" class="navbar__item-item-link">Agency Tour</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item ">
                                        <a href="#" class="navbar__item-item-link">Testimonials</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                            
                                        </div>
                                    </li>
                                    <li class="navbar__item-item">
                                        <a href="#" class="navbar__item-item-link">Prices</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item">
                                        <a href="#" class="navbar__item-item-link">Promotions</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item ">
                                        <a href="#" class="navbar__item-item-link">Faq</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item ">
                                        <a href="#" class="navbar__item-item-link">Coming Soon</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item navbar__item-item--row">
                                        <a href="#" class="navbar__item-item-link">About Us</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                            <ul class="navbar-list__additional">
                                                <li class="navbar-list__additional-item">
                                                    <a href="#" class="navbar-list__additional-item-link">About Us 1</a>
                                                </li>
                                                <li class="navbar-list__additional-item">
                                                    <a href="#" class="navbar-list__additional-item-link">About Us 2</a>
                                                </li>
                                                <li class="navbar-list__additional-item">
                                                    <a href="#" class="navbar-list__additional-item-link">About Us 3</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item navbar__item-item--row">
                                        <a href="#" class="navbar__item-item-link">Contact</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                            <ul class="navbar-list__additional">
                                                <li class="navbar-list__additional-item">
                                                    <a href="#" class="navbar-list__additional-item-link">Contact 1</a>
                                                </li>
                                                <li class="navbar-list__additional-item">
                                                    <a href="#" class="navbar-list__additional-item-link">Contact 2</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="navbar__item">
                                <a href="#" class="navbar__item-link">NEWS</a>
                                <ul class="navbar__item-list">
                                    <li class="navbar__item-item">
                                        <a href="#" class="navbar__item-item-link">Archive</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item navbar__item-item--row">
                                        <a href="#" class="navbar__item-item-link">Single Post</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                            <ul class="navbar-list__additional">
                                                <li class="navbar-list__additional-item">
                                                    <a href="#" class="navbar-list__additional-item-link">Full Width</a>
                                                </li>
                                                <li class="navbar-list__additional-item">
                                                    <a href="#" class="navbar-list__additional-item-link">Right Sidebar</a>
                                                </li>
                                                <li class="navbar-list__additional-item">
                                                    <a href="#" class="navbar-list__additional-item-link">Left Sidebar</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="navbar__item">
                                <a href="#" class="navbar__item-link">CONTACT</a>
                                <ul class="navbar__item-list">
                                    <li class="navbar__item-item ">
                                        <a href="#" class="navbar__item-item-link">Contact 1</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                    <li class="navbar__item-item navbar__item-item--hot">
                                        <a href="#" class="navbar__item-item-link">Contact 2</a>
                                        <div class="hot-active">
                                            <span class="hot-active__text">HOT</span>
                                        </div>
                                        <div class="new-active">
                                            <span class="new-active__text">NEW</span>
                                        </div>
                                        <div class="row-navbar">
                                            <i class="row-navbar__icon fas fa-angle-right"></i>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <a href="../entered/html/booknow.php" class="btn btn-purple hide-on-tablet-mobile">
                            <span>BOOK NOW</span>
                        </a>
                        
                        <div class="navbar-user">
                            
                            <?php
                                include '../user/config.php';
                                $user_id = $_SESSION['user_id'];
                                $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'");
                                if(mysqli_num_rows($select) > 0){
                                    $fetch = mysqli_fetch_assoc($select);
                                }
                            ?>

                            <form action="" method="post" enctype="multipart/form-data">
                                <?php
                                    if($fetch['image'] == ''){
                                        echo '<img class="navbar-user__img" src="../user/images/default-avatar.png">';
                                    }else{
                                        echo '<img class="navbar-user__img" src="../user/uploaded_img/'.$fetch['image'].'">';
                                    }                                   
                                ?>                          
                            </form>

                            <ul class="navbar-user__list">
                                <li class="navbar-user__item">
                                    <a href="../user/update_profile.php" class="navbar-user__item-link">My profile</a>
                                </li>
                                <li class="navbar-user__item navbar-user__item--red">
                                    <a href="../user/logout.php" class="navbar-user__item-link navbar-user__item-link--red">Log out</a>
                                </li>
                            </ul>
                        </div>
                        
    
                        <label for="option-checkbox" class="navbar__option">
                            <i class="ti-align-justify navbar__option-icon"></i>
                        </label>
    
                        <input type="checkbox" hidden class="navbar__option-checkbox" id="option-checkbox">
    
                        <div class="navbar__option-list">
                            <div class="navbar__option-list-content">
                                <div class="navbar__option-close-container">
                                    <label for="option-checkbox" class="navbar__option-close">
                                        <i class="ti-close navbar__option-close-icon"></i>
                                    </label>
                                </div>
                                <div class="navbar__option-text">
                                    <span class="navbar__option-text-sub">BEST</span>
                                    <div class="navbar__option-text-main">PACKAGES</div>
                                </div>
                                <div class="navbar__option-destination">
                                    <div class="navbar__option-destination-photo">
                                        <img src="../assets/img/package1.jpg" alt="" class="navbar__option-destination-img">
                                    </div>
                                    <div class="navbar__option-destination-detail">
                                        <span class="navbar__option-destination-nation">Berlin</span>
                                        <div class="navbar__option-destination-area">
                                            <i class="navbar__option-destination-area-icon ti-location-pin"></i>
                                            <span class="navbar__option-destination-area-text">Europe</span>
                                        </div>
                                        <div class="btn navbar__option-destination-btn">FROM 700$</div>
                                    </div>
                                </div>
                                <div class="navbar__option-destination">
                                    <div class="navbar__option-destination-photo">
                                        <img src="../assets/img/package2.jpg" alt="" class="navbar__option-destination-img">
                                    </div>
                                    <div class="navbar__option-destination-detail">
                                        <span class="navbar__option-destination-nation">Hong Kong</span>
                                        <div class="navbar__option-destination-area">
                                            <i class="navbar__option-destination-area-icon ti-location-pin"></i>
                                            <span class="navbar__option-destination-area-text">Asia</span>
                                        </div>
                                        <div style="background: linear-gradient(to right, #f76570 0%, #f78d65 100%);" class="btn navbar__option-destination-btn">FROM 500$</div>
                                    </div>
                                </div>
                                <div class="navbar__option-destination">
                                    <div class="navbar__option-destination-photo">
                                        <img src="../assets/img/package3.jpg" alt="" class="navbar__option-destination-img">
                                    </div>
                                    <div class="navbar__option-destination-detail">
                                        <span class="navbar__option-destination-nation">San Francisco</span>
                                        <div class="navbar__option-destination-area">
                                            <i class="navbar__option-destination-area-icon ti-location-pin"></i>
                                            <span class="navbar__option-destination-area-text">United States</span>
                                        </div>
                                        <div style="background: linear-gradient(to right, #ba71da 0%, #da717b 100%);" class="btn navbar__option-destination-btn">FROM 400$</div>
                                    </div>
                                </div>
    
                                <div class="navbar__option-destination-child">
                                    <div class="destination-child ">
                                        <div class="destination-container">
                                            <div style="background-image: url(../assets/img/destination-1.jpg);" class="destination-item__background">
                                                <div class="destination-item">
                                                    <div class="destination-item__text">
                                                        <div class="destination-item__name">Europe</div>
                                                        <div class="destination-item__package">3 PACKAGES</div>
                                                    </div>
                                                    <div class="destination-item__icon">
                                                        <img src="../assets/img/destination_icon1.png" alt="" class="destination-item__icon-img">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="destination-container__hover">
                                                <div  class="destination-item__hover">
                                                    <div class="destination-item__hover-heading">
                                                        <span>Packages</span>
                                                    </div>
                                                    <ul class="destination-item__hover-list">
                                                        <li class="destination-item__hover-item">
                                                            <a href="#" class="destination-item__hover-item-link">Berlin</a>
                                                        </li>
                                                        <li class="destination-item__hover-item">
                                                            <a href="#" class="destination-item__hover-item-link">Amsterdam</a>
                                                        </li>
                                                        <li class="destination-item__hover-item">
                                                            <a href="#" class="destination-item__hover-item-link">Tuscany</a>
                                                        </li>
                                                    </ul>
                                                    <div class="btn destination-item__hover-view">
                                                        <span class="destination-item__hover-view-text">VIEW DESTINATION</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="navbar__option-text">
                                    <span class="navbar__option-text-sub">LAST</span>
                                    <div class="navbar__option-text-main-bottom">MINUTES</div>
                                </div>
                                <div class="navbar__option-destination">
                                    <div class="navbar__option-destination-photo">
                                        <img src="../assets/img/package4.jpg" alt="" class="navbar__option-destination-img">
                                    </div>
                                    <div class="navbar__option-destination-detail">
                                        <span class="navbar__option-destination-nation">Tuscany</span>
                                        <div class="navbar__option-destination-area">
                                            <i class="navbar__option-destination-area-icon ti-location-pin"></i>
                                            <span class="navbar__option-destination-area-text">Italy</span>
                                        </div>
                                        <div style="background: linear-gradient(to right, #1bbc9b 0%, #1bbc63 100%);" class="btn navbar__option-destination-btn">FROM 730$</div>
                                    </div>
                                </div>
                                <div class="navbar__option-destination">
                                    <div class="navbar__option-destination-photo">
                                        <img src="../assets/img/package5.jpg" alt="" class="navbar__option-destination-img">
                                    </div>
                                    <div class="navbar__option-destination-detail">
                                        <span class="navbar__option-destination-nation">Amsterdam</span>
                                        <div class="navbar__option-destination-area">
                                            <i class="navbar__option-destination-area-icon ti-location-pin"></i>
                                            <span class="navbar__option-destination-area-text">Netherlands</span>
                                        </div>
                                        <div style="background: linear-gradient(to right, #f3a46b 0%, #f3c96b 100%);" class="btn navbar__option-destination-btn">FROM 1500$</div>
                                    </div>
                                </div>
                                <div class="navbar__option-destination">
                                    <div class="navbar__option-destination-photo">
                                        <img src="../assets/img/package6.jpg" alt="" class="navbar__option-destination-img">
                                    </div>
                                    <div class="navbar__option-destination-detail">
                                        <span class="navbar__option-destination-nation">Phuket</span>
                                        <div class="navbar__option-destination-area">
                                            <i class="navbar__option-destination-area-icon ti-location-pin"></i>
                                            <span class="navbar__option-destination-area-text">Thailandia</span>
                                        </div>
                                        <div style="background: linear-gradient(to right, #14b9d5 0%, #14d5b1 100%);" class="btn navbar__option-destination-btn">FROM 1200$</div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="grid wide ">
                <div class="header-destination-title">
                    <span class="header-destination-title-text">Cart</span>
                </div>
            </div>

            <span>hello</span>
        </header>

        
        <!-- body -->
        <div class="cart-content">
            <div class="grid wide">
                <div class="row">
                    <div class="cart-table">
                        <div class="">
                            <div class="">
                                <table>
                                    <tr>
                                        <th>Order</th>
                                        <th>Image</th>
                                        <th>Tour name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th style="text-align: right;">Total ($)</th>
                                    </tr>
                                    <?php showgiohang(); ?>
                                </table>
                            </div>
                            <div class="cart-btn__container">
                                <input class="cart-btn__item" type="submit" value="Accept the order" name="dongydathang">
                                <a href="cart.php?delcart=1"><input class="cart-btn__item" type="button" value="Clear all items"></a>
                                <a href="../entered/html/booknow.php"><input class="cart-btn__item" type="button" value="Continue ordering"></a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../js/script.js"></script>


</body>

</html>