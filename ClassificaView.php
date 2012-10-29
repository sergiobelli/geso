
<?php
require_once("ClassificaManager.php");
//prova

if (!isset($stagione)) {
	include ("StagioneManager.php");
	$StagioneManager = new StagioneManager();
	$stagione = $StagioneManager::getUltimaStagione();
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>
			Classifica "Campionato Sociale Atletica Valsesia" stagione <b><?php echo($stagione); ?></b>
		</title>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
		<div align="center">
			Classifica "Campionato Sociale Atletica Valsesia" stagione <b><?php echo($stagione); ?></b>
		</div>
		<br />
<?php
$ClassificaManager = new ClassificaManager();
$presenze = ClassificaManager::lista($stagione);
?>		
		<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
			<tr>
				<td align="center">#</td>
				<td align="center">Atleta</td>
				<td align="center">Sesso</td>
				<td align="center">Punti</td>
			</tr>
<?php
		$contatore = 1;
		while ($presenze_row = dbms_fetch_array($presenze)) {
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$contatore."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$presenze_row["COGNOME"]."&nbsp;".$presenze_row["NOME"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$presenze_row["SESSO"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='GareAtletaView.php?idAtleta=".$presenze_row["ID_ATLETA"]."'>".$presenze_row["PRESENZE"]."</a></td>";
			print "<td class=\"FacetDataTD\" align=\"center\">&nbsp;</td>";    
			print "</tr>";
			$contatore++;
		}
?>			
		</table>
	</body>
</html>

