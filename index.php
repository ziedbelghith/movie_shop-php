
<?php // Include the routine config
  require_once "scripts/config.php";
?>

<?php // Run a select query to get the latest 3 movies ($latestThreeMovies)
  $latestThreeMovies = '';
  $sql = mysql_query("SELECT * FROM movies ORDER BY date_added DESC LIMIT 3");
  // Count the output amount
  if(($movieCount = mysql_num_rows($sql))<0){
    header("location: errorPage.php?err=3");
    exit();
  }
  if ($movieCount > 0) {
    for ($i=0; $i < 3; $i++) {
      if ($row = mysql_fetch_array($sql)) {
        $id = $row["id"];
        $movie_name = $row["movie_name"];
        $price = $row["price"];
        $details = $row["details"];
        $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
      
        if ($i===2) {
          $latestThreeMovies .= '<li class="last">
                            <h4>'.ucfirst($movie_name).'</h4>
                            <img src="inventory_images/' . $id . '.jpg" height="190px" weight="286px" alt="" />
                            <p style="overflow:hidden;word-wrap:break-word;text-align:left;">'. $details .'</p>
                            <div class="wrapper"><a href="movie.php?id=' . $id . '" class="link2"><span><span>Read More</span></span></a></div>
                          </li>';
        }else{
          $latestThreeMovies .= '<li>
                            <h4>'.ucfirst($movie_name).'</h4>
                            <img src="inventory_images/' . $id . '.jpg" height="190px" weight="286px" alt="" />
                            <p style="overflow:hidden;word-wrap:break-word;text-align:left;">'. $details .'</p>
                            <div class="wrapper"><a href="movie.php?id=' . $id . '" class="link2"><span><span>Read More</span></span></a></div>
                          </li>';
        }
      }
    }
  }else{
    $latestThreeMovies .= '<p>We have no movies listed in our store yet</p>';
  }
?>

<?php require_once("template/header.php"); ?>
<!-- CONTENT -->
      <div id="content">
        <div id="slogan">
          <div class="image png"></div>
          <div class="inside">
            <h2>We are breaking<span>All Limitations</span></h2>
            <p> Welcome , we appreciate your visit . <br/> If you have a problem with something on this site please contact us our team is there for you 24/7 .

            </p>
            <div class="wrapper"><a href="about-us.php" class="link1"><span><span>Learn More</span></span></a></div>
          </div>
        </div>
        <div class="box">
          <div class="border-right">
            <div class="border-left">
              <div class="inner">
                <h3>Welcome to <b>Movie</b> <span>Shop</span></h3>
                <p>Movie Shop is a site that offer you a chance to get newly filmed movies with a hight quality pictures and with a special price to our site users please Log in if you want to buy a movie , you can contact us by clicking on the menue .</p>
                <div class="img-box1"><img src="<?php echo BASE_URL; ?>/template/images/1page-img1.jpg" alt="" />
                  If you want to learn more about the site architecture you can click on the sitemap .  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="content">
          <h3>Fresh <span>Movies</span></h3>
            <ul class="movies">
              
              <?php echo $latestThreeMovies; ?><br>
            <li class="clear">&nbsp;</li>
          </ul>
        </div>
      </div>

<?php require_once("template/footer.php"); ?>
