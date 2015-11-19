<?php 

require_once "scripts/config.php";

// Test if the user is connected or not
if (!isset($_SESSION["user"])) {
    header("location: login.php"); 
    exit();
}
?>

<?php // If user try to add something to the cart from the movie page
if (isset($_POST['pid'])) {
    $pid = htmlspecialchars($_POST['pid']);
	$wasFound = false;
	$i = 0;
	// If the cart session variable is not set or cart array is empty
	if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
	    // Run if the cart is empty or not
		$_SESSION["cart_array"] = array(0 => array("item_id" => $pid, "quantity" => 1));
	} else {
		// Run if the cart has at least one item
		foreach ($_SESSION["cart_array"] as $each_item) {
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == "item_id" && $value == $pid) {
					  // That item is in cart already so let's adjust its quantity using array_splice()
					  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $pid, "quantity" => $each_item['quantity'] + 1)));
					  $wasFound = true;
				  }
		      }
	       }
		   if ($wasFound == false) {
			   array_push($_SESSION["cart_array"], array("item_id" => $pid, "quantity" => 1));
		   }
	}
	header("location: cart.php"); 
    exit();
}
?>
<?php // If user choose to empty their shopping cart
if (isset($_GET['cmd']) && $_GET['cmd'] == "emptycart") {
    unset($_SESSION["cart_array"]);
}
?>
<?php // If user chooses to adjust item quantity
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
    
	$item_to_adjust = htmlspecialchars($_POST['item_to_adjust']);
	$quantity = htmlspecialchars($_POST['quantity']);
	$quantity = preg_replace('#[^0-9]#i', '', $quantity);
	if ($quantity >= 100) { $quantity = 99; }
	if ($quantity < 1) { $quantity = 1; }
	if ($quantity == "") { $quantity = 1; }
	$i = 0;
	foreach ($_SESSION["cart_array"] as $each_item) { 
		      $i++;
		      while (list($key, $value) = each($each_item)) {
				  if ($key == "item_id" && $value == $item_to_adjust) {
					  // That item is in cart already so let's adjust its quantity using array_splice()
					  array_splice($_SESSION["cart_array"], $i-1, 1, array(array("item_id" => $item_to_adjust, "quantity" => $quantity)));
				  }
		      }
	}
}
?>
<?php // If user wants to remove an item from cart
if (isset($_POST['index_to_remove']) && $_POST['index_to_remove'] != "") {
    // Access the array and run code to remove array index
 	$key_to_remove = htmlspecialchars($_POST['index_to_remove']);
	if (count($_SESSION["cart_array"]) <= 1) {
		unset($_SESSION["cart_array"]);
	} else {
		unset($_SESSION["cart_array"]["$key_to_remove"]);
		sort($_SESSION["cart_array"]);
	}
}
?>
<?php // Render the cart for the user to view on the page
$cartOutput = "";
$cartTotal = "";
$pp_checkout_btn = '';
$movie_id_array = '';
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
    $cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
} else {
	// Start PayPal Checkout Button
	$pp_checkout_btn .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="zied_bel@hotmail.fr">';
	// Start the For Each loop
	$i = 0; 
    foreach ($_SESSION["cart_array"] as $each_item) { 
		$item_id = $each_item['item_id'];
		$sql = mysql_query("SELECT * FROM movies WHERE id='$item_id' LIMIT 1");
		while ($row = mysql_fetch_array($sql)) {
			$movie_name = $row["movie_name"];
			$price = $row["price"];
			$details = $row["details"];
		}
		$pricetotal = $price * $each_item['quantity'];
		$cartTotal = $pricetotal + $cartTotal;
		setlocale(LC_MONETARY, "en_US");
        $pricetotal = money_format("%10.2n", $pricetotal);
		// Dynamic Checkout Btn Assembly
		$x = $i + 1;
		$pp_checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $movie_name . '">
        <input type="hidden" name="amount_' . $x . '" value="' . $price . '">
        <input type="hidden" name="quantity_' . $x . '" value="' . $each_item['quantity'] . '">  ';
		// Create the movie array variable
		$movie_id_array .= "$item_id-".$each_item['quantity'].","; 
		// Dynamic table row assembly
		$cartOutput .= "<tr>";
		$cartOutput .= '<td style="padding-left:5%;"><img src="inventory_images/' . $item_id . '.jpg" alt="' . $movie_name. '" width="40" height="52" border="1" /><br><a href="movie.php?id='. $item_id .'">'. ucfirst($movie_name) .'</a></td>';
		$cartOutput .= '<td>'. $details .'</td>';
		$cartOutput .= '<td style="padding-left:3%;">$'. $price .'</td>';
		$cartOutput .= '<td><form action="cart.php" method="post">
		<input name="quantity" type="text" value="'. $each_item['quantity'] .'" size="1" maxlength="2" style="margin-left:20%;"/>
		<input name="adjustBtn'. $item_id .'" type="submit" value="change" style="margin:10% 0% 0% 10%;"/>
		<input name="item_to_adjust" type="hidden" value="'. $item_id .'" />
		</form></td>';
		//$cartOutput .= '<td>' . $each_item['quantity'] . '</td>';
		$cartOutput .= '<td style="padding-left:1.5%;">'. $pricetotal .'</td>';
		$cartOutput .= '<td><form action="cart.php" method="post"><input name="deleteBtn' . $item_id . '" type="submit" value="X" style="margin-left:30%;"/><input name="index_to_remove" type="hidden" value="' . $i . '" /></form></td>';
		$cartOutput .= '</tr>';
		$i++; 
    } 
	setlocale(LC_MONETARY, "en_US");
    $cartTotal = money_format("%10.2n", $cartTotal);
	$cartTotal = "<div style='font-size:18px; margin-top:12px;' align='right'>Cart Total : ".$cartTotal." USD</div>";
    // Finish the Paypal Checkout Btn
	$pp_checkout_btn .= '<input type="hidden" name="custom" value="' . $movie_id_array . '">
	<input type="hidden" name="notify_url" value="'.BASE_URL.'/storescripts/my_ipn.php">
	<input type="hidden" name="return" value="'.BASE_URL.'/checkout_complete.php">
	<input type="hidden" name="rm" value="2">
	<input type="hidden" name="cbt" value="Return to The Store">
	<input type="hidden" name="cancel_return" value="'.BASE_URL.'/paypal_cancel.php">
	<input type="hidden" name="lc" value="US">
	<input type="hidden" name="currency_code" value="USD">
	<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - its fast, free and secure!">
	</form>';
}
?>

