<?php

require_once("scripts/config.php");

if (isset($_SESSION["user"])) {
    header("location: index.php"); 
    exit();
}

?>

<?php
// Catch the post variables
if (isset($_POST["username"]) && isset($_POST["password"])) {
  if (empty($_POST["username"]) || empty($_POST["password"])) {
    // error 0
    header("location: errorPage.php?err=0");
    exit();
  }
    $user = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]);
    $password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]);
    $password = sha1('{/[*'.$password.'{/[*');
    
    // Fetch if the db is empty
    $sql = mysql_query("SELECT * FROM users");
    $existCount = mysql_num_rows($sql); // Count the row nums
    if ($existCount < 1) { // Evaluate the count
       header("location: errorPage.php?err=1");
       exit();
    }
    $sql = mysql_query("SELECT id,last_log_date FROM users 
                        WHERE username='$user' AND password='$password' AND active=1
                        LIMIT 1");
    // Make sure person exists in database
    $existCount = mysql_num_rows($sql); // Count the row nums
    if ($existCount == 1) { // Evaluate the count
	     while($row = mysql_fetch_array($sql)){ 
             $id = $row["id"];
             $lastTime = $row['last_log_date'];
		   }
		 $_SESSION["id"] = $id;
		 $_SESSION["user"] = $user;
		 $_SESSION["password"] = $password;
     $_SESSION["accessTime"] = $lastTime;
     $sql = mysql_query("UPDATE users SET last_log_date=now() WHERE id='$id'");
		 header("location: index.php");
     exit();
    }else{
      header("location: errorPage.php?err=1");
		  exit();
	}
}
?>

<?php require_once("template/header.php"); ?>


<!-- CONTENT -->
      <div id="content">
        <div class="line-hor"></div>
        <div class="box">
          <div class="border-right">
            <div class="border-left">
              <div class="inner">
                <h3><span>Login</span></h3>
                <div class="extra-wrap">
                 welcome, we appreciate your registration on our website . It's an honnor to us to have a sush users with sush generosity .
                  our team will be gratefull to have your notes about anything in this website . Please contact us so we can work to satisfy your needs , together we can make this site a better place to share .<br />THANK YOU ...   
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="content">
          <form id="contacts-form" method="post" action="">
            <fieldset style="
              -moz-box-shadow: inset 0px 0px 5px 4px #656565;
              -webkit-box-shadow: inset 0px 0px 5px 4px #656565;
              -o-box-shadow: inset 0px 0px 5px 4px #656565;
              box-shadow: inset 0px 0px 5px 4px #656565;
              filter:progid:DXImageTransform.Microsoft.Shadow(color=#656565, Direction=NaN, Strength=5);
              -moz-border-radius: 10px;
              -webkit-border-radius: 10px;
              border-radius: 10px;
              padding: 3% 48% 3% 3%;
            ">
              <h3><span>Login</span></h3>
              <div class="field"><label for="username">Login:</label><input type="text" name="username" id="username" value="" required/></div>
              <div class="field"><label for="password">Password:</label><input type="password" name="password" id="password" value="" required/></div>
              <div class="wrapper">
                  <input type="submit" name="button" id="button" value="Login" />
              </div>
            </fieldset>
          </form>
        </div>
      </div>


<?php require_once("template/footer.php"); ?>
