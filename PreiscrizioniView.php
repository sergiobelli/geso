<?php
	require_once("Header.php");
	require_once("PreiscrizioniManager.php");

	
	global $operazione;
	$operazione = '';
	
	global $preiscrizioni;
	
	global $idPreiscrizioni, $cognomeAtleta, $nomeAtleta, $sessoAtleta, $annoNascitaAtleta, $categoriaAtleta, 
	$codiceFidalAtleta, $codiceFidalSocieta, $nomeSocieta, $idGara, $emailAtleta;
	$idPreiscrizioni = '';
	$cognomeAtleta = '';
	$nomeAtleta	= '';
	$sessoAtleta = '';
	$annoNascitaAtleta = '';
	$categoriaAtleta = '';
	$codiceFidalAtleta = '';
	$codiceFidalSocieta = '';
	$nomeSocieta = '';
	$idGara = '';
	$emailAtleta = '';
	
	global $codiceGaraSelected;
	if (isset($_GET['codiceGaraSelected'])) {
		$codiceGaraSelected = $_GET['codiceGaraSelected'];
	} else {
		$codiceGaraSelected = '';
	}
	/*
	if (isset($_POST['codiceGaraSelected'])) {
		$codiceGaraSelected = $_POST['codiceGaraSelected'];
	} else {
		$codiceGaraSelected = '';
	}
	*/
	
	$PreiscrizioniManager = new PreiscrizioniManager();
	
	if (isset($_GET['operazione']) && $_GET['operazione'] == 'modifica') {
		$operazione = 'modifica';
		$preiscrizioni = PreiscrizioniManager::get($_GET['idPreiscrizioni']);
		while ($preiscrizioni_row = dbms_fetch_array($preiscrizioni)) {
			$idPreiscrizioni = $preiscrizioni_row["ID"];
			$cognomeAtleta = $preiscrizioni_row["COGNOME_ATLETA"];
			$nomeAtleta = $preiscrizioni_row["NOME_ATLETA"];
			$sessoAtleta = $preiscrizioni_row["SESSO_ATLETA"];
			$annoNascitaAtleta = $preiscrizioni_row["ANNO_NASCITA_ATLETA"];
			$categoriaAtleta = $preiscrizioni_row["CATEGORIA_ATLETA"];
			$codiceFidalAtleta = $preiscrizioni_row["CODICE_FIDAL_ATLETA"];
			$codiceFidalSocieta = $preiscrizioni_row["CODICE_SOCIETA"];
			$nomeSocieta = $preiscrizioni_row["NOME_SOCIETA"];
			$idGara = $preiscrizioni_row["ID_GARA"];
			
		}		
	} else if (isset($_GET['operazione']) && $_GET['operazione'] == 'cancella') {
		$operazione = 'cancella';
		$result = PreiscrizioniManager::cancella($_GET['idPreiscrizioni']);
		if ($result == '-1') {
			$message = "Ci sono presenze legate all'preiscrizioni che si sta cancellando, provvedere prima a rimuovere tali informazioni!";
		} else {
			$idPreiscrizioni = null;
			$operazione = null;
		}
	} else {
		$operazione = 'inserisci';
	}
	
	// controllo sul parametro d'invio
	if(isset($_POST['submit']) && (trim($_POST['submit']) == "salva")) {
		if( !isset($_POST['cognomeAtleta']) || $_POST['cognomeAtleta']=="" ){
			echo "Attenzione, inserire il cognome.";
		} elseif( !isset($_POST['nomeAtleta']) || $_POST['nomeAtleta'] =="") {
			echo "Attenzione, inserire il nome.";
		} elseif( !isset($_POST['sessoAtleta']) || $_POST['sessoAtleta'] =="") {
			echo "Attenzione, inserire il sesso.";
		} elseif( !isset($_POST['nomeSocieta']) || $_POST['nomeSocieta'] =="") {
			echo "Attenzione, inserire il nome della societa' di appartenenza.";
		} elseif( !isset($_POST['idGara']) || $_POST['idGara'] =="") {
			echo "Attenzione, inserire la gara.";
		} else {
			// validazione dei parametri tramite filtro per le stringhe
			$idPreiscrizioni = trim($_POST['idPreiscrizioni']);
			$cognomeAtleta = trim($_POST['cognomeAtleta']);
			$nomeAtleta = trim($_POST['nomeAtleta']);
			$sessoAtleta = trim($_POST['sessoAtleta']);
			$annoNascitaAtleta = trim($_POST['annoNascitaAtleta']);
			$categoriaAtleta = trim($_POST['categoriaAtleta']);
			$codiceFidalAtleta = trim($_POST['codiceFidalAtleta']);
			$codiceFidalSocieta = trim($_POST['codiceFidalSocieta']);
			$nomeSocieta = trim($_POST['nomeSocieta']);
			$emailAtleta = trim($_POST['emailAtleta']);
			$idGara = trim($_POST['idGara']);
			
			if (isset($idPreiscrizioni) && $idPreiscrizioni != '') {				
				PreiscrizioniManager::modifica($idPreiscrizioni, $cognomeAtleta, $nomeAtleta, $sessoAtleta, $annoNascitaAtleta);
				$idPreiscrizioni = null;
				$operazione = null;
			} else {
				PreiscrizioniManager::inserisci($cognomeAtleta, $nomeAtleta, $sessoAtleta, $annoNascitaAtleta, $categoriaAtleta, $codiceFidalAtleta, $codiceFidalSocieta, $nomeSocieta, $idGara, $emailAtleta);
				$idPreiscrizioni = null;
				$operazione = null;
			}
			
		}	
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
	<head>
		<title>Preiscrizioni</title>
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
		
		<div align="center">Inserimento Preiscrizioni</div>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
				<tr>
					<td align="center">Cognome (*)</td>
					<td align="center">
						<input type="hidden" id="idPreiscrizioni" name="idPreiscrizioni" value="<?php echo $idPreiscrizioni ?>" />
						<input type="text" id="cognomeAtleta" name="cognomeAtleta" value="<?php echo $cognomeAtleta ?>" />
					</td>
				</tr>
				<tr>
					<td align="center">Nome (*)</td>
					<td align="center"><input type="text" id="nomeAtleta" name="nomeAtleta" value="<?php echo $nomeAtleta ?>"/></td>
				</tr>				
				<tr>
					<td align="center">Sesso (*)</td>
					<td align="center"><input type="text" id="sessoAtleta" name="sessoAtleta" value="<?php echo $sessoAtleta ?>"/></td>
				</tr>
				<tr>
					<td align="center">Anno di Nascita</td>
					<td align="center"><input type="text" id="annoNascitaAtleta" name="annoNascitaAtleta" value="<?php echo $annoNascitaAtleta ?>"/></td>
				</tr>
				<tr>
					<td align="center">Categoria</td>
					<td align="center"><input type="text" id="categoriaAtleta" name="categoriaAtleta" value="<?php echo $categoriaAtleta ?>"/></td>
				</tr>
				<tr>
					<td align="center">Codice Fidal</td>
					<td align="center"><input type="text" id="codiceFidalAtleta" name="codiceFidalAtleta" value="<?php echo $codiceFidalAtleta ?>"/></td>
				</tr>
				<tr>
					<td align="center">Codice Societa'</td>
					<td align="center"><input type="text" id="codiceFidalSocieta" name="codiceFidalSocieta" value="<?php echo $codiceFidalSocieta ?>"/></td>
				</tr>
				<tr>
					<td align="center">Nome Societa' (*)</td>
					<td align="center"><input type="text" id="nomeSocieta" name="nomeSocieta" value="<?php echo $nomeSocieta ?>"/></td>
				</tr>				
				<tr>
					<td align="center">Email</td>
					<td align="center"><input type="text" id="emailAtleta" name="emailAtleta" value="<?php echo $emailAtleta ?>"/></td>
				</tr>				
				<tr>
					<td align="center">Gara (*)</td>
					<td align="center">
						<input type="hidden" id="codiceGaraSelected" name="codiceGaraSelected" value="<?php echo $codiceGaraSelected ?>" />
						<select name="idGara" readonly>
							<option> </option>
<?php
							include("GaraManager.php");
							$GaraManager = new GaraManager();
							$elencoGare = GaraManager::listaOrganizzate();
							while ($elencoGare_row = dbms_fetch_array($elencoGare)) {
								if ($elencoGare_row["CODICE"] == $codiceGaraSelected) {
									print( "<option selected value='".$elencoGare_row["ID"]."'>".$elencoGare_row["LOCALITA"]." - ".$elencoGare_row["NOME"]."</option>" );
								} else {
									print( "<option value='".$elencoGare_row["ID"]."'>".$elencoGare_row["LOCALITA"]." - ".$elencoGare_row["NOME"]."</option>" );
								}
							}
?>
						</select>						

					</td>
				</tr>				
				
				
				<tr>
					<td align="center">&nbsp;</td>
					<td align="right">
						<input type="button" id="cancella" name="cancella" value="cancella" />
						<input type="submit" id="salva" name="submit" value="invia" />
					</td>
				</tr>
			</table>
		</form>
		
		<br />
		<br />
		<br />
		
		<div align="center">Elenco Preiscritti</div>
<?php
		
		$elencoPreiscritti = PreiscrizioniManager::lista($codiceGaraSelected);
?>		
		<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
			<tr>
				<td align="center">#</td>
				<td align="center">Cognome</td>
				<td align="center">Nome</td>
				<td align="center">Sesso</td>
				<td align="center">Anno di Nascita</td>
				<td align="center">Categoria</td>
				<td align="center">Codice Fidal</td>
				<td align="center">Codice Societa'</td>
				<td align="center">Nome Societa'</td>
				<td align="center">Gara</td>
				<td align="center">Data Preiscrizione</td>
				<td align="center" colspan="2">Operazioni</td>
			</tr>
<?php
		$contatore = 1;
		while ($elencoPreiscritti_row = dbms_fetch_array($elencoPreiscritti)) {
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$contatore."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoPreiscritti_row["COGNOME_ATLETA"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoPreiscritti_row["NOME_ATLETA"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoPreiscritti_row["SESSO_ATLETA"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoPreiscritti_row["ANNO_NASCITA_ATLETA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoPreiscritti_row["CATEGORIA_ATLETA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoPreiscritti_row["CODICE_FIDAL_ATLETA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoPreiscritti_row["CODICE_SOCIETA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoPreiscritti_row["NOME_SOCIETA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoPreiscritti_row["GARA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoPreiscritti_row["CREATED"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='PreiscrizioniView.php?operazione=modifica&idPreiscrizioni=".$elencoPreiscritti_row["ID"]."'>modifica</a></td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='PreiscrizioniView.php?operazione=cancella&idPreiscrizioni=".$elencoPreiscritti_row["ID"]."'>cancella</a></td>";
			print "</tr>";
			$contatore++;
		}
?>			
		</table>
		
	</body>
</html>

