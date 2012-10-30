<?php
	require_once("Header.php");
	require_once("GaraManager.php");
	require_once("StagioneManager.php");
	require_once("TipologiaGaraManager.php");

	
	global $operazione;
	$operazione = '';
	
	global $gara;
	
	global $idGara, $nome, $localita, $campionato, $data, $nostra, $idStagione, $idTipologiaGara;
	$idGara = '';
	$nome = '';
	$localita = '';
	$campionato = '';
	$nostra = '';
	$data = '';
	$nostra = '';
	$idStagione = '';
	$idTipologiaGara = '';
	
	// inizializzazione della sessione
	//session_start();
	// se la sessione di autenticazione
	// è già impostata non sarà necessario effettuare il login
	// e il browser verrà reindirizzato alla pagina di scrittura dei post
	if (!isset($_SESSION['login'])) {
		// reindirizzamento alla homepage in caso di login mancato
		header("Location: index.php");
	}
	
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
			$idStagione = $gara_row["ID_STAGIONE"];
			$idTipologiaGara = $gara_row["ID_TIPOLOGIA_GARA"];
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
		} elseif( !isset($_POST['stagione']) || $_POST['stagione'] =="") {
			echo "Attenzione, inserire la stagione.";
		} else {
			// validazione dei parametri tramite filtro per le stringhe
			
			$idGara = trim($_POST['idGara']);
			$nome = trim($_POST['nome']);
			$localita = trim($_POST['localita']);
			$campionato = trim($_POST['campionato']);
			$data = trim($_POST['data']);
			$nostra = trim($_POST['nostra']);
			$stagione = trim($_POST['stagione']);
			$tipologiaGara = trim($_POST['tipologiaGara']);
			
			/*
			$idGara = trim(filter_var($_POST['idGara'], FILTER_SANITIZE_STRING));
			$nome = trim(filter_var($_POST['nome'], FILTER_SANITIZE_STRING));
			$localita = trim(filter_var($_POST['localita'], FILTER_SANITIZE_STRING));
			$campionato = trim(filter_var($_POST['campionato'], FILTER_SANITIZE_STRING));
			$data = trim(filter_var($_POST['data'], FILTER_SANITIZE_STRING));
			*/
			
			if (isset($idGara) && $idGara != '') {
				GaraManager::modifica($idGara, $nome, $localita, $campionato, $nostra, $data, $stagione, $tipologiaGara);
				$idGara = null;
				$operazione = null;
				$nome = null;
				$localita = null;
				$campionato = null;
				$nostra = null;
				$data = null;
				$stagione = null;
				$tipologiaGara = null;
			} else {
				GaraManager::inserisci($nome, $localita, $campionato, $nostra, $data, $stagione, $tipologiaGara);			
				$idGara = null;
				$operazione = null;
				$nome = null;
				$localita = null;
				$campionato = null;
				$nostra = null;
				$data = null;
				$stagione = null;
				$tipologiaGara = null;								
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
					<td class="FacetFormHeaderFont">Nome</td>
					<td align="center">
						<input type="hidden" id="idGara" name="idGara" value="<?php echo $idGara ?>" />
						<input type="text" id="nome" name="nome" value="<?php echo $nome ?>" />
					</td>
				</tr>				
				<tr>
					<td class="FacetFormHeaderFont">Localita'</td>
					<td align="center"><input type="text" id="localita" name="localita" value="<?php echo $localita ?>" /></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Campionato</td>
					<td align="center"><input type="text" id="campionato" name="campionato" value="<?php echo $campionato ?>" /></td>
				</tr>			
				<tr>
					<td class="FacetFormHeaderFont">Nostra</td>
					<td class="FacetFormHeaderFont">
						<input type="radio" id="nostra" name="nostra" value="S" <?php $nostra == 'S' ? print 'checked="checked" '  : '' ?> /> Si
						<br/>
						<input type="radio" id="nostra" name="nostra" value="N" <?php $nostra == 'N' || $nostra == '' ? print 'checked="checked" '  : '' ?> /> No
					</td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Data</td>
					<td align="center"><input type="text" id="data" name="data" value="<?php echo $data ?>" /></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Stagione</td>
					<td align="right">
						<select name="stagione">
<?php
							$StagioneManager = new StagioneManager();
							$elencoStagioni = StagioneManager::lista();
							while ($elencoStagioni_row = dbms_fetch_array($elencoStagioni)) {
								if ($elencoStagioni_row["ID"] == $idStagione) {
									print( "<option selected value='".$elencoStagioni_row["ID"]."'>".$elencoStagioni_row["ANNO"]."</option>" );
								} else {
									print( "<option value='".$elencoStagioni_row["ID"]."'>".$elencoStagioni_row["ANNO"]."</option>" );
								}
							}
?>
						</select>							
					</td>
				</tr>	
				<tr>
					<td class="FacetFormHeaderFont">Tipologia Gara</td>
					<td align="right">
						<select name="tipologiaGara">
<?php
							$TipologiaGaraManager = new TipologiaGaraManager();
							$elencoTipologieGare = TipologiaGaraManager::lista();
							while ($elencoTipologieGare_row = dbms_fetch_array($elencoTipologieGare)) {
								if ($elencoTipologieGare_row["ID"] == $idTipologiaGara) {
									print( "<option selected value='".$elencoTipologieGare_row["ID"]."'>".$elencoTipologieGare_row["TIPO"]."</option>" );
								} else {
									print( "<option value='".$elencoTipologieGare_row["ID"]."'>".$elencoTipologieGare_row["TIPO"]."</option>" );
								}
							}
?>
						</select>							
					</td>
				</tr>							
				<tr>
					<td class="FacetFormHeaderFont">&nbsp;</td>
					<td align="right">
						<input class="FacetButton" type="button" id="cancella" name="cancella" value="cancella" />
						<input class="FacetButton" type="submit" id="salva" name="submit" value="salva" />
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
				<td class="FacetFormHeaderFont">#</td>
				<td class="FacetFormHeaderFont">Codice</td>
				<td class="FacetFormHeaderFont">Nome</td>
				<td class="FacetFormHeaderFont">Localita'</td>
				<td class="FacetFormHeaderFont">Campionato</td>
				<td class="FacetFormHeaderFont">Tipologia</td>				
				<td class="FacetFormHeaderFont">Nostra</td>
				<td class="FacetFormHeaderFont">Data</td>
				<td class="FacetFormHeaderFont">Stagione</td>
				<td class="FacetFormHeaderFont" colspan="2">Operazioni</td>
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
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["TIPOLOGIA_GARA"]." (".$elencoGare_row["PUNTEGGIO"]." punti)</td>";			
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoGare_row["NOSTRA"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoGare_row["DATA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoGare_row["STAGIONE"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='GaraView.php?operazione=modifica&idGara=".$elencoGare_row["ID"]."'>modifica</a></td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='GaraView.php?operazione=cancella&idGara=".$elencoGare_row["ID"]."'>cancella</a></td>";
			print "</tr>";
			$contatore++;
		}
?>			
		</table>
	</body>
</html>