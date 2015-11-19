<?php 

require_once("scripts/config.php");

?>
<?php 
// Check to see the GET is set and that it exists in the database
if (isset($_GET['id'])) {
	// Connect to the MySQL database  
    include "storescripts/connect_to_mysql.php"; 
	$id = preg_replace('#[^0-9]#i', '', $_GET['id']); 
	// Use this var to check to see if this ID exists, if yes then get the movie 
	// details, if no then exit this script and give message why
	$sql = mysql_query("SELECT * FROM movies WHERE id='$id' LIMIT 1");
	$movieCount = mysql_num_rows($sql); // Count the output amount
    if ($movieCount > 0) {
		// Get all the movie details
		while($row = mysql_fetch_array($sql)){ 
			 $movie_name = $row["movie_name"];
			 $price = $row["price"];
			 $details = $row["details"];
			 $category = $row["category"];
			 $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
         }
		 
	} else {
		echo "That item does not exist.";
	    exit();
	}
		
} else {
	echo "Data to render this page is missing.";
	exit();
}
?>

<?php require_once("template/header.php"); ?>

			<div id="content">
				<div class="line-hor"></div>
				<div class="box">
					<div class="border-right">
						<div class="border-left">
							<div class="inner">
								<h3><span><?php echo ucfirst($movie_name); ?></span></h3>
								
								<ul class="list">
								<li>
									<img src="inventory_images/<?php echo $id; ?>.jpg" width="142" height="188" alt="<?php echo $movie_name; ?>" />
									<div>
										<?php echo 'Title: &nbsp;'.ucfirst($movie_name); ?><br>
										<?php echo 'Cost: &nbsp;$'.$price; ?><br>
										<?php echo 'Category: &nbsp;'.$category; ?><br><hr><br>
								 		<?php echo '&nbsp;'.$details; ?>
									</div>								
								</li>

								<ul class="sitemap-list">
									<a style="margin-left:1%;" href="inventory_images/<?php echo $id; ?>.jpg">View Full Size Image</a>
								</ul>
    							<form id="form1" name="form1" method="post" action="cart.php">
								    <input type="hidden" name="pid" id="pid" value="<?php echo $id; ?>" />
								    <input type="submit" name="button" id="button" value="Add to Shopping Cart" style="float:right;" />
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>


<?php require_once("template/footer.php"); ?>