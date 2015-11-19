<?php 

require_once("../scripts/config.php");

if (!isset($_SESSION["user"])) {
    header("location: ../login.php"); 
    exit();
}

if (isset($_SESSION["user"])) {
    // Test admin
    $sid = (int) $_SESSION['id'];
    
    $sql = mysql_query("SELECT * FROM users WHERE id = $sid"); // query the person
    // Make sure person exists in database
    $existCount = mysql_num_rows($sql); // Count the row nums
    if ($existCount == 1) { // Evaluate the count
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
// Check session value is in the database
$userID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]);
$user = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["user"]);
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]);
// Connect to the MySQL database
include "../storescripts/connect_to_mysql.php"; 
    $sql = mysql_query("SELECT id FROM users 
                        WHERE username='$user' AND password='$password' AND active=1
                        LIMIT 1");
// Make sure person exists in database
$existCount = mysql_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record in the database.";
   session_destroy();
   header("refresh:3;url=index.php");
   exit();
}
?>

<?php 
// Delete Item Question to Admin, and Delete movie if they choose
if (isset($_GET['deleteid'])) {
  header('location: ../errorPage.php?err=6&deleteid='.$_GET['deleteid'].'');
  exit();  
}
if (isset($_GET['yesdelete'])) {
	// remove item from system and delete its picture
	// delete from database
	$id_to_delete = (int) htmlentities($_GET['yesdelete']);
	$sql = mysql_query("DELETE FROM movies WHERE id='$id_to_delete' LIMIT 1") or die (mysql_error());
	// unlink the image from server
	// Remove The Pic
    $pictodelete = ("../inventory_images/$id_to_delete.jpg");
    if (file_exists($pictodelete)) {
       		    unlink($pictodelete);
    }
	header("location: inventory_list.php"); 
    exit();
}
?>

<?php 
// Parse the form data and add inventory item to the system
if (isset($_POST['movie_name'])) {
	
  $movie_name = htmlspecialchars(mysql_real_escape_string($_POST['movie_name']));
	$price = htmlspecialchars(mysql_real_escape_string($_POST['price']));
	$category = htmlspecialchars(mysql_real_escape_string($_POST['category']));
	$details = htmlspecialchars(mysql_real_escape_string($_POST['details']));
	// See if that movie name is an identical match to another movie in the system
	$sql = mysql_query("SELECT id FROM movies WHERE movie_name='$movie_name' LIMIT 1");
	$movieMatch = mysql_num_rows($sql); // count the output amount
  if ($movieMatch > 0) {
	  echo 'Sorry you tried to place a duplicate "movie Name" into the system, <a href="inventory_list.php">click here</a>';
	  exit();
	}
	// Add this movie into the database now
	$sql = mysql_query("INSERT INTO movies (movie_name, price, details, category, date_added) 
        VALUES('$movie_name','$price','$details','$category',now())") or die (mysql_error());
     $pid = mysql_insert_id();
	// Place image in the folder 
	$newname = "$pid.jpg";
    move_uploaded_file($_FILES['fileField']['tmp_name'], "../inventory_images/$newname");
	header("location: inventory_list.php"); 
    exit();
}
?>
<?php 
// This block grabs the whole list for viewing
$movie_list = "";
$sql = mysql_query("SELECT * FROM movies ORDER BY date_added DESC");
$movieCount = mysql_num_rows($sql); // count the output amount
if ($movieCount > 0) {
	while($row = mysql_fetch_array($sql)){ 
       $id = $row["id"];
			 $movie_name = $row["movie_name"];
			 $price = $row["price"];
			 $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
			 $movie_list .= "Movie ID: $id - <strong>$movie_name</strong> - $$price - <em>Added $date_added</em>&nbsp;&nbsp;&nbsp;<a href='inventory_edit.php?pid=$id'>edit</a> &bull; <a href='inventory_list.php?deleteid=$id'>delete</a><br/>";
    }
} else {
	$movie_list = "<p>You have no movies listed in your store yet</p>";
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
                <p>The administrators (short form: "admin") manage the technical details required for running the site. As such, they may promote (and demote) members to/from moderators, manage the rules, create sections and sub-sections, as well as perform any database operations (database backup etc.). Administrators often also act as moderators. Administrators may also make forum-wide announcements, or change the appearance (known as the skin) of a forum. There are also many forums where administrators share their knowledge.</p>
                 
                        <div align="right" style="margin-right:32px;"><a href="inventory_list.php#inventoryForm">+ Add New Inventory Item</a></div>
                        <div align="left" style="margin-left:24px;">
                          <h2>Inventory list</h2>
                          <?php echo $movie_list; ?>
                        </div>
                        <br>
                        <hr />
                        <a name="inventoryForm" id="inventoryForm"></a>
                        <h3>
                        &darr; Add New Inventory Item&darr;
                        </h3>

                        <form id="contacts-form" action="inventory_list.php" enctype="multipart/form-data" method="post" >
                          <fieldset>
                          <div class="field"><label>Movie Name:</label><input name="movie_name" type="text" id="movie_name" size="64" required/></div>
                          <div class="field"><label>Movie Price:</label><input name="price" type="text" id="price" size="12" required/></div>
                          <div class="field"><label>Category:</label><select name="category" id="category">
                                          <option value=""></option>
                                          <option value="Action">Action</option>
                                          <option value="Adventure">Adventure</option>
                                          <option value="Fiction">Fiction</option>
                                          <option value="Romance">Romance</option>
                                        </select></div>
                          <div class="field"><label>Movie Details:</label><textarea name="details" id="details" cols="64" rows="5"></textarea></div>
                          <div class="field"><label>Movie Image:</label><input type="file" name="fileField" id="fileField" required/></div>
                          <input type="submit" name="button" id="button" value="Add This Item Now"/>
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