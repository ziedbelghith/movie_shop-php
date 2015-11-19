<?php

require_once("scripts/config.php");

$_SESSION = array();
session_destroy();

?>

<?php require_once("template/header.php"); ?>

<!-- CONTENT -->
<div id="content">
	<div class="line-hor"></div>
	<div class="box">
		<div class="border-right">
			<div class="border-left">
				<div class="inner">
					<h3><span>Logout</span></h3>
					 	<?php
							echo 'You are logged out..';
							header("refresh:2;url=".BASE_URL."/index.php");
							exit();
						?>
				</div>
			</div>
		</div>
	</div>
</div>



<?php require_once("template/footer.php"); ?>
