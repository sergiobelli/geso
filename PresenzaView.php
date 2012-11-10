<?php
	require_once("Header.php");
	require_once("PresenzaManager.php");
	require_once("AtletaManager.php");
	require_once("GaraManager.php");
	require_once("StagioneManager.php");

	global $operazione;
	$operazione = '';
	
	global $presenza;
	
	global $idPresenza, $idAtleta, $idGara, $idStagione;
	$idPresenza = '';
	$idAtleta = '';
	$idGara = '';
	$idStagione = '';
		
	// inizializzazione della sessione
	//session_start();
	// se la sessione di autenticazione
	// è già impostata non sarà necessario effettuare il login
	// e il browser verrà reindirizzato alla pagina di scrittura dei post
	if (!isset($_SESSION['login'])) {
		// reindirizzamento alla homepage in caso di login mancato
		header("Location: index.php");
	}

	$PresenzaManager = new PresenzaManager();
	
	if (isset($_GET['operazione']) && $_GET['operazione'] == 'modifica') {
		$operazione = 'modifica';
		$presenza = PresenzaManager::get($_GET['idPresenza']);
		while ($presenza_row = dbms_fetch_array($presenza)) {
			$idPresenza = $presenza_row["ID"];
			$idAtleta = $presenza_row["ID_ATLETA"];
			$idGara = $presenza_row["ID_GARA"];
			$idStagione = $presenza_row["ID_STAGIONE"];
		}
	} else if (isset($_GET['operazione']) && $_GET['operazione'] == 'cancella') {
		$operazione = 'cancella';
		PresenzaManager::cancella($_GET['idPresenza']);
						$idPresenza = null;
				$operazione = null;

	} else {
		$operazione = 'inserisci';
	}
	
	// controllo sul parametro d'invio
	if(isset($_POST['submit']) && (trim($_POST['submit']) == "salva")) {
		if( !isset($_POST['atleta']) || $_POST['atleta']=="" ){
			echo "Attenzione, inserire l'atleta.";
		} elseif( !isset($_POST['gara']) || $_POST['gara'] =="") {
			echo "Attenzione, inserire la gara.";
		//} elseif( !isset($_POST['stagione']) || $_POST['stagione'] =="") {
		//	echo "Attenzione, inserire la stagione.";
		} else {
			// validazione dei parametri tramite filtro per le stringhe
			$idPresenza = trim($_POST['idPresenza']);
			$atleta = trim($_POST['atleta']);
			$gara = trim($_POST['gara']);
			$stagione = trim($_POST['stagione']);

			/*
			$idPresenza = trim(filter_var($_POST['idPresenza'], FILTER_SANITIZE_STRING));
			$atleta = trim(filter_var($_POST['atleta'], FILTER_SANITIZE_STRING));
			$gara = trim(filter_var($_POST['gara'], FILTER_SANITIZE_STRING));
			$stagione = trim(filter_var($_POST['stagione'], FILTER_SANITIZE_STRING));
			*/
			
			if (isset($idPresenza) && $idPresenza != '') {
				PresenzaManager::modifica($idPresenza, $atleta, $gara, $_SESSION['stagione']);
				$idPresenza = null;
				$operazione = null;
			} else {
				PresenzaManager::inserisci($atleta, $gara, $_SESSION['stagione']);
				$idPresenza = null;
				$operazione = null;
			}
		}	
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Presenze</title><link rel="stylesheet" type="text/css" href="stylesheet.css">
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
	
		<div align="center">Inserimento/Modifica Presenza</div>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
				<tr>
					<td class="FacetFormHeaderFont">Atleta</td>
					<td align="right">
						<input type="hidden" id="idPresenza" name="idPresenza" value="<?php echo $idPresenza ?>" />
						<select name="atleta">
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
					<td class="FacetFormHeaderFont">Gara</td>
					<td align="right">
						<select name="gara">
							<option> </option>
<?php
							$GaraManager = new GaraManager();
							$elencoGare = GaraManager::listaByLocalita($_SESSION['stagione']);
							while ($elencoGare_row = dbms_fetch_array($elencoGare)) {
								if ($elencoGare_row["ID"] == $idGara) {
									print( 
										"<option selected value='".
											$elencoGare_row["ID"]."'>".
											$elencoGare_row["LOCALITA"]." - ".
											$elencoGare_row["NOME"].
											" (".$elencoGare_row["DATA"].")".
										"</option>" );
								} else {
									print( "<option value='".
										$elencoGare_row["ID"]."'>".
										$elencoGare_row["LOCALITA"]." - ".
										$elencoGare_row["NOME"].
										" (".$elencoGare_row["DATA"].")".
									"</option>" );
								}
							}
?>
						</select>						
					</td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Stagione</td>
					<td align="right">
						<select name="stagione" disabled="disabled">
<?php
							$StagioneManager = new StagioneManager();
							$elencoStagioni = StagioneManager::lista();
							while ($elencoStagioni_row = dbms_fetch_array($elencoStagioni)) {
								if ($elencoStagioni_row["ID"] == $_SESSION['stagione']) {
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
					<td align="center">&nbsp;</td>
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
			Elenco Presenze
		</div>
<?php
$PresenzaManager = new PresenzaManager();

?>		
		<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
			<tr>
				<td class="FacetFormHeaderFont">#</td>
				<td class="FacetFormHeaderFont">Atleta</td>
				<td class="FacetFormHeaderFont">Gara</td>
				<td class="FacetFormHeaderFont">Data Gara</td>
				<td class="FacetFormHeaderFont">Stagione</td>
				<td class="FacetFormHeaderFont" colspan="2">Operazioni</td>
			</tr>
<?php

                $elencoPresenze = PresenzaManager::lista($_SESSION['stagione']);
		while ($elencoPresenze_row = dbms_fetch_array($elencoPresenze)) {
			$contatore++;
		}

                $elencoPresenze = PresenzaManager::lista($_SESSION['stagione']);
		while ($elencoPresenze_row = dbms_fetch_array($elencoPresenze)) {
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$contatore."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoPresenze_row["COGNOME_ATLETA"]."&nbsp;".$elencoPresenze_row["NOME_ATLETA"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoPresenze_row["LOCALITA_GARA"]." - ".$elencoPresenze_row["NOME_GARA"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoPresenze_row["DATA_GARA"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoPresenze_row["ANNO"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='PresenzaView.php?operazione=modifica&idPresenza=".$elencoPresenze_row["ID"]."'>modifica</a></td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='PresenzaView.php?operazione=cancella&idPresenza=".$elencoPresenze_row["ID"]."'>cancella</a></td>";
			print "</tr>";
			$contatore--;
		}
?>			
		</table>
	</body>
</html>