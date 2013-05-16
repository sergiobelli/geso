<?php
	
	require_once("StagioneManager.php");
	require_once("AccessiManager.php");

	global $nome, $cognome, $sesso, $dataNascita, $luogoNascita, $indirizzoResidenza, $cittaResidenza, $provinciaResidenza, $numeroTelefono, $email, $codiceFidal, $message;
	
	$StagioneManager = new StagioneManager();
	if (isset($_GET['idStagione'])) {
		$stagione = $_GET['idStagione'];
	} else if (isset($_SESSION['stagione'])) {
		$stagione = $_SESSION['stagione'];
	} else {
		$stagione = $StagioneManager::getUltimaStagione();
	}
	$descrizioneStagione = $StagioneManager::getDescrizioneStagione($stagione);
	$AccessiManager = new AccessiManager();
	if (isset($_SESSION['username'])) {
		AccessiManager::inserisci(
			$_SESSION['username'], 
			$_SERVER['REMOTE_ADDR'], 
			gethostbyaddr($_SERVER['REMOTE_ADDR']), 
			$_SERVER['REQUEST_URI'], 
			'VISITA');
	} else {
		AccessiManager::inserisci(
			'guest', 
			$_SERVER['REMOTE_ADDR'], 
			gethostbyaddr($_SERVER['REMOTE_ADDR']), 
			$_SERVER['REQUEST_URI'], 
			'VISITA');	
	}

	function inserisci ($nome, $cognome, $sesso, $dataNascita, $luogoNascita, $indirizzoResidenza, $cittaResidenza, $provinciaResidenza, $numeroTelefono, $email, $codiceFidal) {
	
		include "funzioni_mysql.php";
		
		list($d, $m, $y) = explode('/', $dataNascita);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		$dataNascita=strftime('%Y-%m-%d',$mk);
		
		$t = "iscrizioni_societa"; # nome della tabella
		$v = array (
			$nome, $cognome, $sesso, $dataNascita, $luogoNascita, $indirizzoResidenza, 
			$cittaResidenza, $provinciaResidenza, $numeroTelefono, $email, $codiceFidal, date("Y-m-d H:i:s")); # valori da inserire
		
		$r =  "nome, cognome, sesso, data_nascita, luogo_nascita, indirizzo_residenza, 
			comune_residenza, provincia_residenza, numero_telefono, email, codice_fidal, data_inserimento"; # campi da popolare
		
		$data = new MysqlClass();
		$data->connetti();
		$data->inserisci($t,$v,$r);
		$data->disconnetti();
	}
	
	// controllo sul parametro d'invio
	if(isset($_POST['submit']) && (trim($_POST['submit']) == "invia")) {
		$nome = $_POST['nome'];
		$cognome = $_POST['cognome'];
		$sesso = $_POST['sesso'];
		$dataNascita = $_POST['dataNascita'];
		$luogoNascita = $_POST['luogoNascita'];
		$indirizzoResidenza = $_POST['indirizzoResidenza'];
		$cittaResidenza = $_POST['cittaResidenza'];
		$provinciaResidenza = $_POST['provinciaResidenza'];
		$numeroTelefono = $_POST['numeroTelefono'];
		$email = $_POST['email'];
                $codiceFidal= $_POST['codiceFidal'];
 
		/*
		
		CONTROLLI IMPLEMENTATI MEDIANTE JQUERY
		
		if(!isset($nome) || $nome=="" ){
			$message = "Attenzione, inserire il nome.";
		} 
		
		elseif( !isset($cognome) || $cognome =="") {
			$message = "Attenzione, inserire il cognome.";
		} 
		
		elseif( !isset($sesso) || $sesso == "" 
				|| ($sesso != "" && strtoupper($sesso) != 'M' && strtoupper($sesso) != 'F')) {
			$message = "Attenzione, inserire il sesso.";
		} 
		
		elseif( !isset($dataNascita) || $dataNascita =="") {
			$message = "Attenzione, inserire la data di nascita.";
		} 
		
		elseif( !isset($luogoNascita) || $luogoNascita =="") {
			$message = "Attenzione, inserire il luogo di nascita.";
		} 
		
		elseif( !isset($indirizzoResidenza) || $indirizzoResidenza =="") {
			$message = "Attenzione, inserire l'indirizzo di residenza.";
		} 
		
		elseif( !isset($cittaResidenza) || $cittaResidenza =="") {
			$message = "Attenzione, inserire la citta' di residenza.";
		} 
		
		elseif( !isset($provinciaResidenza) || $provinciaResidenza =="") {
			$message = "Attenzione, inserire la provincia di residenza.";
		} 
		elseif( !isset($numeroTelefono) || $numeroTelefono =="") {
			$message = "Attenzione, inserire il numero di telefono.";
		} 
		elseif( !isset($email) || $email =="") {
			$message = "Attenzione, inserire l'email.";
		} 
		
		
		else {
			
		CONTROLLI IMPLEMENTATI MEDIANTE JQUERY
		*/
		
			//registrare su tabella
			try {
				inserisci($nome, $cognome, $sesso, $dataNascita, $luogoNascita, $indirizzoResidenza, $cittaResidenza, $provinciaResidenza, $numeroTelefono, $email, $codiceFidal);
			} catch(Exception $e) {
				$message =  'Message: ' .$e->getMessage();
			}
			
			//mandare mail ad atletica valsesia
			ini_set("SMTP", "mail.atleticavalsesia.it" );
			ini_set("sendmail_from", "info@atleticavalsesia.it");
			ini_set("smtp_port","25");
			ini_set("auth_username","atleticavalsesia.it");
			ini_set("auth_password","eivaloex");
			
			try {
				$object = "Nuova Iscrizione a societa'";
				$mailMessage = "Ciao, \nla societa' ha appena ricevuto una richiesta d'iscrizione, ecco di seguito i dati della persona \nNome = ".$nome.
					"\nCognome = ".$cognome.
					"\nData di nascita = ".$dataNascita.
					"\nLuogo di nascita = ".$luogoNascita.
					"\nIndirizzo di residenza = ".$indirizzoResidenza.
					"\nCitta' di residenza = ".$cittaResidenza.
					"\nProvincia di residenza = ".$provinciaResidenza.
					"\nNumero di telefono = ".$numeroTelefono.
					"\nEmail = ".$email.
                                        "\nCodice Fidal = ".$codiceFidal;
				mail("sergiobelli81@gmail.com, sergio.belli@email.it, danilo.belli@email.it, atleticavalsesia@libero.it, info@atleticavalsesia.it", $object, $mailMessage);
			} catch(Exception $e) {
				$message =  'Message: ' .$e->getMessage();
			}
			//mandare mail ad utente
			if (isset($email) && $email != '') {
				try {
					$object = "Iscrizione ad Atletica Valsesia";
					$mailMessage = "Ciao ".$nome.", \ngrazie per aver correttamente completato il form di iscrizione alla nostra societa'.\nEcco di seguito i dati da te inseriti \nNome = ".$nome.
						"\nCognome = ".$cognome.
						"\nData di nascita = ".$dataNascita.
						"\nLuogo di nascita = ".$luogoNascita.
						"\nIndirizzo di residenza = ".$indirizzoResidenza.
						"\nCitta' di residenza = ".$cittaResidenza.
						"\nProvincia di residenza = ".$provinciaResidenza.
						"\nNumero di telefono = ".$numeroTelefono.
						"\nEmail = ".$email.
                                                "\nCodice Fidal = ".$codiceFidal.
						"\r\n\r\n\r\nVerrai contattato prontamente da un dirigente della societa'. \n\nCordiali saluti.\nAtletica Valsesia";
					mail($_POST['email'], $object, $mailMessage);
					$message = "Ciao ".$nome.",<br />&nbsp;&nbsp;&nbsp;&nbsp;grazie per aver correttamente completato il form di iscrizione alla nostra societa'.<br />Ecco di seguito i dati da te inseriti <br />Nome = ".$nome.
						"<br />Cognome = ".$cognome.
						"<br />Data di nascita = ".$dataNascita.
						"<br />Luogo di nascita = ".$luogoNascita.
						"<br />Indirizzo di residenza = ".$indirizzoResidenza.
						"<br />Citta' di residenza = ".$cittaResidenza.
						"<br />Provincia di residenza = ".$provinciaResidenza.
						"<br />Numero di telefono = ".$numeroTelefono.
						"<br />Email = ".$email.
                                                "<br />Codice Fidal = ".$codiceFidal.
						"<br /><br /><br />Verrai contattato prontamente da un dirigente della societa'. <br /><br />Cordiali saluti.<br />Atletica Valsesia";
				} catch(Exception $e) {
					$message =  'Message: ' .$e->getMessage();
				}
			}
		//}CONTROLLI IMPLEMENTATI MEDIANTE JQUERY
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Modulo di richiesta iscrizione</title>

		<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
		<!--<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.20.custom.css" rel="stylesheet" />-->
		<link type="text/css" href="css/redmond/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />
		
		<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.20.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-i18n.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script>
		<script type="text/javascript" src="js/jquery.validate.js"></script>
		<script type="text/javascript" src="js/jquery.validationEngine-it.js"></script>
		<script type="text/javascript" src="js/jquery.ui.datepicker-it.js"></script>
		
		<script type="text/javascript">
			
			//datepicker -> dataNascita
			$(function() {
				$.datepicker.setDefaults($.datepicker.regional['it']);
				$( "#dataNascita" ).datepicker({
					showOn: "button",
					buttonImage: "images/calendar.gif",
					buttonImageOnly: true,
					changeMonth: true,
					changeYear: true,
					yearRange: "1900:2100"
				});
			});

			//validazione form
			$(function(){
			  
				$("#modulo").validate({
					rules: {
						cognome:{ minlength:2, required: true },
						nome:{ minlength:2, required: true },
						sesso:{ required: true },
						dataNascita:{ required: true, date: true },
						luogoNascita:{ minlength:2, required: true },
						indirizzoResidenza:{ minlength:2, required: true },
						cittaResidenza:{ minlength:2, required: true },
						provinciaResidenza:{ minlength:2, required: true },
						numeroTelefono:{ minlength:2, required: true, digits: true },
						email: "email",
						codiceFidal: { minlength:8 }
					},
					
					messages:{                    	
						cognome:{ 
							//minlength:	"Il cognome deve essere lungo almeno 2 caratteri",
							//required: 	"Il cognome e' obbligatorio!" 
						},
						nome:{ 
							minlength:	"Il nome deve essere lungo almeno 2 caratteri",
							required: 	"Il nome e' obbligatorio!" 
						},
						sesso:{ 
							required: 	"Il sesso e' obbligatorio!" 
						},
						dataNascita:{ 
							required: 	"La data di nascita e' obbligatoria!",
							date: 		"Il formato della data di nascita non e' valido!" 
						},
						luogoNascita:{ 
							minlength:	"Il luogo di nascita deve essere lungo almeno 2 caratteri",
							required: 	"Il luogo di nascita e' obbligatorio!" 
						},
						indirizzoResidenza:{ 
							minlength:	"L'indirizzo di residenza deve essere lungo almeno 2 caratteri", 
							required: 	"L'indirizzo di residenza e' obbligatorio!"  
						},
						cittaResidenza:{ 
							minlength:	"La citta' di residenza deve essere lunga almeno 2 caratteri",  
							required: 	"La citta' di residenza e' obbligatoria!"  
						},
						provinciaResidenza:{
							minlength:	"La provincia di residenza deve essere lunga almeno 2 caratteri", 
							required: 	"La provincia di residenza e' obbligatoria!"  
						},
						numeroTelefono:{ 
							minlength:	"Il numero di telefono deve essere lungo almeno 2 caratteri", 
							required: 	"Il numero di telefono e' obbligatorio!",
							digits:		"Il numero di telefono deve contenere solo cifre!"					
						},
						codiceFidal: { 
							minlength:	"Il codice fidal deve essere lungo almeno 8 caratteri!" 
						},
						email: 			"Non hai inserito una e-mail valida!" 
					},
					
					submitHandler: function(form) { 
						$( "#dialogOk" ).dialog("open");
						form.submit();
					},

					invalidHandler: function() { 
						$( "#dialogKo" ).dialog("open");
					}	

				})
			});
			
			//autocompletamento -> provinciaResidenza
			$(function() {
                var arrProvincie = new Array();
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
                        arrProvincie.push($(this).attr("sigla"));
                    });
                }

                function attivaAutocomplete() {
                    $("#provinciaResidenza").autocomplete({
                        source: arrProvincie
                    }
                );
                }
            });
			
			$(function(){
				$( "#invia" ).button();
			});
			
			$(function(){
				$( "#sesso" ).buttonset();
			});
			
			$(function(){
				$( "#dialogOk" ).dialog( { 
					autoOpen:false, 
					modal:true,
					buttons: {
						Ok: function() {
							$(this).dialog("close");
						}
					}
				} );
			});
			
			$(function(){
				$( "#dialogKo" ).dialog( { 
					title:"Attenzione!", 
					autoOpen:false, 
					modal:true,
					buttons: {
						Ok: function() {
							$(this).dialog("close");
						}
					}
				});
			});
			
		</script>
		
		<style>
            input.error { border-color: red; }
            label.error { color: #000000; font-weight:bold; }
        </style>
		
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">

		<div id="dialogOk" align="center">I dati sono stati inseriti correttamente...</div>
		<div id="dialogKo" align="center">I dati inseriti non sono corretti, ricontrollali....</div>
		
		<div align="center">
<?php 
			if (isset($message)) { 
				print "<br />"; 
				print "<table border=\"0\" cellpadding=\"3\" cellspacing=\"1\" align=\"center\">"; 
				print "	<tr>"; 
				print "		<td align=\"left\">".($message)."</td>"; 
				print "	</tr>"; 
				print "</table>"; 
				print "<br />"; 
				$message = null;
			} 
?> 
		</div>
		
		<div align="center">Modulo di richiesta iscrizione</div>
		<form id="modulo" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table border="0" cellpadding="3" cellspacing="1" align="center">
				<tr>
					<td align="left"><label for="nome">Nome * </label></td>
					<td align="right">
						<input type="text" id="nome" name="nome" value="<?php echo $nome ?>" />
					</td>
				</tr>
				<tr>
					<td align="left"><label for="cognome">Cognome * </label></td>
					<td align="right">
						<input type="text" id="cognome" name="cognome" value="<?php echo $cognome ?>" />
					</td>
				</tr>
				<tr>
					<td align="left"><label for="sesso">Sesso (M/F) * </label></td>
					<td align="right">
						<div id="sesso" align="right">
							<input type="radio" id="sessoM" name="sesso" value="M" /><label for="sessoM">M</label>

							<input type="radio" id="sessoF" name="sesso" value="F" /><label for="sessoF">F</label>
						</div>
					</td>
				</tr>
				<tr>
					<td align="left"><label for="dataNascita">Data di nascita (dd/mm/yyyy) * </label></td>
					<td align="right"><input type="text" id="dataNascita" maxlength="10" size="12" name="dataNascita" value="<?php echo $dataNascita ?>" /></td>
				</tr>
				<tr>
					<td align="left"><label for="luogoNascita">Luogo di nascita * </label></td>
					<td align="right"><input type="text" id="luogoNascita" name="luogoNascita" value="<?php echo $luogoNascita ?>" /></td>
				</tr>
				<tr>
					<td align="left"><label for="indirizzoResidenza">Indirizzo di residenza * </label></td>
					<td align="right"><input type="text" id="indirizzoResidenza" name="indirizzoResidenza" value="<?php echo $indirizzoResidenza ?>" /></td>
				</tr>
				<tr>
					<td align="left"><label for="cittaResidenza">Citta' di residenza * </label></td>
					<td align="right"><input type="text" id="cittaResidenza" name="cittaResidenza" value="<?php echo $cittaResidenza ?>" /></td>
				</tr>
				<tr>
					<td align="left"><label for="provinciaResidenza">Provincia di residenza * </label></td>
					<td align="right"><input type="text" id="provinciaResidenza" maxlength="2" size="3" name="provinciaResidenza" value="<?php echo $provinciaResidenza ?>" /></td>
				</tr>
				<tr>
					<td align="left"><label for="numeroTelefono">Numero di telefono * </label></td>
					<td align="right"><input type="text" id="numeroTelefono" name="numeroTelefono" value="<?php echo $numeroTelefono ?>" /></td>
				</tr>
				<tr>
					<td align="left"><label for="email">Email</label></td>
					<td align="right"><input type="text" id="email" name="email" value="<?php echo $email ?>" /></td>
				</tr>
				<tr>
					<td align="left"><label for="codiceFidal">Codice Fidal</label></td>
					<td align="right"><input type="text" id="codiceFidal" name="codiceFidal" value="<?php echo $codiceFidal?>" /></td>
				</tr>
				<tr>
					<td align="right" colspan="2">* campi obbligatori</td>
				</tr>
				<tr>
					<td align="center">&nbsp;</td>
					<td align="right">
						<input type="submit" id="invia" name="submit" value="invia" />
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
	