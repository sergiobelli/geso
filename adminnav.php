<?php
require_once("ConfigManager.php");
$ConfigManager = new ConfigManager();
$versione = $ConfigManager->getVersione();
?>

<div align="right" class="version"><?php echo $versione ?></div>

<div align="center">
	<a href="AtletaView.php">Atleti</a> 									| 
	<a href="ExAtletaView.php">Ex-Atleti</a> 								| 
	<a href="CertificatoMedicoView.php"> Certificati Medici </a>	| 
	<a href="GaraView.php"> Gare </a>										| 
	<a href="PresenzaView.php"> Presenze </a>								| 
	<a href="ClassificaView.php" target="new"> Classifica </a>		
	&nbsp;&nbsp;&nbsp;															
	<a href="AccessiView.php"> Accessi </a>		
</div>

<br /><br />