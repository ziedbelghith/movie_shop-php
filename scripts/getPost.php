
<?php // Post's fetch
	function getPost($postName) {
		if(isset($_POST[$postName])) {
		   	return $postName = htmlentities(htmlspecialchars(mysql_real_escape_string($_POST[$postName])));
		}else{
			return $postName = '';
		}
	}
?>
