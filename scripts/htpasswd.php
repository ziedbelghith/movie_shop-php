<?php
	// Get the encryption password to put it to .htpasswd

	if (isset($_POST['login']) && isset($_POST['pass'])) {
		$login = $_POST['login'];
		$pass_crypte = crypt($_POST['pass']); // On crypte le mot de passe
		
		echo '<p>Ligne a copier dans le .htpasswd :<br />' . $login .':' . $pass_crypte . '</p>';
	}else{
	?>

		<p>Entrez votre login et votre mot de passe pour le crypter.</p>
		<form method="post">
			<p>
				<label for="login">Login : </label><br><input type="text" name="login"><br />
				<label for="pass">Mot de passe : </label><br><input type="text" name="pass"><br /><br />
			</p>
			<input type="submit" value="Crypter !">
		</form>
	<?php
	}
?>
