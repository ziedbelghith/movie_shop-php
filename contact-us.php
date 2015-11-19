
<?php // Include the routine config
  require_once "scripts/config.php";
?>

<?php require_once("template/header.php"); ?>

<!-- content -->
			<div id="content">
				<div class="line-hor"></div>
				<div class="box">
					<div class="border-right">
						<div class="border-left">
							<div class="inner">
								<h3><span>Contact</span></h3>
								<div class="address">
									<div class="fleft"><span>Zip Code :</span>6011<br />
										<span>Country :</span>TUNISIA<br />
										<span>Telephone :</span>+216 23 736 912<br />
										<span>E-mail :</span>movies-shop@frog.com</div>
									<div class="extra-wrap"><span>Site info:</span><br />
										We appriciate your visit : this site is your window to cinema at your home .
										<br/>Our competance : hight quality movies , most recently filmed. <br/> Different categories of movies ACTION ROMANCE ...    
										</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="content">
					<form id="contacts-form" action="contact-us">
						<fieldset style="
			              -moz-box-shadow: inset 0px 0px 5px 4px #656565;
			              -webkit-box-shadow: inset 0px 0px 5px 4px #656565;
			              -o-box-shadow: inset 0px 0px 5px 4px #656565;
			              box-shadow: inset 0px 0px 5px 4px #656565;
			              filter:progid:DXImageTransform.Microsoft.Shadow(color=#656565, Direction=NaN, Strength=5);
			              -moz-border-radius: 10px;
			              -webkit-border-radius: 10px;
			              border-radius: 10px;
			              padding: 3% 0% 3% 5%;
			            ">
						<h3>Contact <span>Us</span></h3>
						<div class="field"><label>Name :</label><input type="text" value=""/></div>
						<div class="field"><label>E-mail :</label><input type="text" value=""/></div>
						<br><br>
						<div class="field"><label>Message :</label><textarea cols="1" rows="1"></textarea></div>
						<div class="wrapper">
							<a href="#" class="link2" onclick="document.getElementById('contacts-form').submit()">	
								<span>
									<span>Send Message</span>
								</span>
							</a>
						</div>
						</fieldset>
					</form>
				</div>
			</div>

<?php require_once("template/footer.php"); ?>
