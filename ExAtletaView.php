<?php
	require_once("Header.php");
	require_once("AtletaManager.php");
	require_once("CategoriaManager.php");
	
	global $operazione;
	$operazione = '';
	
	global $atleta;
	
	global $idAtleta, $cognome, $nome, $sesso, $dataNascita, $dataTesseramento, $codiceFidal, $comuneResidenza, $provinciaResidenza, $indirizzoResidenza, $telefono, $cellulare, $email, $taglia, $consensoTrattamentoDati;
	$idAtleta = '';
	$cognome = '';
	$nome = '';
	$sesso = '';
	$dataNascita = '';
	$dataTesseramento = '';
        $codiceFidal = '';
	$comuneResidenza = '';
	$provinciaResidenza = '';
	$indirizzoResidenza = '';
	$telefono = '';
	$cellulare = '';
	$email = '';
	$taglia = '';
	$consensoTrattamentoDati;

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
	
	if (isset($_GET['operazione']) && $_GET['operazione'] == 'modifica') {
		$operazione = 'modifica';
		$atleta = AtletaManager::get($_GET['idAtleta']);
		while ($atleta_row = dbms_fetch_array($atleta)) {
			$idAtleta = $atleta_row["ID"];
			$cognome = $atleta_row["COGNOME"];
			$nome = $atleta_row["NOME"];
			$sesso = $atleta_row["SESSO"];
			$dataNascita = $atleta_row["DATA_NASCITA"];
			$dataTesseramento = $atleta_row["DATA_TESSERAMENTO"];
			$codiceFidal = $atleta_row["CODICE_FIDAL"];
			$comuneResidenza= $atleta_row["COMUNE_RESIDENZA"];
			$provinciaResidenza= $atleta_row["PROVINCIA_RESIDENZA"];
			$indirizzoResidenza= $atleta_row["INDIRIZZO_RESIDENZA"];
			$telefono= $atleta_row["TELEFONO"];
			$cellulare= $atleta_row["CELLULARE"];
			$email= $atleta_row["EMAIL"];
			$taglia= $atleta_row["TAGLIA"];
			$consensoTrattamentoDati= $atleta_row["CONSENSO_DATI_PERSONALI"];
		}		
	} else if (isset($_GET['operazione']) && $_GET['operazione'] == 'cancella') {
		$operazione = 'cancella';
		$result = AtletaManager::cancella($_GET['idAtleta']);
		if ($result == '-1') {
			$message = "Ci sono presenze legate all'atleta che si sta cancellando, provvedere prima a rimuovere tali informazioni!";
		} else {
			$idAtleta = null;
			$operazione = null;
		}
	} else {
		$operazione = 'inserisci';
	}
	
	// controllo sul parametro d'invio
	if(isset($_POST['submit']) && (trim($_POST['submit']) == "salva")) {
		if( !isset($_POST['cognome']) || $_POST['cognome']=="" ){
			echo "Attenzione, inserire il cognome.";
		} elseif( !isset($_POST['nome']) || $_POST['nome'] =="") {
			echo "Attenzione, inserire il nome.";
		} elseif( !isset($_POST['sesso']) || $_POST['sesso'] =="") {
			echo "Attenzione, inserire il sesso.";
		} elseif( !isset($_POST['dataNascita']) || $_POST['dataNascita'] =="") {
			echo "Attenzione, inserire la data di nascita.";
		} else {
			// validazione dei parametri tramite filtro per le stringhe
			$idAtleta = trim($_POST['idAtleta']);
			$cognome = trim($_POST['cognome']);
			$nome = trim($_POST['nome']);
			$sesso = trim($_POST['sesso']);
			$dataNascita = trim($_POST['dataNascita']);
			$dataTesseramento= trim($_POST['dataTesseramento']);
			$codiceFidal= trim($_POST['codiceFidal']);
			$comuneResidenza= trim($_POST['comuneResidenza']);
			$provinciaResidenza= trim($_POST['provinciaResidenza']);
			$indirizzoResidenza= trim($_POST['indirizzoResidenza']);
			$telefono= trim($_POST['telefono']);
			$cellulare= trim($_POST['cellulare']);
			$email= trim($_POST['email']);
			$taglia= trim($_POST['taglia']);
			$consensoTrattamentoDati= trim($_POST['consensoTrattamentoDati']);
			/*
			$idAtleta = trim(filter_var($_POST['idAtleta'], FILTER_SANITIZE_STRING));
			$cognome = trim(filter_var($_POST['cognome'], FILTER_SANITIZE_STRING));
			$nome = trim(filter_var($_POST['nome'], FILTER_SANITIZE_STRING));
			$sesso = trim(filter_var($_POST['sesso'], FILTER_SANITIZE_STRING));
			$dataNascita = trim(filter_var($_POST['dataNascita'], FILTER_SANITIZE_STRING));
			*/
			
			if (isset($idAtleta) && $idAtleta != '') {
				AtletaManager::modifica(
					$idAtleta, 
					$cognome, 
					$nome, 
					$sesso, 
					$dataNascita, 
					$dataTesseramento, 
					$codiceFidal, 
					$comuneResidenza, 
					$provinciaResidenza, 
					$indirizzoResidenza, 
					$telefono, 
					$cellulare, 
					$email, 
					$taglia, 
					$consensoTrattamentoDati);
				$idAtleta = null;
				$operazione = null;
				$cognome = null;
				$nome = null;
					$sesso = null;
					$dataNascita = null;
					$dataTesseramento = null;
					$codiceFidal = null;
					$comuneResidenza = null;
					$provinciaResidenza = null;
					$indirizzoResidenza = null;
					$telefono = null;
					$cellulare = null;
					$email = null;
					$taglia = null;
					$consensoTrattamentoDati = null;
			}
			
		}	
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
	<head>
		<title>Ex-Atleti</title><link rel="stylesheet" type="text/css" href="stylesheet.css">
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
				<td class="FacetFormHeaderFont">Categoria Fidal</td>				
				<td class="FacetFormHeaderFont">Certificato medico</td>
				<td class="FacetFormHeaderFont">Comune di residenza</td>
				<!--<td class="FacetFormHeaderFont">Telefono</td>-->
				<td class="FacetFormHeaderFont">Cellulare</td>
				<td class="FacetFormHeaderFont">Email</td>
				<td class="FacetFormHeaderFont">Taglia</td>
				<!--<td class="FacetFormHeaderFont">Consenso Trattamento Dati</td>-->
				<td class="FacetFormHeaderFont" colspan="2">Operazioni</td>
			</tr>
<?php
		$contatore = 1;
		
		
		while ($elencoAtleti_row = dbms_fetch_array($elencoAtleti)) {
		
			$dataScadenzaCertificato = $elencoAtleti_row["DATA_SCADENZA_CERTIFICATO_MEDICO"];
			$sessoAtleta = $elencoAtleti_row["SESSO"];
			$dataNascitaAtleta = $elencoAtleti_row["DATA_NASCITA"];
			$diffDate = fDateDiff(date("Y-m-d"), $dataScadenzaCertificato);
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$contatore."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoAtleti_row["COGNOME"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoAtleti_row["NOME"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$sessoAtleta."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$dataNascitaAtleta." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["DATA_TESSERAMENTO"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["CODICE_FIDAL"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".CategoriaManager::getByDataNascitaAndSesso($dataNascitaAtleta,$sessoAtleta)."</td>";
			if ($diffDate >= 90) {
				print "<td class=\"FacetDataTDGreen\" align=\"center\">".$dataScadenzaCertificato." &nbsp;</font></td>";
			} else if ($diffDate < 90 && $diffDate >= 30) {
				print "<td class=\"FacetDataTDOrange\" align=\"center\">".$dataScadenzaCertificato." &nbsp;</font></td>";
			} else if ($diffDate < 30) {
				print "<td class=\"FacetDataTDRed\" align=\"center\">".$dataScadenzaCertificato." &nbsp;</font></td>";
			} else {
				print "<td class=\"FacetDataTD\" align=\"center\">".$dataScadenzaCertificato." &nbsp;</font></td>";
			}
			
			$comRes = $elencoAtleti_row["COMUNE_RESIDENZA"];
			$provRes = $elencoAtleti_row["PROVINCIA_RESIDENZA"];
			if ($comRes != '' && provRes != '') {
				print "<td class=\"FacetDataTD\" align=\"center\">"
					.$comRes
					." ("
					.$provRes
					.")"
					." &nbsp;</td>";
			} else {
				print "<td class=\"FacetDataTD\" align=\"center\">&nbsp;</td>";
			}
			
			//print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["TELEFONO"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["CELLULARE"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["EMAIL"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["TAGLIA"]." &nbsp;</td>";
			//print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["CONSENSO_DATI_PERSONALI"]." &nbsp;</td>";
			
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='AtletaView.php?operazione=modifica&idAtleta=".$elencoAtleti_row["ID"]."'>modifica</a></td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='AtletaView.php?operazione=cancella&idAtleta=".$elencoAtleti_row["ID"]."'>cancella</a></td>";
			print "</tr>";
			$contatore++;
		}
		
		function fDateDiff($dateFrom, $dateA) {
		
			if ($dateA != '') {
				list($d, $m, $y) = explode('/', $dateA);
				$mk=mktime(0, 0, 0, $m, $d, $y);
				$dateTo=strftime('%Y-%m-%d',$mk);
			} else {
				return 100;
			}
			
			if(empty($dateFrom)) $dateFrom = date('Y-m-d'); 
			if(empty($dateTo)) $dateTo = date('Y-m-d'); 
			
			$a_1 = explode('-',$dateFrom); 
			$a_2 = explode('-',$dateTo); 
			$mktime1 = mktime(0, 0, 0, $a_1[1], $a_1[2], $a_1[0]); 
			$mktime2 = mktime(0, 0, 0, $a_2[1], $a_2[2], $a_2[0]); 
			$secondi = $mktime1 - $mktime2; 
			$giorni = intval($secondi / 86400);  
			return -($giorni);
		}
?>			
		</table>
		
	</body>
</html>