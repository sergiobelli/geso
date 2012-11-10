<?php
require_once("ClassificaManager.php");
require_once("StagioneManager.php");

$StagioneManager = new StagioneManager();

if (isset($_SESSION['stagione'])) {
	$stagione = $_SESSION['stagione'];
} else {
	$stagione = $StagioneManager::getUltimaStagione();
}

$descrizioneStagione = $StagioneManager::getDescrizioneStagione($stagione);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>
			Classifica "Campionato Sociale Atletica Valsesia" stagione <?php echo($descrizioneStagione); ?>
		</title>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
		<div align="center">
			Classifica "Campionato Sociale Atletica Valsesia" stagione <b><?php echo($descrizioneStagione); ?></b>
		</div>
<?php
$ClassificaManager = new ClassificaManager();
$ultimoAggiornamento = '';
$ultimoAggiornamentoRes = ClassificaManager::getUltimoAggiornamento($stagione);
while ($ultimoAggiornamentoRes_row = dbms_fetch_array($ultimoAggiornamentoRes)) {
	$ultimoAggiornamento = $ultimoAggiornamentoRes_row["ULTIMO_AGGIORNAMENTO"];
}
?>
<br/>
		<div align="center">
			Ultimo aggiornamento : <b><?php echo($ultimoAggiornamento ); ?></b>
		</div>
		<br />
<?php

$presenze = ClassificaManager::lista($stagione);
?>		
		<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
			<tr>
				<td class="FacetFormHeaderFont">#</td>
				<td class="FacetFormHeaderFont">Atleta</td>
				<td class="FacetFormHeaderFont">Sesso</td>
				<td class="FacetFormHeaderFont">Presenze</td>
				<td class="FacetFormHeaderFont">Punteggio</td>
			</tr>
<?php
		$contatore = 1;
		while ($presenze_row = dbms_fetch_array($presenze)) {
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$contatore."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$presenze_row["COGNOME"]."&nbsp;".$presenze_row["NOME"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$presenze_row["SESSO"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='GareAtletaView.php?idAtleta=".$presenze_row["ID_ATLETA"]."'>".$presenze_row["PRESENZE"]."</a></td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$presenze_row["PUNTEGGIO"]."</td>";
			print "</tr>";
			$contatore++;
		}
?>			
		</table>
	</body>
</html>