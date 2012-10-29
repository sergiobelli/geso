<?php
	require_once("Header.php");
	require_once("CertificatoMedicoManager.php");
	require_once("AtletaManager.php");
	
	global $operazione;
	$operazione = '';
	
	global $atleta;
	
	global $idCertificatoMedico, $idAtleta, $dataScadenza, $agonistico;
	$idCertificatoMedico = '';
	$idAtleta = '';
	$dataScadenza = '';
	$agonistico = '';

	// inizializzazione della sessione
	//session_start();
	// se la sessione di autenticazione
	// è già impostata non sarà necessario effettuare il login
	// e il browser verrà reindirizzato alla pagina di scrittura dei post
	if (!isset($_SESSION['login'])) {
		// reindirizzamento alla homepage in caso di login mancato
		header("Location: index.php");
	}
	
	$CertificatoMedicoManager = new CertificatoMedicoManager();
	
	if (isset($_GET['operazione']) && $_GET['operazione'] == 'modifica') {
		$operazione = 'modifica';
		$atleta = CertificatoMedicoManager::get($_GET['idCertificatoMedico']);
		while ($atleta_row = dbms_fetch_array($atleta)) {
			$idCertificatoMedico = $atleta_row["id_certificato_medico"];
			$idAtleta = $atleta_row["ID_ATLETA"];
			$dataScadenza = $atleta_row["DATA_SCADENZA"];
			$agonistico = $atleta_row["AGONISTICO"];
		}
	} else if (isset($_GET['operazione']) && $_GET['operazione'] == 'cancella') {
		$operazione = 'cancella';
		$result = CertificatoMedicoManager::cancella($_GET['idCertificatoMedico']);
		$idCertificatoMedico = null;
		$operazione = null;
	} else {
		$operazione = 'inserisci';
	}
	
	// controllo sul parametro d'invio
	if(isset($_POST['submit']) && (trim($_POST['submit']) == "salva")) {
		if( !isset($_POST['idAtleta']) || $_POST['idAtleta']=="" ){
			echo "Attenzione, inserire l'atleta.";
		} elseif( !isset($_POST['dataScadenza']) || $_POST['dataScadenza'] =="") {
			echo "Attenzione, inserire la data scadenza.";
		} elseif( !isset($_POST['agonistico']) || $_POST['agonistico'] =="") {
			echo "Attenzione, inserire lìagonistico.";
		} else {
			// validazione dei parametri tramite filtro per le stringhe
			//$idCertificatoMedico = trim($_POST['idCertificatoMedico']);
			$idAtleta = trim($_POST['idAtleta']);
			$dataScadenza = trim($_POST['dataScadenza']);
			$agonistico = trim($_POST['agonistico']);
			
			if (isset($idCertificatoMedico) && $idCertificatoMedico != '') {
				CertificatoMedicoManager::modifica($idCertificatoMedico, $idAtleta, $dataScadenza, $agonistico);
				$idCertificatoMedico = null;
				$operazione = null;
			} else {
				CertificatoMedicoManager::inserisci($idAtleta, $dataScadenza, $agonistico);
				$idCertificatoMedico = null;
				$operazione = null;
			}
			
		}	
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
	<head>
		<title>Certificati Medici</title><link rel="stylesheet" type="text/css" href="stylesheet.css">
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
		
		<div align="center">Inserimento/Modifica Certificazioni Mediche Atleti</div>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
				<tr>
					<td class="FacetFormHeaderFont">Atleta</td>
					<td align="right">
						
						<select name="idAtleta">
							<option> </option>
<?php
							$AtletaManager = new AtletaManager();
							$elencoAtleti = AtletaManager::lista();
							while ($elencoAtleti_row = dbms_fetch_array($elencoAtleti)) {
								if ($elencoAtleti_row["ID"] == $idAtleta) {
									print( "<option selected value='".$elencoAtleti_row["ID"]."'>".$elencoAtleti_row["COGNOME"]." ".$elencoAtleti_row["NOME"]."</option>" );
								} else {
									print( "<option value='".$elencoAtleti_row["ID"]."'>".$elencoAtleti_row["COGNOME"]." ".$elencoAtleti_row["NOME"]."</option>" );
								}
							}
?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Data Scadenza</td>
					<td align="center"><input type="text" id="dataScadenza" name="dataScadenza" value="<?php echo $dataScadenza ?>"/></td>
				</tr>				
				<tr>
					<td class="FacetFormHeaderFont">Agonistico</td>
					<td align="center"><input type="text" id="agonistico" name="agonistico" value="<?php echo $agonistico ?>"/></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">&nbsp;</td>
					<td align="right">
						<input type="button" id="cancella" name="cancella" value="cancella" />
						<input type="submit" id="salva" name="submit" value="salva" />
					</td>
				</tr>
			</table>
		</form>
		
		<br />
		<br />
		<br />
		
		<div align="center">Elenco Certificati Medici</div>
<?php
		
		$elencoCertificatiMedici = CertificatoMedicoManager::lista();
?>		
		<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
			<tr>
				<td class="FacetFormHeaderFont">#</td>
				<td class="FacetFormHeaderFont">Cognome</td>
				<td class="FacetFormHeaderFont">Nome</td>
				<td class="FacetFormHeaderFont">Sesso</td>
				<td class="FacetFormHeaderFont">Data di Nascita</td>
				<td class="FacetFormHeaderFont">Data Scadenza</td>
				<td class="FacetFormHeaderFont">Agonistico</td>
				<td class="FacetFormHeaderFont" colspan="2">Operazioni</td>
			</tr>
<?php
		$contatore = 1;
		while ($elencoCertificatiMedici_row = dbms_fetch_array($elencoCertificatiMedici)) {
			
			$dataScadenzaCertificato = $elencoCertificatiMedici_row["data_scadenza"];
			$diffDate = fDateDiff(date("Y-m-d"), $dataScadenzaCertificato);
			
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$contatore."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoCertificatiMedici_row["cognome_atleta"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoCertificatiMedici_row["nome_atleta"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoCertificatiMedici_row["sesso_atleta"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoCertificatiMedici_row["data_nascita_atleta"]." &nbsp;</td>";
			
			if ($diffDate >= 90) {
				print "<td class=\"FacetDataTDGreen\" align=\"center\">".$dataScadenzaCertificato." &nbsp;</font></td>";
			} else if ($diffDate < 90 && $diffDate >= 30) {
				print "<td class=\"FacetDataTDOrange\" align=\"center\">".$dataScadenzaCertificato." &nbsp;</font></td>";
			} else if ($diffDate < 30) {
				print "<td class=\"FacetDataTDRed\" align=\"center\">".$dataScadenzaCertificato." &nbsp;</font></td>";
			} else {
				print "<td class=\"FacetDataTD\" align=\"center\">".$dataScadenzaCertificato." &nbsp;</font></td>";
			}
			
			
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoCertificatiMedici_row["agonistico"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='CertificatoMedicoView.php?operazione=cancella&idCertificatoMedico=".$elencoCertificatiMedici_row["id_certificato_medico"]."'>cancella</a></td>";
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