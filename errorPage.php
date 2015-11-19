
<?php // Include the routine config
  require_once "scripts/config.php";
?>

<?php 
// Check to see the URL variable is set and that it exists in the database
if (isset($_GET['err'])) {
	$err = preg_replace('#[^0-9]#i', '', $_GET['err']); 	
}else{
	$err = "Data to render this page is missing.";
}

if (isset($_GET['deleteid'])) {
	$delid = preg_replace('#[^0-9]#i', '', $_GET['deleteid']); 	
}else{
	$delid = -1;
}
?>


<?php require_once("template/header.php"); ?>

<!-- content -->
<div id="content">
	<div class="line-hor"></div>
	<div class="box">
		<div class="border-right">
			<div class="border-left">
				<div class="inner">
					<h3><span>Information</span></h3>
					 <?php 
					 	if ($err==0) {
					 		echo 'That information is incorrect,try again <a href="index.php">Click Here</a>'; 
					 	}elseif($err==1){
					 		echo 'Login and/or Password Incorrect !!<br/>Pleaze sign up now if you\' are not registred yet ...';
					 		header("refresh:2;url=login.php");
					 		exit();
					 	}elseif($err==2){
					 		echo 'Your are now the new admin !!<br/>You can now log in ...';
					 		header("refresh:2;url=login.php");
					 		exit();
					 	}elseif($err==3){
					 		echo "Setting Error !!";
					 	}elseif($err==4){
				           echo 'your are now registred !!<br/>you can now log in ...';
				           header("refresh:2;url=login.php");
				           exit();
					 	}elseif($err==5){
				           echo 'Username exist !!<br/>Try again ...';
					       header("refresh:2;url=signup.php");
					       exit();
					 	}elseif($err==6){
					 	   echo 'Do you really want to delete movie with ID of '.$delid.'? <a href="storeadmin/inventory_list.php?yesdelete=' . $delid . '">Yes</a> | <a href="storeadmin/inventory_list.php">No</a>';
					       exit();
					 	}elseif($err==7){
					 	   echo 'Password doesn\'t much !!';
					 	   header("refresh:2;url=signup.php");
					       exit();
					 	}else{
					 		echo $err;
					 	}
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once("template/footer.php"); ?>
