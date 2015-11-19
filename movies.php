<?php 
  require_once("scripts/config.php");
?>

<?php // Get Category's Post if exist ($category)
  require_once "scripts/getPost.php";
  $category = getPost('category');
  $searchText = getPost('searchText');
?>

<?php // Fetch Category from the database ($cat)
  $cat = '<option></option>';
  $sql = mysql_query("SELECT id,category FROM movies GROUP BY category");
  $categoryCount = mysql_num_rows($sql);
  if ($categoryCount > 0) {
    while ($row = mysql_fetch_array($sql)) {
      $cat .= '<option value='.$row["category"].'>'.$row["category"].'</option>';
    }}
?>

<?php // Catch the GET variable if exist 'pg'
  if (isset($_GET['pg'])) {
    $pg = preg_replace('#[^0-9]#i', '', $_GET["pg"]);
    $pg = ($pg - 1) * 6;
  }else{
    $pg = 0;
  }
?>

<?php // Make some calculation for pagination
  $sql = mysql_query("SELECT * FROM movies");
  $count = mysql_num_rows($sql);
  $var = $count / 6;
  if (($count % 6) != 0) {
    $var++;
  }
  if ($var<=1) {
    $var = -1;
  }
?>

<?php // Run a select query to get the latest 6 items with category filter ($dynamicList)
  $dynamicList = '';

  if(empty($category)) {
    if (empty($searchText)) {
      $sql = mysql_query("SELECT * FROM movies ORDER BY date_added DESC LIMIT $pg, 6");
    }else{
      $sql = mysql_query("SELECT * FROM movies WHERE movie_name LIKE '%$searchText%' ORDER BY date_added DESC LIMIT 6");
    }
  }else{
    if (empty($searchText)) {
      $sql = mysql_query("SELECT * FROM movies WHERE category = '$category' ORDER BY date_added DESC LIMIT 6");
    }else{
      $sql = mysql_query("SELECT * FROM movies WHERE category = '$category' AND movie_name LIKE '%$searchText%' ORDER BY date_added DESC LIMIT 6");
    }
  }
  // Count the output amount
  $movieCount = mysql_num_rows($sql);
  if ($movieCount > 0) {
    while($row = mysql_fetch_array($sql)) {
      $id = $row["id"];
      $movie_name = $row["movie_name"];
      $price = $row["price"];
      $details = $row["details"];
      $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
      
      $dynamicList .= '<li>
                        <h4>'.ucfirst($movie_name).'</h4>
                        <img src="inventory_images/' . $id . '.jpg" height="190px" weight="286px" alt="" />
                        <p style="
                          height:100px;
                          overflow:hidden;
                          text-align:center;
                          word-wrap:break-word;
                          text-align:justify;">&nbsp;'. $details .'<br></p>
                        <p><br>
                          <a href="movie.php?id=' . $id . '" class="link2"><span><span>Read More</span></span></a>
                        </p>
                        <div class="wrapper"></div>
                      </li>';
    }
  }else{
    $dynamicList = "<li><p>We have no movies listed in our store yet</p></li>";
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
					<h3>Our <span>Movies</span></h3>
            <form action="movies.php" method="post" style="float:right; margin-bottom:10px;">
              <label for="category">Search: &nbsp;</label>
              <input type="text" name="searchText" id="searchText" value="" />
              <label for="category">&nbsp;Category: &nbsp;</label>
              <select size="1" name="category" onmouseout="">
                <?php echo $cat; ?>
              </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="submit" name="button" id="button" value="search"/>
            </form>
				</div>
			</div>
		</div>
	</div>
	<div class="content">
		<h3><span><?php if(!empty($category)) { echo $category; }else{ echo 'All'; } ?></span> Movies</h3>
		<ul class="list">
			<?php echo $dynamicList; ?>
		</ul>
	</div>
  <div>
  <p style="margin-left:88%;">
    <?php
      if (($var!=-1) && empty($category) && empty($searchText)) {
        for ($i=1; $i < $var; $i++) {
          echo '<a href="movies.php?pg='.$i.'"><button>'.$i.'</button></a>&nbsp;&nbsp;';
        }
      }
    ?>
  </p>
  </div>
</div>

<?php require_once("template/footer.php"); ?>
