<?php
	global $nome, $cognome, $sesso, $dataNascita, $luogoNascita, $indirizzoResidenza, $cittaResidenza, $provinciaResidenza, $numeroTelefono, $email, $codiceFidal, $message;
	
	function inserisci ($nome, $cognome, $sesso, $dataNascita, $luogoNascita, $indirizzoResidenza, $cittaResidenza, $provinciaResidenza, $numeroTelefono, $email, $codiceFidal) {
	
		include "funzioni_mysql.php";
		
		list($d, $m, $y) = explode('/', $dataNascita);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		$dataNascita=strftime('%Y-%m-%d',$mk);
		
		$t = "iscrizioni_societa"; # nome della tabella
		$v = array (
			$nome, $cognome, $sesso, $dataNascita, $luogoNascita, $indirizzoResidenza, 
			$cittaResidenza, $provinciaResidenza, $numeroTelefono, $email, $codiceFidal, date("Y-m-d h:i:s")); # valori da inserire
		
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
		
		/*
		elseif( !isset($email) || $email =="") {
			$message = "Attenzione, inserire l'email.";
		} 
		*/
		
		else {
			
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
		}
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Modulo di richiesta iscrizione</title><link rel="stylesheet" type="text/css" href="stylesheet.css">
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">

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
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table border="0" cellpadding="3" cellspacing="1" align="center">
				<tr>
					<td align="left">Nome * </td>
					<td align="right">
						<input type="text" id="nome" name="nome" value="<?php echo $nome ?>" />
					</td>
				</tr>
				<tr>
					<td align="left">Cognome * </td>
					<td align="right">
						<input type="text" id="cognome" name="cognome" value="<?php echo $cognome ?>" />
					</td>
				</tr>
				<tr>
					<td align="left">Sesso (M/F) * </td>
					<td align="right">
						M <input type="radio" id="sesso" name="sesso" value="M" />
						&nbsp;&nbsp;
						F <input type="radio" id="sesso" name="sesso" value="F" />
					</td>
				</tr>
				<tr>
					<td align="left">Data di nascita (dd/mm/yyyy) * </td>
					<td align="right"><input type="text" id="dataNascita" maxlength="10" size="12" name="dataNascita" value="<?php echo $dataNascita ?>" /></td>
				</tr>
				<tr>
					<td align="left">Luogo di nascita * </td>
					<td align="right"><input type="text" id="luogoNascita" name="luogoNascita" value="<?php echo $luogoNascita ?>" /></td>
				</tr>
				<tr>
					<td align="left">Indirizzo di residenza * </td>
					<td align="right"><input type="text" id="indirizzoResidenza" name="indirizzoResidenza" value="<?php echo $indirizzoResidenza ?>" /></td>
				</tr>
				<tr>
					<td align="left">Citta' di residenza * </td>
					<td align="right"><input type="text" id="cittaResidenza" name="cittaResidenza" value="<?php echo $cittaResidenza ?>" /></td>
				</tr>
				<tr>
					<td align="left">Provincia di residenza * </td>
					<td align="right"><input type="text" id="provinciaResidenza" maxlength="2" size="3" name="provinciaResidenza" value="<?php echo $provinciaResidenza ?>" /></td>
				</tr>
				<tr>
					<td align="left">Numero di telefono * </td>
					<td align="right"><input type="text" id="numeroTelefono" name="numeroTelefono" value="<?php echo $numeroTelefono ?>" /></td>
				</tr>
				<tr>
					<td align="left">Email</td>
					<td align="right"><input type="text" id="email" name="email" value="<?php echo $email ?>" /></td>
				</tr>
				<tr>
					<td align="left">Codice Fidal</td>
					<td align="right"><input type="text" id="email" name="codiceFidal" value="<?php echo $codiceFidal?>" /></td>
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
	