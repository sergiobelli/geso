<?php
	require_once("Header.php");
	require_once("CertificatoMedicoManager.php");
	require_once("AtletaManager.php");
	require_once("util/DiffUtil.php");
	require_once("util/Mailer.php");
	
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
	$AtletaManager = new AtletaManager();
		
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
	} else if (isset($_GET['operazione']) && $_GET['operazione'] == 'inviaAvviso') {
		$idAtleta = $_GET['idAtleta'];
		$mailer = new Mailer();
		$atleta = $AtletaManager->get($idAtleta);
		while ($atleta_row = dbms_fetch_array($atleta)) {
			$mailer->sendMailAvvisoAtleta($atleta_row["NOME"], $atleta_row["COGNOME"], $atleta_row["EMAIL"], 0);
		}
		$idCertificatoMedico = null;
		$idAtleta = null;
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
		
		<link type="text/css" href="css/redmond/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />
		
		<style>
            input.error {
                border-color: red;           
            }
            label.error {
            	color: white;
                font-weight:bold;
            }
        </style>
		
		<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.20.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-i18n.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script>
		<script type="text/javascript" src="js/jquery.validate.js"></script>
		
		<script type="text/javascript">

			$(function(){
				$( "#salva" ).button();
			});
			$(function(){
				$( "#cancella" ).button();
			});
			
			$(function(){
				$( "#agonistico" ).buttonset();
			});
			
			//datepicker -> dataScadenza
			$(function() {
               $.datepicker.setDefaults($.datepicker.regional['it']);
               $( "#dataScadenza" ).datepicker({
					showOn: "button",
					buttonImage: "images/calendar.gif",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: "1999:2100"
				});
			});
			
			$(function() {
		
                $( "#atleta" ).autocomplete({
                    source: "controller/elencoAtletiEffettivi.php",
					select: function(event, ui){
                        $("#idAtleta").val(ui.item.idAtleta);
                    }
                });
            });
			//validazione form
            $(function(){
              
                $("#modulo_certificato").validate({
                    rules: {
                        atleta:{ required: true },
                        dataScadenza:{ required: true, date: true },
                        agonistico: { required: true }
                    },
                    messages:{                    	
						atleta:{ 
                        	required: "Specificare l'atleta!" 
                        },
                        dataScadenza:{ 
                        	required: "La data scadenza e' obbligatoria!",
                        	date: "Il formato della data scadenza non e' valido!" 
                        },
                        agonistico:{ 
                        	required: "Specificare se il certificato e' di tipo agonistico o meno!" 
                        }
                    },
                    
                    submitHandler: function(form) { 
                        //alert('I dati sono stati inseriti correttamente');
                        form.submit();
                    },

                    invalidHandler: function() { 
                        $( "#dialogKo" ).dialog("open");
                    }	

                })
            })
		</script>
	
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
		<form id="modulo_certificato" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
				<tr>
					<td class="FacetFormHeaderFont">Atleta</td>
					<td align="right">
						
						<input type="text" id="atleta" name="atleta" />
						<input type="hidden" id="idAtleta" name="idAtleta" />
						
						<!--
						<select name="idAtleta">
							<option> </option>
<?php
							/*
							$elencoAtleti = AtletaManager::lista();
							while ($elencoAtleti_row = dbms_fetch_array($elencoAtleti)) {
								if ($elencoAtleti_row["ID"] == $idAtleta) {
									print( "<option selected value='".$elencoAtleti_row["ID"]."'>".$elencoAtleti_row["COGNOME"]." ".$elencoAtleti_row["NOME"]."</option>" );
								} else {
									print( "<option value='".$elencoAtleti_row["ID"]."'>".$elencoAtleti_row["COGNOME"]." ".$elencoAtleti_row["NOME"]."</option>" );
								}
							}
							*/
?>
						</select>
						-->
					</td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Data Scadenza</td>
					<td align="right"><input type="text" id="dataScadenza" name="dataScadenza" maxlength="10" size="11" value="<?php echo $dataScadenza ?>"/></td>
				</tr>				
				<tr>
					<td class="FacetFormHeaderFont">Agonistico</td>
					<td class="FacetFormHeaderFont">
						<div id="agonistico" align="right">
							<input type="radio" id="agonisticoSI" name="agonistico" value="S" <?php $agonistico == 'S' ? print 'checked="checked" '  : '' ?> /><label for="agonisticoSI">Si</label>
							<input type="radio" id="agonisticoNO" name="agonistico" value="N" <?php $agonistico == 'N' || $agonistico == '' ? print 'checked="checked" '  : '' ?> /><label for="agonisticoNO">No</label>
						</div>
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
			
			$DiffUtil = new DiffUtil();
			$diffDate = $DiffUtil->fDateDiff(date("Y-m-d"), $dataScadenzaCertificato);
			
			print "<tr>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$contatore."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoCertificatiMedici_row["cognome_atleta"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"left\">".$elencoCertificatiMedici_row["nome_atleta"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoCertificatiMedici_row["sesso_atleta"]."</td>";
			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoCertificatiMedici_row["data_nascita_atleta"]." &nbsp;</td>";
			
			if ($diffDate >= 90) {
				print "<td class=\"FacetDataTDGreen\" align=\"center\">".$dataScadenzaCertificato." &nbsp; (".$diffDate.")</font></td>";
			} else if ($diffDate < 90 && $diffDate >= 30) {
				print "<td class=\"FacetDataTDOrange\" align=\"center\">".$dataScadenzaCertificato." &nbsp; (".$diffDate.")</font></td>";
			} else if ($diffDate < 30) {
				print "<td class=\"FacetDataTDRed\" align=\"center\">".$dataScadenzaCertificato." &nbsp; (".$diffDate.")</font></td>";
			} else {
				print "<td class=\"FacetDataTD\" align=\"center\">".$dataScadenzaCertificato." &nbsp; (".$diffDate.")</font></td>";
			}
			

			print "<td class=\"FacetDataTD\" align=\"center\">".$elencoCertificatiMedici_row["agonistico"]." &nbsp;</td>";
			$operazioni = "<td class=\"FacetDataTD\" align=\"center\">";
			$operazioni = $operazioni."<a href='CertificatoMedicoView.php?operazione=cancella&idCertificatoMedico=".$elencoCertificatiMedici_row["id_certificato_medico"]."'>cancella</a>";
			if ($diffDate < 30) {
				$operazioni = 
					$operazioni." <a href='CertificatoMedicoView.php?operazione=inviaAvviso&idAtleta=".$elencoCertificatiMedici_row["id_atleta"]."&idCertificatoMedico=".$elencoCertificatiMedici_row["id_certificato_medico"]."'>avviso</a>";
			}
			$operazioni = $operazioni."</td>"; 
			print $operazioni;
			print "</tr>";
			$contatore++;
		}		
?>			
		</table>
		
	</body>
</html>