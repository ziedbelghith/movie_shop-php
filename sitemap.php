

<?php // Include the config routine
  require_once "scripts/config.php";
?>

<?php  // Administrator verification
	$status = false;
	if (isset($_SESSION['id'])) {
	    $sid = (int) $_SESSION['id'];
	    $sql = mysql_query("SELECT * FROM users WHERE id = $sid"); // query the person
	    // Make sure person exists in database
	    $existCount = mysql_num_rows($sql); // Count the row nums
	    if ($existCount == 1) { // Evaluate the count
	        while($row = mysql_fetch_array($sql)){ 
	            if ($_SESSION["id"] == $row['id'] &&
	                $_SESSION["user"] == $row['username'] &&
	                $_SESSION["password"] == $row['password'] &&
	                $row['status'] == 'admin') {
	     	       
	     	        $status = true;
	            }
	    	}
	    }else{
	 	   header("location: logout.php");
	    	exit();
	  }
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
								<h3>Site <span>Map</span></h3>
								<p>Movie Shop is a site that offer you a chance to get newly filmed movies with a hight quality pictures and with a special price to our site users .</p>	
								<br/> Movie shop follows this architecture :							 
								 <ul class="sitemap-list">
									<li><a href="index.php">Home</a></li>
									<li><a href="movies.php">Movies</a>
									<li><a href="cart.php">Your Cart</a></li>
									<?php // Dynamic sitemap
										if($status == true) {
											echo 
											'<li><a href="storeadmin/admin.php">Admin</a></li>
												<ul style="margin-left:2%;">
													<li><a href="storeadmin/inventory_list.php">Manage Inventory</a></li>
												</ul>
											</li>';
										}elseif(!isset($_SESSION['user'])){
											echo
											'<li><a href="signup.php">Sign Up</a></li>
											<li><a href="login.php">Log In</a></li>';
										}								
									?>
									<li><a href="about-us.php">About Us</a></li>
									<li><a href="contact-us.php">Contact Us</a></li>
									<li><a href="sitemap.php">Site Map</a></li>
								 </ul>
								 <p>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequatuis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
							</div>
						</div>
					</div>
				</div>
			</div>

<?php require_once("template/footer.php"); ?>
