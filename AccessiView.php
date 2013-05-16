<?php
	require_once("Header.php");
	require_once("AccessiManager.php");
	
	// inizializzazione della sessione
	//session_start();
	// se la sessione di autenticazione
	// è già impostata non sarà necessario effettuare il login
	// e il browser verrà reindirizzato alla pagina di scrittura dei post
	if (!isset($_SESSION['login'])) {
		// reindirizzamento alla homepage in caso di login mancato
		header("Location: index.php");
	}
	
	$AccessiManager = new AccessiManager();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
	<head>
		<title>Accessi</title>
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
	
		<div align="center">Elenco Accessi</div>
<?php		
		$elencoAccessi = AccessiManager::lista();
?>		
		<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
			<tr>
				<td class="FacetFormHeaderFont">Id</td>
				<td class="FacetFormHeaderFont">User</td>
				<td class="FacetFormHeaderFont">Ip</td>
				<td class="FacetFormHeaderFont">Host</td>
				<td class="FacetFormHeaderFont">Pagina</td>
				<td class="FacetFormHeaderFont">Operazione</td>
				<td class="FacetFormHeaderFont">Data</td>
			</tr>
<?php
		
		while ($elencoAccessi_row = dbms_fetch_array($elencoAccessi)) {
		
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoAccessi_row["ID"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoAccessi_row["USER"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAccessi_row["IP"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAccessi_row["HOST"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAccessi_row["PAGINA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAccessi_row["OPERAZIONE"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAccessi_row["DATA"]." &nbsp;</td>";
			print "</tr>";
		}
		
?>			
		</table>
		
	</body>
</html>