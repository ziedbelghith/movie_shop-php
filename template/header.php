<?php  
 
// Session test
$status = false;
if (isset($_SESSION['id'])) {
    $sid = (int) $_SESSION['id'];
    $sql = mysql_query("SELECT * FROM users WHERE id = $sid");
    // Make sure person exists in database
    $existCount = mysql_num_rows($sql); // Count the row nums
    if ($existCount == 1) { // Evaluate the count
       while($row = mysql_fetch_array($sql)){ 
             if ($_SESSION["id"] == $row['id'] &&
               $_SESSION["user"] == $row['username'] &&
               $_SESSION["password"] == $row['password'] &&
               $row['status'] == 'admin')
             {
              $status = true;
             }
     }
    }else{
    header("location: logout.php");
    exit();
  }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Home - Home Page | Cinema</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Place your description here" />
<meta name="keywords" content="put, your, keyword, here" />
<meta name="author" content="Templates.com - website templates provider" />
<link href="<?php echo BASE_URL; ?>/template/css/style.css" rel="stylesheet" type="text/css" />
<script src="<?php echo BASE_URL; ?>/template/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/template/js/cufon-yui.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/template/js/cufon-replace.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/template/js/Gill_Sans_400.font.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/template/js/script.js" type="text/javascript"></script>
</head>
<body id="page1">
<div class="tail-top">
  <div class="tail-bottom">
    <div id="main">
<!-- HEADER -->
      <div id="header">
        <div class="row-1">
          <div class="fleft"><a href="<?php echo BASE_URL; ?>/index.php">Movie <span>Shop</span></a>
            <div id="welcome">   
            <?php 
              if(isset($_SESSION['user'])) { 
                echo '<div id="welcome1">Welcome '.ucfirst($_SESSION['user']).'</div>';
                if($_SESSION["accessTime"]!='0000-00-00 00:00:00') { echo '<div id="welcome2">Last login: '.$_SESSION["accessTime"].'</div>'; }
              }else{}
            ?>
            </div>
          </div>
          <ul>
            <li><a href="<?php echo BASE_URL; ?>/index.php"><img src="<?php echo BASE_URL; ?>/template/images/icon1<?php if($file==='index.php') { echo '-act'; } ?>.gif" alt="" /></a></li>
            <li><a href="<?php echo BASE_URL; ?>/contact-us.php"><img src="<?php echo BASE_URL; ?>/template/images/icon2<?php if($file==='contact-us.php') { echo '-act'; } ?>.gif" alt="" /></a></li>
            <li><a href="<?php echo BASE_URL; ?>/sitemap.php"><img src="<?php echo BASE_URL; ?>/template/images/icon3<?php if($file==='sitemap.php') { echo '-act'; } ?>.gif" alt="" /></a></li>
          </ul>
        </div>
        <div class="row-2">
              <ul>

                  <li><a href="<?php echo BASE_URL; ?>/index.php" <?php if($file==='index.php') { echo 'class="active"'; } ?> >Home</a></li>
                  <li><a href="<?php echo BASE_URL; ?>/movies.php" <?php if($file==='movies.php') { echo 'class="active"'; } ?> >Movies</a></li>
                  <li><a href="<?php echo BASE_URL; ?>/cart.php" <?php if($file==='cart.php') { echo 'class="active"'; } ?>>Your Cart</a></li>
                  <?php if($status) { echo '<li><a href="'.BASE_URL.'/storeadmin/admin.php"';  if($file==='admin.php' || $file==='inventory_list.php' || $file==='inventory_edit.php') { echo 'class="active"'; } echo '>Admin</a></li>'; } ?>
                  <?php 
                  if (!isset($_SESSION["user"])) {
                     echo '<li><a href="'.BASE_URL.'/signup.php" '; 
                     if($file==='signup.php') {
                       echo 'class="active" '; 
                     } 
                     echo '>Sign Up</a></li>';
                  } 
                  ?>
                  <?php
                  if (!isset($_SESSION["user"])) {
                    echo '<li><a href="'.BASE_URL.'/login.php" ';
                    if($file==='login.php') {
                      echo 'class="active" ';
                    }
                    echo '>Log In</a></li>';
                  }?>
                  <?php 
                  if (isset($_SESSION["user"])) {
                    echo '<li><a href="'.BASE_URL.'/logout.php" ';
                    if($file==='logout.php') {
                      echo 'class="active" ';
                    }
                    echo '>Logout</a></li>';
                  }?>
                  <li class="last"><a href="<?php echo BASE_URL; ?>/about-us.php" <?php if($file==='about-us.php') { echo 'class="active"'; } ?> >About Us</a></li>

                </ul>
        </div>
      </div>
      