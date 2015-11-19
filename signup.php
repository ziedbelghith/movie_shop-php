
<?php 
  require_once("scripts/config.php");
  if (isset($_SESSION["user"])) {
    header("location: index.php"); 
    exit();
}
?>

<?php // Catch the post variables and work with
  if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["password1"]) && isset($_POST["email"])) {
    if ($_POST["password1"] == $_POST["password"]) {
      if (empty($_POST["username"]) || empty($_POST["password"])) {
        echo "One or both of the fields are empty !!";
        header("refresh:2;url=index.php");
        exit();
      }
      $email = htmlentities($_POST["email"]);
      $user = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]); // Filter with regex
      $password = preg_replace('+#[^A-Za-z0-9]#i', '', $_POST["password"]); // Filter with regex
      $password = sha1('{/[*'.$password.'{/[*');
      // Fetch if the db is empty
      $sql = mysql_query("SELECT * FROM users");
      $existCount = mysql_num_rows($sql); // Count the row nums
      if ($existCount < 1) { // Evaluate the count
         $sql = mysql_query("INSERT INTO users (username,password,email,status,active,last_log_date,sign_in_date) 
                            VALUES ('$user','$password','$email','admin',1,'0000-00-00 00:00:00',now())") or die (mysql_error());
         header("location: errorPage.php?err=2");
         exit();
      }else{
         // Test if a username exist in the db
         $sql = mysql_query("SELECT id FROM users 
                             WHERE username='$user'
                             LIMIT 1");
         // Make sure person doesn't exists in database
          $existCount = mysql_num_rows($sql); // Count the row nums
          if ($existCount != 1) { // Evaluate the count
             // Insert a new user
             $sql = mysql_query("INSERT INTO users (username,password,email,status,active,last_log_date,sign_in_date) 
                                VALUES ('$user','$password','$email','user',1,'0000-00-00',now())") or die (mysql_error());
             header("location: errorPage.php?err=4");
             exit();
          }else{
             header("location: errorPage.php?err=5");
             exit();
          } 
      }
    }else{
      header("location: errorPage.php?err=7");
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
                <h3>Sign Up <span>Now</span></h3>
                <div class="extra-wrap">
                   Welcome , we appreciate your registration on our website . It's an honnor to us to have a sush users with sush generosity .
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
              <h3><span>Sign-up</span></h3>
              <div class="field"><label for="username">Name:</label><input type="text" name="username" id="username" value="" required/></div>
              <div class="field"><label for="password">Password:</label><input type="password" name="password" id="password" value="" required/></div>
              <div class="field"><label for="password1">Re-Password:</label><input type="password" name="password1" id="password1" value="" required/></div>
              <div class="field"><label for="email">E-Mail:</label><input type="email" name="email" id="email" value="" required/></div>
              <div class="wrapper">
                  <input type="submit" name="button" id="button" value="Sign Up" />
              </div>
            </fieldset>
          </form>
        </div>
      </div>


<?php require_once("template/footer.php"); ?>