<?php require_once("template/header.php"); ?>


<div id="content">
	<div class="line-hor"></div>
	<div class="box">
		<div class="border-right">
			<div class="border-left">
				<div class="inner">
					<h3>My<span> Panel</span></h3>
					<p>
					</p>
					 
				    <table width="100%" border="1" cellspacing="0" cellpadding="6">
				      <tr>
				        <td width="18%" style="color:#d72a18; text-align:center;"><strong>Movie</strong></td>
				        <td width="45%" style="color:#d72a18; text-align:center;"><strong>Movie Description</strong></td>
				        <td width="10%" style="color:#d72a18; text-align:center;"><strong>Unit Price</strong></td>
				        <td width="9%" style="color:#d72a18; text-align:center;"><strong>Quantity</strong></td>
				        <td width="9%" style="color:#d72a18; text-align:center;"><strong>Total</strong></td>
				        <td width="9%" style="color:#d72a18; text-align:center;"><strong>Remove</strong></td>
				      </tr>
				     <?php echo $cartOutput; ?>
				     <tr>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
				        <td>&nbsp;</td>
				      </tr>
				    </table>
				    <?php echo $cartTotal; ?>
				    <?php echo $pp_checkout_btn; ?>
				    <br>
					<a href="cart.php?cmd=emptycart">Click Here to Empty Your Shopping Cart</a>
					
					<br><br>	
					
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once("template/footer.php"); ?>
