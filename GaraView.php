
<?php
	require_once("Header.php");
	require_once("GaraManager.php");

	global $operazione;
	$operazione = '';
	
	global $gara;
	
	global $idGara, $nome, $localita, $campionato, $data, $nostra;
	$idGara = '';
	$nome = '';
	$localita = '';
	$campionato = '';
	$nostra = '';
	$data = '';
	
	// inizializzazione della sessione
	//session_start();
	// se la sessione di autenticazione
	// è già impostata non sarà necessario effettuare il login
	// e il browser verrà reindirizzato alla pagina di scrittura dei post
	//if (isset($_SESSION['login'])) {
	//	// reindirizzamento alla homepage in caso di login mancato
	//	header("Location: LoginView.php");
	//}
	
	$GaraManager = new GaraManager();	
	
	if (isset($_GET['operazione']) && $_GET['operazione'] == 'modifica') {
		$operazione = 'modifica';
		$gara = GaraManager::get($_GET['idGara']);
		while ($gara_row = dbms_fetch_array($gara)) {
			$idGara = $gara_row["ID"];
			$nome = $gara_row["NOME"];
			$localita = $gara_row["LOCALITA"];
			$campionato = $gara_row["CAMPIONATO"];
			$nostra = $gara_row["NOSTRA"];
			$data = $gara_row["DATA"];
		}		
	} else if (isset($_GET['operazione']) && $_GET['operazione'] == 'cancella') {
		$operazione = 'cancella';
		$result = GaraManager::cancella($_GET['idGara']);
		if ($result == '-1') {
			$message = "Ci sono presenze legate alla gara che si sta cancellando, provvedere prima a rimuovere tali informazioni!";
		} else {
			$idGara = null;
			$operazione = null;		
		}
	} else {
		$operazione = 'inserisci';
	}
	
	// controllo sul parametro d'invio
	if(isset($_POST['submit']) && (trim($_POST['submit']) == "salva")) {
		if( !isset($_POST['nome']) || $_POST['nome']=="" ){
			echo "Attenzione, inserire il nome.";
		} elseif( !isset($_POST['localita']) || $_POST['localita'] =="") {
			echo "Attenzione, inserire la localita'.";
		} elseif( !isset($_POST['data']) || $_POST['data'] =="") {
			echo "Attenzione, inserire la data.";
		} elseif( !isset($_POST['campionato']) || $_POST['campionato'] =="") {
			echo "Attenzione, inserire i campionato.";
		} else {
			// validazione dei parametri tramite filtro per le stringhe
			
			$idGara = trim($_POST['idGara']);
			$nome = trim($_POST['nome']);
			$localita = trim($_POST['localita']);
			$campionato = trim($_POST['campionato']);
			$data = trim($_POST['data']);
			$nostra = trim($_POST['nostra']);
			
			/*
			$idGara = trim(filter_var($_POST['idGara'], FILTER_SANITIZE_STRING));
			$nome = trim(filter_var($_POST['nome'], FILTER_SANITIZE_STRING));
			$localita = trim(filter_var($_POST['localita'], FILTER_SANITIZE_STRING));
			$campionato = trim(filter_var($_POST['campionato'], FILTER_SANITIZE_STRING));
			$data = trim(filter_var($_POST['data'], FILTER_SANITIZE_STRING));
			*/
			
			if (isset($idGara) && $idGara != '') {
				GaraManager::modifica($idGara, $nome, $localita, $campionato, $nostra, $data);
				$idGara = null;
				$operazione = null;				
			} else {
				GaraManager::inserisci($nome, $localita, $campionato, $nostra, $data);			
				$idGara = null;
				$operazione = null;				
			}
					
		}	
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Gare</title><link rel="stylesheet" type="text/css" href="stylesheet.css">
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
		
		<div align="center">Inserimento/Modifica Gara</div>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
				<tr>
					<td align="center">Nome</td>
					<td align="center">
						<input type="hidden" id="idGara" name="idGara" value="<?php echo $idGara ?>" />
						<input type="text" id="nome" name="nome" value="<?php echo $nome ?>" />
					</td>
				</tr>				
				<tr>
					<td align="center">Localita'</td>
					<td align="center"><input type="text" id="localita" name="localita" value="<?php echo $localita ?>" /></td>
				</tr>
				<tr>
					<td align="center">Campionato</td>
					<td align="center"><input type="text" id="campionato" name="campionato" value="<?php echo $campionato ?>" /></td>
				</tr>				
				<tr>
					<td align="center">Nostra</td>
					<td align="center">
						<input type="radio" id="nostra" name="nostra" value="S" <?php $nostra == 'S' ? 'checked' : '' ?> /> Si
						<br/>
						<input type="radio" id="nostra" name="nostra" value="N" <?php $nostra != 'S' ? 'checked' : '' ?> /> No
					</td>
				</tr>
				<tr>
					<td align="center">Data</td>
					<td align="center"><input type="text" id="data" name="data" value="<?php echo $data ?>" /></td>
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
		
	
		<div align="center">
			Elenco Gare
		</div>
<?php
		$elencoGare = GaraManager::lista();
?>		
		<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
			<tr>
				<td align="center">#</td>
				<td align="center">Codice</td>
				<td align="center">Nome</td>
				<td align="center">Localita'</td>
				<td align="center">Campionato</td>
				<td align="center">Nostra</td>
				<td align="center">Data</td>
				<td align="center" colspan="2">Operazioni</td>
			</tr>
<?php
		$contatore = 1;
		while ($elencoGare_row = dbms_fetch_array($elencoGare)) {
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$contatore."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["CODICE"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["NOME"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["LOCALITA"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["CAMPIONATO"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["NOSTRA"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoGare_row["DATA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='GaraView.php?operazione=modifica&idGara=".$elencoGare_row["ID"]."'>modifica</a></td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='GaraView.php?operazione=cancella&idGara=".$elencoGare_row["ID"]."'>cancella</a></td>";
			print "</tr>";
			$contatore++;
		}
?>			
		</table>
	</body>
</html>

