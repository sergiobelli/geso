<html>

<?php
	require_once("LoginManager.php");
	require_once("AccessiManager.php");
	//require_once("util/Log.php");
	
	global $username, $password, $message;

	//$conf = array('mode' => 0600, 'timeFormat' => '%X %x');
   //$logger = &Log::singleton('file', 'logs/login.log', 'geso', $conf);
		
	$LoginManager = new LoginManager();
	$AccessiManager = new AccessiManager();
				
	if (isset($_POST['username']) && isset($_POST['password'])) {
		
		//$logger->log("login done by ".$_POST['username']);
		$auth = $LoginManager->autenticate($_POST['username'],$_POST['password']);
		
		if (mysql_num_rows($auth)!=0) {
			
			//$logger->log("login done by ".$_POST['username']);
			session_start();
			$_SESSION['login'] = 'autorizzato';
			$_SESSION['username'] = $_POST['username'];
			$message = null;
			
			AccessiManager::inserisci(
				$_POST['username'], 
				$_SERVER['REMOTE_ADDR'], 
				'n.d.', 
				$_SERVER['REQUEST_URI'], 
				'LOGIN->DONE');
			
			$LoginManager::gestioneCertificatiMedici();
			
			//header("Location: AtletaView.php");
			header("Location: view/selezioneStagione.php");
		} else {
			
			//$logger->log("login failed by ".$_POST['username']);
			AccessiManager::inserisci(
				$_POST['username'], 
				$_SERVER['REMOTE_ADDR'], 
				'n.d.',
				$_SERVER['REQUEST_URI'], 
				'LOGIN->FAILED');

			$message = 'Inserire utenza/password validi!';
		}
	} else {
		
	}
?>
	<head>
		<title>.: GESO - Gestione Societ&agrave; - Atletica Valsesia :.</title>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
		
<br/>
<div align="center"><b>Gestione Societ&agrave; - Atletica Valsesia</b></div>
<br/>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
				<tr>
					<td class="FacetFormHeaderFont">Username</td>
					<td align="center"><input type="text" id="username" name="username" /></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Password</td>
					<td align="center"><input type="password" id="password" name="password" /></td>
				</tr>
				<tr>
					<td align="center">&nbsp;</td>
					<td align="right"><input type="submit" id="salva" name="salva" class="FacetButton"/></td>
				</tr>
<?php 
			if (isset($message)) { 
				print "<tr>"; 
				print "<td colspan='2' class=\"FacetDataTDRed\" align=\"center\">".($message)."</td>"; 
				print "</tr>"; 
				$message = null;
			} 
?> 
			</table>
		</form>
	</body>

</html>