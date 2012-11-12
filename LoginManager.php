
<?php

require_once("dblib.php");
require_once("clublib.php");
require_once("CertificatoMedicoManager.php");
require_once("util/Mailer.php");
require_once("util/DiffUtil.php");

class LoginManager {
	
    function autenticate ($username, $password) {
        return connetti_query(
			"SELECT id FROM login WHERE username = '$username' AND password = '$password'");
    }
    
	function gestioneCertificatiMedici() {
		$CertificatoMedicoManager = new CertificatoMedicoManager();
		$DiffUtil = new DiffUtil();
		$Mailer = new Mailer();
		
		$elencoCertificatiMedici = $CertificatoMedicoManager::lista();
		while ($elencoCertificatiMedici_row = dbms_fetch_array($elencoCertificatiMedici)) {
			
			$idCertificatoMedico = $elencoCertificatiMedici_row["id_certificato_medico"];
			
			$dataScadenzaCertificato = $elencoCertificatiMedici_row["data_scadenza"];

			$dataAvviso90gg 		= $elencoCertificatiMedici_row["data_avviso_90_gg"];
			$dataAvviso60gg 		= $elencoCertificatiMedici_row["data_avviso_60_gg"];
			$dataAvviso30gg 		= $elencoCertificatiMedici_row["data_avviso_30_gg"];
			$dataAvviso7gg 			= $elencoCertificatiMedici_row["data_avviso_7_gg"];
			$dataAvvisoScaduto 	= $elencoCertificatiMedici_row["data_avviso_scaduto"];
			
			$nomeAtleta 		= $elencoCertificatiMedici_row["nome_atleta"];
			$cognomeAtleta 	= $elencoCertificatiMedici_row["cognome_atleta"];
			$emailAtleta		= $elencoCertificatiMedici_row["email_atleta"];
					
			$diffDate = $DiffUtil::fDateDiff(date("Y-m-d"), $dataScadenzaCertificato);
			
			if ($diffDate > 90 ) {
				
				//tutto ok!
			
			} else if ($diffDate <= 90 && $diffDate > 60 && $dataAvviso90gg == null) {

				//mail 90gg e update db
				$Mailer->sendMailAvvisoSocieta($nomeAtleta, $cognomeAtleta, $emailAtleta, 90);
				$Mailer->sendMailAvvisoAtleta($nomeAtleta, $cognomeAtleta, $emailAtleta, 90);
				CertificatoMedicoManager::modificaAvviso($idCertificatoMedico, 90);
					
			} else if ($diffDate <= 60 && $diffDate > 30 && $dataAvviso60gg == null) {
			
				//mail 60gg e update db
				$Mailer->sendMailAvvisoSocieta($nomeAtleta, $cognomeAtleta, $emailAtleta, 60);
				$Mailer->sendMailAvvisoAtleta($nomeAtleta, $cognomeAtleta, $emailAtleta, 60);
				CertificatoMedicoManager::modificaAvviso($idCertificatoMedico, 60);
					
			} else if ($diffDate <= 30 && $diffDate > 7 && $dataAvviso30gg == null) {
				
				//mail 30gg e update db
				$Mailer->sendMailAvvisoSocieta($nomeAtleta, $cognomeAtleta, $emailAtleta, 30);
				$Mailer->sendMailAvvisoAtleta($nomeAtleta, $cognomeAtleta, $emailAtleta, 30);
				CertificatoMedicoManager::modificaAvviso($idCertificatoMedico, 30);
												
			} else if ($diffDate <= 7 && $diffDate > 0 && $dataAvviso7gg == null) {
				
				//mail 7gg e update db
				$Mailer->sendMailAvvisoSocieta($nomeAtleta, $cognomeAtleta, $emailAtleta, 7);
				$Mailer->sendMailAvvisoAtleta($nomeAtleta, $cognomeAtleta, $emailAtleta, 7);
				CertificatoMedicoManager::modificaAvviso($idCertificatoMedico, 7);
					
			} else if ($diffDate < 0) {
				
				//scaduto e update db
				if ($dataAvvisoScaduto == null) {
					$Mailer::sendMailAvviso($nomeAtleta, $cognomeAtleta, $emailAtleta, 0);
					CertificatoMedicoManager::modificaAvviso($idCertificatoMedico, 0);
				} else {
					//scaduto e update db (solo se l'ultimo avviso e' stato inviato da piu' di una settimana)
					$diffDateUltimoAvviso = $DiffUtil::fDateDiff(date("Y-m-d"), $dataAvvisoScaduto);
					if ($diffDateUltimoAvviso > 7) {
						$Mailer::sendMailAvviso($nomeAtleta, $cognomeAtleta, $emailAtleta, 0);
						CertificatoMedicoManager::modificaAvviso($idCertificatoMedico, 0);
					}
				}
				
			}
			
			$dataScadenzaCertificato = null;
			
		}
	
	}
		
}
