<?php
require_once("GareAtletaManager.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Gare/Atleta</title><link rel="stylesheet" type="text/css" href="stylesheet.css">
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
	
		<div align="center">
			<a href="ClassificaView.php">Indietro</a>
		</div>
		
<?php
$idAtleta = $_GET['idAtleta'];

require_once("AtletaManager.php");
$AtletaManager = new AtletaManager();
$atleta = AtletaManager::get($idAtleta);
$atleta_row = dbms_fetch_array($atleta);

$GareAtletaManager = new GareAtletaManager();
$elencoGare = GareAtletaManager::lista($idAtleta);
$nGare = 0;
?>		
		<br />
		<div align="center">
			Gare effettuate dall'atleta  <b><?php print($atleta_row["NOME"]." ".$atleta_row["COGNOME"]); ?></b>
		</div>
		
		<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
			<tr>
				<td align="center">#</td>
				<td align="center">Nome</td>
				<td align="center">Localita'</td>
				<td align="center">Campionato</td>
				<td align="center">Data</td>
				<td align="center">Stagione</td>
			</tr>
<?php
		$elencoGare = $GareAtletaManager::lista($idAtleta);
		while ($elencoGare_row = dbms_fetch_array($elencoGare)) {
			$nGare++;
		}
		
		$elencoGare = $GareAtletaManager::lista($idAtleta);
		while ($elencoGare_row = dbms_fetch_array($elencoGare)) {
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$nGare."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["NOME"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["LOCALITA"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["CAMPIONATO"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoGare_row["DATA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoGare_row["STAGIONE"]." &nbsp;</td>";
			print "</tr>";
			$nGare--;
		}
?>			
		</table>
	</body>
</html>

