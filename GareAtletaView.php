<?php
require_once("GareAtletaManager.php");
require_once("AtletaManager.php");

$idAtleta = $_GET['idAtleta'];
$idStagione = $_GET['idStagione'];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Gare/Atleta</title><link rel="stylesheet" type="text/css" href="stylesheet.css">
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
			<div align="center">
			<a href="ClassificaView.php?idStagione=<?php echo $idStagione; ?> ">Indietro</a>
		</div>
		
<?php

$AtletaManager = new AtletaManager();
$atleta = AtletaManager::get($idAtleta);
$atleta_row = dbms_fetch_array($atleta);

$GareAtletaManager = new GareAtletaManager();
$elencoGare = GareAtletaManager::lista($idAtleta, $idStagione);
$nGare = 0;
?>		
		<br />
		<div align="center">
			Gare effettuate dall'atleta  <b><?php print($atleta_row["NOME"]." ".$atleta_row["COGNOME"]); ?></b>
		</div>
		
		<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
			<tr>
				<td class="FacetFormHeaderFont">#</td>
				<td class="FacetFormHeaderFont">Nome</td>
				<td class="FacetFormHeaderFont">Localita'</td>
				<td class="FacetFormHeaderFont">Campionato</td>
				<td class="FacetFormHeaderFont">Tipologia Gara</td>
				<td class="FacetFormHeaderFont">Data</td>
				<td class="FacetFormHeaderFont">Stagione</td>
			</tr>
<?php
		$elencoGare = $GareAtletaManager::lista($idAtleta, $idStagione);
		while ($elencoGare_row = dbms_fetch_array($elencoGare)) {
			$nGare++;
		}
		
		$elencoGare = $GareAtletaManager::lista($idAtleta, $idStagione);
		while ($elencoGare_row = dbms_fetch_array($elencoGare)) {
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$nGare."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["NOME"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["LOCALITA"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["CAMPIONATO"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["TIPOLOGIA_GARA"]." (".$elencoGare_row["PUNTI"]." punti)</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoGare_row["DATA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoGare_row["STAGIONE"]." &nbsp;</td>";
			print "</tr>";
			$nGare--;
		}
?>			
		</table>
	</body>
</html>
