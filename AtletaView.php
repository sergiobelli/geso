<?php
	require_once("Header.php");
	require_once("AtletaManager.php");
	require_once("CategoriaManager.php");
	require_once("util/DiffUtil.php");
		
	global $operazione;
	$operazione = '';
	
	global $atleta;
	
	global $idAtleta, $cognome, $nome, $sesso, $dataNascita, 
		$dataTesseramento, $codiceFidal, $comuneResidenza, $provinciaResidenza, 
		$indirizzoResidenza, $telefono, $cellulare, $email, $taglia, $consensoTrattamentoDati;
		
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
	} else if (isset($_GET['operazione']) && $_GET['operazione'] == 'ritira') {
		$operazione = 'ritira';
		$result = AtletaManager::ritira($_GET['idAtleta']);
		//if ($result == '-1') {
		//	$message = "Ci sono presenze legate all'atleta che si sta cancellando, provvedere prima a rimuovere tali informazioni!";
		//} else {
			$idAtleta = null;
			$operazione = null;
		//}
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
			} else {
				AtletaManager::inserisci(
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
		<title>Atleti</title>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">

      <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.20.custom.css" rel="stylesheet" />
      <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
      <script type="text/javascript" src="js/jquery-ui-1.8.20.custom.min.js"></script>
      <script type="text/javascript" src="js/jquery-ui-i18n.js"></script>
      <script type="text/javascript" src="js/jquery.form.js"></script>
      <script type="text/javascript" src="js/jquery.validate.js"></script>
	  
      
		<script type="text/javascript">
			
			//datepicker -> dataNascita
			$(function() {
			   $.datepicker.setDefaults($.datepicker.regional['it']);
			   $( "#dataNascita" ).datepicker();
			});
			
			//datepicker -> dataTesseramento
			$(function() {
			   $.datepicker.setDefaults($.datepicker.regional['it']);
			   $( "#dataTesseramento" ).datepicker();
			});

			//validazione form
            $(function(){
              
                $("#modulo_atleta").validate({
                    rules: {
                        cognome:{ minlength:2, required: true },
                        nome:{ minlength:2, required: true },
                        sesso:{ required: true },
                        dataNascita:{ required: true, date: true },
                        dataTesseramento:{ date: true },
                        codiceFidal: { minlength:8 },
                        email: "email"
                    },
                    messages:{                    	
                        cognome:{ 
                        	minlength:"Il cognome deve essere lungo almeno 2 caratteri",
                        	required: "Il cognome e' obbligatorio!" 
                        },
                        nome:{ 
                        	minlength:"Il nome deve essere lungo almeno 2 caratteri",
                        	required: "Il nome e' obbligatorio!" 
                        },
                        sesso:{ required: "Il sesso e' obbligatorio!" },
                        dataNascita:{ 
                        	required: "La data di nascita e' obbligatoria!",
                        	date: "Il formato della data di nascita non e' valido!" 
                        },
                        dataTesseramento:{ 
                        	date: "Il formato della data di tesseramento non e' valido!" 
                        },
                        codiceFidal: { minlength:"Il codice fidal deve essere lungo almeno 8 caratteri!" },
                        email: "Non hai inserito una e-mail valida!" 
                    },
                    
                    submitHandler: function(form) { 
                        alert('I dati sono stati inseriti correttamente');
                        form.submit();
                    },

                    invalidHandler: function() { 
                        alert('I dati inseriti non sono corretti, ricontrollali....');
                    }
                })
            })
			
			//autocompletamento -> provinciaResidenza
			$(function() {
				var arrReg = new Array();
				$.ajax({
					type: "GET",
					url: "controller/provincie.xml",
					dataType: "xml",
					success: parseXml,
					complete: attivaAutocomplete
				});

                function parseXml(xml){
                    $(xml).find("provincia").each(function()
                    {
                        arrReg.push($(this).attr("sigla"));
                    });
                }

                function attivaAutocomplete() {
                    $("#provinciaResidenza").autocomplete({
                        source: arrReg
                    });
                }
            });
          
        </script>

        <style>
            input.error {
                border-color: red;           
            }
            label.error {
            	color: white;
                font-weight:bold;
            }
        </style>
                		
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
		<form id="modulo_atleta" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
				<tr>
					<td class="FacetFormHeaderFont">Cognome</td>
					<td align="right">
						<input type="hidden" id="idAtleta" name="idAtleta" value="<?php echo $idAtleta ?>" />
						<input type="text" id="cognome" name="cognome" value="<?php echo $cognome ?>" />
					</td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Nome</td>
					<td align="right"><input type="text" id="nome" name="nome" value="<?php echo $nome ?>"/></td>
				</tr>	
				<tr>
					<td class="FacetFormHeaderFont">Sesso</td>
					<td class="FacetFormHeaderFont">
						<input type="radio" id="sesso" name="sesso" value="M" <?php $sesso == 'M' ? print 'checked="checked" '  : '' ?> /> M
						<input type="radio" id="sesso" name="sesso" value="F" <?php $sesso == 'F' ? print 'checked="checked" '  : '' ?> /> F
					</td>
				</tr
				<tr>
					<td class="FacetFormHeaderFont">Data di Nascita</td>
					<td align="right"><input type="text" id="dataNascita" name="dataNascita" value="<?php echo $dataNascita ?>"/></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Data di Tesseramento</td>
					<td align="right"><input type="text" id="dataTesseramento" name="dataTesseramento" value="<?php echo $dataTesseramento?>"/></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Codice Fidal</td>
					<td align="right"><input type="text" id="codiceFidal" name="codiceFidal" maxlength="8" size="10" value="<?php echo $codiceFidal?>"/></td>
				</tr>

				<tr>
					<td class="FacetFormHeaderFont">Comune di residenza</td>
					<td align="right"><input type="text" id="comuneResidenza" name="comuneResidenza" value="<?php echo ($comuneResidenza) ?>"/></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Provincia di residenza</td>
					<td align="right"><input type="text" id="provinciaResidenza" name="provinciaResidenza" maxlength="2" size="3" value="<?php echo ($provinciaResidenza) ?>"/></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Indirizzo di residenza</td>
					<td align="right"><input type="text" id="indirizzoResidenza" name="indirizzoResidenza" value="<?php echo ($indirizzoResidenza) ?>"/></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Telefono</td>
					<td align="right"><input type="text" id="telefono" name="telefono" maxlength="10" size="11" value="<?php echo ($telefono) ?>"/></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Cellulare</td>
					<td align="right"><input type="text" id="cellulare" name="cellulare" maxlength="10" size="11" value="<?php echo ($cellulare) ?>"/></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Email</td>
					<td align="right"><input type="text" id="email" name="email" value="<?php echo ($email) ?>"/></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Taglia</td>
					<td align="right"><input type="text" id="taglia" name="taglia" value="<?php echo ($taglia) ?>"/></td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Consenso al trattamento dei dati sensibili</td>
					<td class="FacetFormHeaderFont">
						<input type="radio" id="consensoTrattamentoDati" name="consensoTrattamentoDati" value="S" <?php $consensoTrattamentoDati == 'S' ? print 'checked="checked" '  : '' ?> /> Si
						<input type="radio" id="consensoTrattamentoDati" name="consensoTrattamentoDati" value="N" <?php $consensoTrattamentoDati == 'N' || $consensoTrattamentoDati == '' ? print 'checked="checked" '  : '' ?> /> No
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
		
		<div align="center">Elenco Atleti</div>
<?php		
		$elencoAtleti = AtletaManager::lista();
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
				<td class="FacetFormHeaderFont">C.T.D.S.</td>
				<td class="FacetFormHeaderFont" colspan="2">Operazioni</td>
			</tr>
<?php
		$contatore = 1;
		
		require_once("StagioneManager.php");
		$StagioneManager = new StagioneManager();
		$annoAttuale = StagioneManager::getDescrizioneStagione($_SESSION['stagione']);
		$DiffUtil = new DiffUtil();
		
		while ($elencoAtleti_row = dbms_fetch_array($elencoAtleti)) {
		
			$dataScadenzaCertificato = $elencoAtleti_row["DATA_SCADENZA_CERTIFICATO_MEDICO"];
			$sessoAtleta = $elencoAtleti_row["SESSO"];
			$dataNascitaAtleta = $elencoAtleti_row["DATA_NASCITA"];
			
			$diffDate = $DiffUtil->fDateDiff(date("Y-m-d"), $dataScadenzaCertificato);
			
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$contatore."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoAtleti_row["COGNOME"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoAtleti_row["NOME"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$sessoAtleta."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$dataNascitaAtleta." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["DATA_TESSERAMENTO"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["CODICE_FIDAL"]." &nbsp;</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".CategoriaManager::getByDataNascitaAndSesso($dataNascitaAtleta, $sessoAtleta, $annoAttuale)."</td>";
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
			if ($comRes != '' && $provRes != '') {
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
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoAtleti_row["CONSENSO_DATI_PERSONALI"]." &nbsp;</td>";
			
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='AtletaView.php?operazione=modifica&idAtleta=".$elencoAtleti_row["ID"]."'>modifica</a></td>";
			print "<td class=\"FacetDataTD\" align=\"center\"><a href='AtletaView.php?operazione=ritira&idAtleta=".$elencoAtleti_row["ID"]."'>ritira</a></td>";
			print "</tr>";
			$contatore++;
		}

?>			
		</table>
		
	</body>
</html>