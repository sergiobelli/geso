<?php
require_once("ClassificaManager.php");
require_once("StagioneManager.php");
require_once("CategoriaManager.php");

$StagioneManager = new StagioneManager();
$CategoriaManager = new CategoriaManager();

if (isset($_GET['idStagione'])) {
	$stagione = $_GET['idStagione'];
} else if (isset($_SESSION['stagione'])) {
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
	<table align="center">
		<tr valign="top">
		
		
		
		<td width="50%" align="center">
		<b>Classifica generale</b>
		<table border="0" cellpadding="3" cellspacing="1"  class="FacetFormTABLE" align="center">
			<tr>
				<td class="FacetFormHeaderFont" width="10%">#</td>
				<td class="FacetFormHeaderFont" width="40%">Atleta</td>
				<td class="FacetFormHeaderFont" width="10%">Sesso</td>
				<td class="FacetFormHeaderFont" width="10%">Categoria</td>				
				<td class="FacetFormHeaderFont" width="15%">Presenze</td>
				<td class="FacetFormHeaderFont" width="15%">Punteggio</td>
			</tr>
<?php
		$presenzeArray = null;
		$posizioneArray = 0;
		$contatore = 1;
		while ($presenze_row = dbms_fetch_array($presenze)) {
			$categoria = CategoriaManager::getByDataNascitaAndSesso($presenze_row["DATA_NASCITA"],$presenze_row["SESSO"], $stagione);
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$contatore."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$presenze_row["COGNOME"]."&nbsp;".$presenze_row["NOME"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$presenze_row["SESSO"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$categoria."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='GareAtletaView.php?idAtleta=".$presenze_row["ID_ATLETA"]."&idStagione=".$stagione."'>".$presenze_row["PRESENZE"]."</a></td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='GareAtletaView.php?idAtleta=".$presenze_row["ID_ATLETA"]."&idStagione=".$stagione."'>".$presenze_row["PUNTEGGIO"]."</td>";
			print "</tr>";
			
			$presenzeArray[$posizioneArray] = array(
					$presenze_row["ID_ATLETA"],
					$presenze_row["COGNOME"],
					$presenze_row["NOME"],
					$presenze_row["SESSO"],
					$categoria,
					$presenze_row["DATA_NASCITA"],
					$presenze_row["PRESENZE"],
					$presenze_row["PUNTEGGIO"]);
					
			$contatore++;
			$posizioneArray++;
		}
?>			
		</table>
	</td>
	
	<td>&nbsp;</td>

	
	<td width="50%" align="center">
	
	<b>Classifiche di categoria</b>
<?php
	$contatoreCategorie = 1;
	$categorie = CategoriaManager::lista();
	while ($categorie_row = dbms_fetch_array($categorie)) {
		$codiceCategoria = $categorie_row["codice"];
		
		$presenzeCategoria = ClassificaManager::listaByCategoria($presenzeArray, $stagione, $codiceCategoria);
		if ( $presenzeCategoria != null && count($presenzeCategoria) >0 ) {
?>
		<br/>
		<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
			<tr>
				<td class="FacetFormHeaderFont" width="10%">#</td>
				<td class="FacetFormHeaderFont" width="40%">Atleta</td>
				<td class="FacetFormHeaderFont" width="10%">Sesso</td>
				<td class="FacetFormHeaderFont" width="10%">Categoria</td>				
				<td class="FacetFormHeaderFont" width="15%">Presenze</td>
				<td class="FacetFormHeaderFont" width="15%">Punteggio</td>
			</tr>	
<?php	
			$contatoreAtleta = 1;
			for($pos=0;$pos<count($presenzeCategoria);$pos++) {
?>
			<tr>
				<td class="FacetDataTD" align="center"><? echo $contatoreAtleta; ?></td>
				<td class="FacetDataTD" align="left"><? echo $presenzeCategoria[$pos][1]." ".$presenzeCategoria[$pos][2]; ?></td>
				<td class="FacetDataTD" align="center"><? echo $presenzeCategoria[$pos][3]; ?></td>
				<td class="FacetDataTD" align="center"><? echo $presenzeCategoria[$pos][4]; ?></td>				
				<td class="FacetDataTD" align="center"><? echo $presenzeCategoria[$pos][6]; ?></td>
				<td class="FacetDataTD" align="center"><? echo $presenzeCategoria[$pos][7]; ?></td>
			</tr>	
<?php			
				$contatoreAtleta++;
			}
?>
		</table>
<?php			
		}
		$contatoreCategorie++;
	}
?>	
	</td>	
</tr></table>
	</body>
</html>