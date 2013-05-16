<?php
	require_once("Header.php");
	require_once("AtletaManager.php");
	require_once("CategoriaManager.php");
	
	global $operazione;
	$operazione = '';
	
	// inizializzazione della sessione
	//session_start();
	// se la sessione di autenticazione
	// è già impostata non sarà necessario effettuare il login
	// e il browser verrà reindirizzato alla pagina di scrittura dei post
	if (!isset($_SESSION['login'])) {
		// reindirizzamento alla homepage in caso di login mancato
		header("Location: index.php");
	}
	
	$AtletaManager = new AtletaManager();
	$CategoriaManager = new CategoriaManager();
	
	if (isset($_GET['operazione']) && $_GET['operazione'] == 'ripristina') {
		$operazione = 'ripristina';
		$result = AtletaManager::ripristina($_GET['idAtleta']);
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
	<head>
		<title>Ex-Atleti</title>
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
	
		<div align="center">
<?php 
			if (isset($message)) { 
				print "<br />"; 
				print "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" class=\"FacetFormTABLE\" align=\"center\">"; 
				print "	<tr>"; 
				print "		<td align=\"center\">".($message)."</td>"; 
				print "	</tr>"; 
				print "</table>"; 
				print "<br />"; 
				$message = null;
			} 
?> 
		</div>
		
		<div align="center">Elenco Ex-Atleti</div>
<?php		
		$elencoAtleti = AtletaManager::listaEx();
?>		
		<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
			<tr>
				<td class="FacetFormHeaderFont">#</td>
				<td class="FacetFormHeaderFont">Cognome</td>
				<td class="FacetFormHeaderFont">Nome</td>
				<td class="FacetFormHeaderFont">Sesso</td>
				<td class="FacetFormHeaderFont">Data di Nascita</td>
				<td class="FacetFormHeaderFont">Data di Tesseramento</td>
				<td class="FacetFormHeaderFont">Codice Fidal</td>

				<td class="FacetFormHeaderFont" colspan="2">Operazioni</td>
			</tr>
<?php
		$contatore = 1;
		
		while ($elencoAtleti_row = dbms_fetch_array($elencoAtleti)) {
		
			$dataScadenzaCertificato = $elencoAtleti_row["DATA_SCADENZA_CERTIFICATO_MEDICO"];
			$sessoAtleta = $elencoAtleti_row["SESSO"];
			$dataNascitaAtleta = $elencoAtleti_row["DATA_NASCITA"];
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$contatore."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoAtleti_row["COGNOME"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoAtleti_row["NOME"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$sessoAtleta."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$dataNascitaAtleta." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["DATA_TESSERAMENTO"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["CODICE_FIDAL"]." &nbsp;</td>";
						
			print "<td class=\"FacetDataTD\" colspan=\"2\" align=\"center\"><a href='ExAtletaView.php?operazione=ripristina&idAtleta=".$elencoAtleti_row["ID"]."'>ripristina</a></td>";
			print "</tr>";
			$contatore++;
		}
		
?>			
		</table>
		
	</body>
</html>