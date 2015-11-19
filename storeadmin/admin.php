<?php 


require_once("../scripts/config.php");

if (!isset($_SESSION["user"])) {
    header("location: ../login.php"); 
    exit();
}

if (isset($_SESSION["user"])) {
    // test admin
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
// check that user exist in the database
$userID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]);
$user = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["user"]);
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]);
// Run mySQL query to be sure that this person is an admin and that their password session var equals the database information
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

<?php require_once("../template/header.php"); ?>
<!-- CONTENT -->
      <div id="content">
        <div class="line-hor"></div>
        <div class="box">
          <div class="border-right">
            <div class="border-left">
              <div class="inner">
                <h3><span>Administrator Board</span></h3>
                <p>This position administers a variety of functions for the Board Office including document control/management, preparation of information for Board members, coordination of Board projects and Board election activities.</p>
                  <h2><a href="inventory_list.php">Manage Inventory</a></h2><br />
                <p>The administrators (short form: "admin") manage the technical details required for running the site. As such, they may promote (and demote) members to/from moderators, manage the rules, create sections and sub-sections, as well as perform any database operations (database backup etc.). Administrators often also act as moderators. Administrators may also make forum-wide announcements, or change the appearance (known as the skin) of a forum. There are also many forums where administrators share their knowledge.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

<?php require_once("../template/footer.php"); ?>
