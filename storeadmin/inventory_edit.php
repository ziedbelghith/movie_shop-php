<?php 

require_once("../scripts/config.php");

if (!isset($_SESSION["user"])) {
    header("location: ../login.php"); 
    exit();
}
// Admin Test
if (isset($_SESSION["user"])) {
    $sid = (int) $_SESSION['id'];
    $sql = mysql_query("SELECT * FROM users WHERE id = $sid"); // query the person
    // ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
    $existCount = mysql_num_rows($sql); // count the row nums
    if ($existCount == 1) { // evaluate the count
       while($row = mysql_fetch_array($sql)){ 
             if ($_SESSION["id"] == $row['id'] &&
               $_SESSION["user"] == $row['username'] &&
               $_SESSION["password"] == $row['password'] &&
               $row['status'] != 'admin')
             {
                header("location: ../login.php"); 
                exit();
             }
        }
    }
}

// Be sure to check that this user SESSION value is in fact in the database
$userID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); // filter everything but numbers and letters
$user = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["user"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
// Run mySQL query to be sure that this person is an admin and that their password session var equals the database information
// Connect to the MySQL database
include "../storescripts/connect_to_mysql.php"; 
    $sql = mysql_query("SELECT id FROM users 
                        WHERE username='$user' AND password='$password' AND active=1
                        LIMIT 1"); // query the person
// ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
$existCount = mysql_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record in the database.";
   session_destroy();
   header("refresh:3;url=index.php");
   exit();
}
?>

<?php 
// Parse the form data and add inventory item to the system
if (isset($_POST['movie_name'])) {
	
	$pid = (int) mysql_real_escape_string($_POST['thisID']);
  $movie_name = htmlspecialchars(mysql_real_escape_string($_POST['movie_name']));
	$price = htmlspecialchars(mysql_real_escape_string($_POST['price']));
	$category = htmlspecialchars(mysql_real_escape_string($_POST['category']));
	$details = htmlspecialchars(mysql_real_escape_string($_POST['details']));
	// See if that movie name is an identical match to another movie in the system
	$sql = mysql_query("UPDATE movies SET movie_name='$movie_name', price='$price', details='$details', category='$category' WHERE id='$pid'");
	if ($_FILES['fileField']['tmp_name'] != "") {
	    // Place image in the folder 
	    $newname = "$pid.jpg";
	       move_uploaded_file($_FILES['fileField']['tmp_name'], "../inventory_images/$newname");
	}
	header("location: inventory_list.php"); 
    exit();
}
?>

<?php 
// Gather this movie's full information for inserting automatically into the edit form below on page
if (isset($_GET['pid'])) {
	$targetID = $_GET['pid'];
    $sql = mysql_query("SELECT * FROM movies WHERE id='$targetID' LIMIT 1");
    $movieCount = mysql_num_rows($sql); // count the output amount
    if ($movieCount > 0) {
	    while($row = mysql_fetch_array($sql)){ 
             
			 $movie_name = $row["movie_name"];
			 $price = $row["price"];
			 $category = $row["category"];
			 $details = $row["details"];
			 $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
        }
    } else {
	    echo "Sorry dude that crap dont exist.";
		exit();
    }
}
?>

<?php require_once("../template/header.php"); ?>
<!-- CONTENT -->
      <div id="content">
        <div class="line-hor"></div>
        <div class="box">
          <div class="border-right">
            <div class="border-left">
              <div class="inner">
                <h3><span>Manage Inventary</span></h3>
                <p>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.</p>
                 
                        <div align="right" style="margin-right:32px;"><a href="inventory_list.php#inventoryForm">+ Add New Inventory Item</a></div>
                        
                        <br>
                        <hr />
                        <a name="inventoryForm" id="inventoryForm"></a>
                        <h3>
                        &darr; Add New Inventory Item&darr;
                        </h3>

                        <form id="contacts-form" action="inventory_edit.php" enctype="multipart/form-data" method="post" >
                          <fieldset>
                            <div class="field"><label>Movie Name:</label><input name="movie_name" type="text" id="movie_name" size="64" value="<?php echo $movie_name; ?>" required/></div>
                            <div class="field"><label>Movie Price:</label><input name="price" type="text" id="price" size="12" value="<?php echo $price; ?>" required/></div>
                            <div class="field"><label>Category:</label><select name="category" id="category">
                                            <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                            <option value="Action">Action</option>
                                            <option value="Adventure">Adventure</option>
                                            <option value="Fiction">Fiction</option>
                                            <option value="Romance">Romance</option>
                                          </select></div>
                            <div class="field"><label>Movie Details:</label><textarea name="details" id="details" cols="64" rows="5"><?php echo $details; ?></textarea></div>
                            <div class="field"><label>Movie Image:</label><input type="file" name="fileField" id="fileField" required/></div>
                            <div class="field">
                            <input name="thisID" type="hidden" value="<?php echo $targetID; ?>" />
                            <input type="submit" name="button" id="button" value="Make Changes" />
                          </fieldset>
                        </form>
                      </div>
                 <p></p>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php require_once("../template/footer.php"); ?>
