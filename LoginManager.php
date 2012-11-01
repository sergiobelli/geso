
<?php

require_once("dblib.php");
require_once("clublib.php");
require_once("CertificatoMedicoManager.php");

class LoginManager {
	
    function autenticate ($username, $password) {
        return connetti_query(
			"SELECT id FROM login WHERE username = '$username' AND password = '$password'");
    }

	function gestioneCertificatiMedici() {
		$CertificatoMedicoManager = new CertificatoMedicoManager();
		
		$elencoCertificatiMedici = $CertificatoMedicoManager::lista();
		while ($elencoCertificatiMedici_row = dbms_fetch_array($elencoCertificatiMedici)) {
			
			$dataScadenzaCertificato = $elencoCertificatiMedici_row["data_scadenza"];

			$dataAvviso90gg = $elencoCertificatiMedici_row["data_avviso_90_gg"];
			$dataAvviso60gg = $elencoCertificatiMedici_row["data_avviso_60_gg"];
			$dataAvviso30gg = $elencoCertificatiMedici_row["data_avviso_30_gg"];
			$dataAvviso7gg = $elencoCertificatiMedici_row["data_avviso_7_gg"];
			$dataAvvisoScaduto = $elencoCertificatiMedici_row["data_avviso_scaduto"];
			
			$diffDate = fDateDiff(date("Y-m-d"), $dataScadenzaCertificato);
			
			if ($diffDate > 90 ) {
				
				//tutto ok!
			
			} else if ($diffDate <= 90 && $diffDate > 60 && $dataAvviso90gg != null) {

				//mail 90gg e update db
				sendMail(
					$elencoCertificatiMedici_row["nome_atleta"], 
					$elencoCertificatiMedici_row["cognome_atleta"], 
					$elencoCertificatiMedici_row["email_atleta"], 
					90);
				$CertificatoMedicoManager::modifica(
					$elencoCertificatiMedici_row["id_certificato_medico"], 
					null, 
					null, 
					null, 
					90);
					
			} else if ($diffDate <= 60 && $diffDate > 30 && $dataAvviso60gg != null) {
			
				//mail 60gg e update db
				sendMail(
					$elencoCertificatiMedici_row["nome_atleta"], 
					$elencoCertificatiMedici_row["cognome_atleta"], 
					$elencoCertificatiMedici_row["email_atleta"], 
					60);
				$CertificatoMedicoManager::modifica(
					$elencoCertificatiMedici_row["id_certificato_medico"], 
					null, 
					null, 
					null, 
					60);
					
			} else if ($diffDate <= 30 && $diffDate > 7 && $dataAvviso30gg != null) {
				
				//mail 30gg e update db
				sendMail(
					$elencoCertificatiMedici_row["nome_atleta"], 
					$elencoCertificatiMedici_row["cognome_atleta"], 
					$elencoCertificatiMedici_row["email_atleta"], 
					30);
				$CertificatoMedicoManager::modifica(
					$elencoCertificatiMedici_row["id_certificato_medico"], 
					null, 
					null, 
					null, 
					30);
												
			} else if ($diffDate <= 7 && $dataAvviso7gg != null) {
				
				//mail 7gg e update db
				sendMail(
					$elencoCertificatiMedici_row["nome_atleta"], 
					$elencoCertificatiMedici_row["cognome_atleta"], 
					$elencoCertificatiMedici_row["email_atleta"], 
					7);
				$CertificatoMedicoManager::modifica(
					$elencoCertificatiMedici_row["id_certificato_medico"], 
					null, 
					null, 
					null, 
					7);
					
			} else {

				//scaduto e update db				
				sendMail(
					$elencoCertificatiMedici_row["nome_atleta"], 
					$elencoCertificatiMedici_row["cognome_atleta"], 
					$elencoCertificatiMedici_row["email_atleta"], 
					0);
				$CertificatoMedicoManager::modifica(
					$elencoCertificatiMedici_row["id_certificato_medico"], 
					null, 
					null, 
					null, 
					0);
					
			}
			
		}
	
	}
	
	function sendMail($nomeAtleta, $cognomeAtleta, $emailAtleta, $tipoAvviso) {
		
		//mandare mail ad atletica valsesia
			ini_set("SMTP", "mail.atleticavalsesia.it" );
			ini_set("sendmail_from", "info@atleticavalsesia.it");
			ini_set("smtp_port","25");
			ini_set("auth_username","atleticavalsesia.it");
			ini_set("auth_password","eivaloex");
			
			try {
				if ($tipoAvviso == '0') {
					$object = "certificato medico atleta scaduto";
					$mailMessage = "Ciao, \nil nostro atleta ".$cognomeAtleta." ".$nomeAtleta." presenta un certificato medico scaduto.";
				} else {
					$object = "Scadenza certificato atleta : ' .$tipoAvviso";
					$mailMessage = "Ciao, \nil nostro atleta ".$cognomeAtleta." ".$nomeAtleta." presenta un certificato medico che scadra' nei prossimi ".$tipoAvviso." giorni!";
				}
				mail("sergiobelli81@gmail.com, sergio.belli@email.it, danilo.belli@email.it, atleticavalsesia@libero.it, info@atleticavalsesia.it", $object, $mailMessage);
			} catch(Exception $e) {
				$message =  'Message: ' .$e->getMessage();
			}
			
			//mandare mail ad utente
			if (isset($emailAtleta) && $emailAtleta != '') {
				try {
					if ($tipoAvviso == '0') {
						$object = "Certificato medico scaduto";
						$mailMessage = "Ciao ".$nomeAtleta.", \nattenzione, il tuo certificato medico e' scaduto. \nProvvedi quanto prima ad effettuarne il rinnovo e a comunicarcelo prontamente. \ngrazie e buona giornata\nAtletica Valsesia";						
					} else {
						$object = "Scadenza certificato medico";
						$mailMessage = "Ciao ".$nomeAtleta.", \nattenzione, il tuo certificato medico scadra' nei prossimi ".$tipoAvviso." giorni. Provvedi quanto prima ad effettuarne il rinnovo e a comunicarcelo prontamente. \ngrazie e buona giornata\nAtletica Valsesia";
					}
					
					mail($emailAtleta, $object, $mailMessage);
					
				} catch(Exception $e) {
					$message =  'Message: ' .$e->getMessage();
				}
			}
	
	}
}
