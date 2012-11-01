<html>

<?php

	global $username, $password, $message;
	
	if (isset($_POST['username']) && isset($_POST['password'])) {
		if (($_POST['username'] == 'sergio.belli' && $_POST['password'] == '18ser07gio81')
                     || ($_POST['username'] == 'danilo.belli' && $_POST['password'] == 'bellid')) {
			session_start();
			$_SESSION['login'] = 'autorizzato';
			$message = null;
			
			require_once("LoginManager.php");
			$LoginManager::gestioneCertificatiMedici();
			
			header("Location: AtletaView.php");
		} else {
			$message = 'Inserire utenza/password validi!';
		}
	} else {
		
	}
?>
	<head>
		<title>.: GESO - Gestione Societ&agrave; - Atletica Valsesia :.</title><link rel="stylesheet" type="text/css" href="stylesheet.css">
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
		
<br/>
<div align="center"><b>Gestione Societ&agrave; - Atletica Valsesia</b></div>
<br/>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
				<tr><td class="FacetFormHeaderFont">Username</td><td align="center"><input type="text" id="username" name="username" /></td></tr>
				<tr><td class="FacetFormHeaderFont">Password</td><td align="center"><input type="password" id="password" name="password" /></td></tr>
				<tr><td align="center">&nbsp;</td><td align="right"><input type="submit" id="salva" name="salva" class="FacetButton"/></td></tr>
<?php 
			if (isset($message)) { 
				print "<tr>"; 
				print "<td colspan='2' align=\"center\"><font color='red'>".($message)."</font></td>"; 
				print "</tr>"; 
				$message = null;
			} 
?> 
			</table>
		</form>
	</body>

</html>