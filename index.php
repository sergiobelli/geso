<html>

<?php
	require_once("LoginManager.php");
	require_once("AccessiManager.php");
	require_once("ConfigManager.php");
	
	global $username, $password, $message;

	$ConfigManager = new ConfigManager();
	$versione = $ConfigManager->getVersione();
	$ambiente = $ConfigManager->getAmbiente();
	$utenza = "n.d.";
	$stagione = "n.d.";
	
	$LoginManager = new LoginManager();
	$AccessiManager = new AccessiManager();
				
	if (isset($_POST['username']) && isset($_POST['password'])) {
		
		$auth = $LoginManager->autenticate($_POST['username'],$_POST['password']);
		
		if (mysql_num_rows($auth)!=0) {
			
			session_start();
			$_SESSION['login'] = 'autorizzato';
			$_SESSION['username'] = $_POST['username'];
			$message = null;
			
			AccessiManager::inserisci(
				$_POST['username'], 
				$_SERVER['REMOTE_ADDR'], 
				gethostbyaddr($_SERVER['REMOTE_ADDR']), 
				$_SERVER['REQUEST_URI'], 
				'LOGIN->DONE');
			
			$LoginManager::gestioneCertificatiMedici();
			
			//header("Location: AtletaView.php");
			header("Location: view/selezioneStagione.php");
		} else {
			
			AccessiManager::inserisci(
				$_POST['username'], 
				$_SERVER['REMOTE_ADDR'], 
				gethostbyaddr($_SERVER['REMOTE_ADDR']),
				$_SERVER['REQUEST_URI'], 
				'LOGIN->FAILED');

			$message = 'Inserire utenza/password validi!';
		}
	} else {
		
	}
?>
	<head>
		<title>.: GESO - Gestione Societ&agrave; - Atletica Valsesia :.</title>
		
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
		<link type="text/css" href="css/redmond/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />
		
		<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.20.custom.min.js"></script>
		
		<script type="text/javascript">
			
			$(function(){
				$( "#salva" ).button();
			});
		</script>

	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
		
<br/>


<div align="right" class="version">
	<table>
		<tr><td>versione    : </td><td><?php echo $versione; ?></td></tr>
		<tr><td>ambiente    : </td><td><?php echo $ambiente; ?></td></tr>
		<tr><td>utenza      : </td><td><?php echo $utenza; ?></td></tr>
		<tr><td>stagione    : </td><td><?php echo $stagione; ?></td></tr>
	</table>
</div>

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
					<td align="right"><input type="submit" id="salva" name="salva" value="login" class="FacetButton"/></td>
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