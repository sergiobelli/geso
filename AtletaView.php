<?php
	require_once("Header.php");
	require_once("AtletaManager.php");

	
	global $operazione;
	$operazione = '';
	
	global $atleta;
	
	global $idAtleta, $cognome, $nome, $sesso, $dataNascita, $dataTesseramento, $codiceFidal;
	$idAtleta = '';
	$cognome = '';
	$nome = '';
	$sesso = '';
	$dataNascita = '';
	$dataTesseramento = '';
        $codiceFidal = '';

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
			/*
			$idAtleta = trim(filter_var($_POST['idAtleta'], FILTER_SANITIZE_STRING));
			$cognome = trim(filter_var($_POST['cognome'], FILTER_SANITIZE_STRING));
			$nome = trim(filter_var($_POST['nome'], FILTER_SANITIZE_STRING));
			$sesso = trim(filter_var($_POST['sesso'], FILTER_SANITIZE_STRING));
			$dataNascita = trim(filter_var($_POST['dataNascita'], FILTER_SANITIZE_STRING));
			*/
			
			if (isset($idAtleta) && $idAtleta != '') {				
				AtletaManager::modifica($idAtleta, $cognome, $nome, $sesso, $dataNascita, $dataTesseramento, $codiceFidal);
				$idAtleta = null;
				$operazione = null;
			} else {
				AtletaManager::inserisci($cognome, $nome, $sesso, $dataNascita, $dataTesseramento, $codiceFidal);
				$idAtleta = null;
				$operazione = null;				
			}
			
		}	
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
	<head>
		<title>Atleti</title><link rel="stylesheet" type="text/css" href="stylesheet.css">
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
		
		<div align="center">Inserimento/Modifica Atleti</div>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
				<tr>
					<td align="center">Cognome</td>
					<td align="center">
						<input type="hidden" id="idAtleta" name="idAtleta" value="<?php echo $idAtleta ?>" />
						<input type="text" id="cognome" name="cognome" value="<?php echo $cognome ?>" />
					</td>
				</tr>
				<tr>
					<td align="center">Nome</td>
					<td align="center"><input type="text" id="nome" name="nome" value="<?php echo $nome ?>"/></td>
				</tr>				
				<tr>
					<td align="center">Sesso</td>
					<td align="center"><input type="text" id="sesso" name="sesso" value="<?php echo $sesso ?>"/></td>
				</tr>
				<tr>
					<td align="center">Data di Nascita</td>
					<td align="center"><input type="text" id="dataNascita" name="dataNascita" value="<?php echo $dataNascita ?>"/></td>
				</tr>
				<tr>
					<td align="center">Data di Tesseramento</td>
					<td align="center"><input type="text" id="dataTesseramento" name="dataTesseramento" value="<?php echo $dataTesseramento?>"/></td>
				</tr>
				<tr>
					<td align="center">Codice Fidal</td>
					<td align="center"><input type="text" id="codiceFidal" name="codiceFidal" value="<?php echo $codiceFidal?>"/></td>
				</tr>
				<tr>
					<td align="center">&nbsp;</td>
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
		
		<div align="center">Elenco Atleti</div>
<?php
		
		$elencoAtleti = AtletaManager::lista();
?>		
		<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
			<tr>
				<td align="center">#</td>
				<td align="center">Cognome</td>
				<td align="center">Nome</td>
				<td align="center">Sesso</td>
				<td align="center">Data di Nascita</td>
				<td align="center">Data di Tesseramento</td>
				<td align="center">Codice Fidal</td>
				<td align="center">Data scadenza certificato medico</td>
				<td align="center" colspan="2">Operazioni</td>
			</tr>
<?php
		$contatore = 1;
		while ($elencoAtleti_row = dbms_fetch_array($elencoAtleti)) {
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$contatore."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoAtleti_row["COGNOME"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoAtleti_row["NOME"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["SESSO"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["DATA_NASCITA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["DATA_TESSERAMENTO"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["CODICE_FIDAL"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["DATA_SCADENZA_CERTIFICATO_MEDICO"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='AtletaView.php?operazione=modifica&idAtleta=".$elencoAtleti_row["ID"]."'>modifica</a></td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='AtletaView.php?operazione=cancella&idAtleta=".$elencoAtleti_row["ID"]."'>cancella</a></td>";
			print "</tr>";
			$contatore++;
		}
?>			
		</table>
		
	</body>
</html>