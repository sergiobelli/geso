<?php

class Mailer {
	
	function sendMailAvviso($nomeAtleta, $cognomeAtleta, $emailAtleta, $tipoAvviso) {
		
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
	
?>