<?php

require_once("dblib.php");
require_once("clublib.php");

class AtletaManager {
    function lista () {
        return connetti_query(
			"
				select 
					atleta.ID as ID,
					atleta.COGNOME as COGNOME, 
					atleta.NOME as NOME, 
					atleta.SESSO as SESSO,
					DATE_FORMAT(atleta.DATA_NASCITA, '%d/%m/%Y') as DATA_NASCITA,
					DATE_FORMAT(atleta.DATA_TESSERAMENTO, '%d/%m/%Y') as DATA_TESSERAMENTO,
					atleta.CODICE_FIDAL as CODICE_FIDAL,
					DATE_FORMAT((select certificato_medico.data_scadenza 
					 from certificato_medico 
					 where certificato_medico.id_atleta = atleta.id), '%d/%m/%Y') as DATA_SCADENZA_CERTIFICATO_MEDICO,
					 atleta.COMUNE_RESIDENZA as COMUNE_RESIDENZA,
					 atleta.PROVINCIA_RESIDENZA as PROVINCIA_RESIDENZA,
					 atleta.INDIRIZZO_RESIDENZA as INDIRIZZO_RESIDENZA,
					 atleta.TELEFONO as TELEFONO,
					 atleta.CELLULARE as CELLULARE,
					 atleta.EMAIL as EMAIL,
					 atleta.TAGLIA as TAGLIA,
					 atleta.CONSENSO_DATI_PERSONALI as CONSENSO_DATI_PERSONALI
				from 
					atleta
				group by 
					atleta.COGNOME, atleta.NOME
			");
    }
	
	function get ($idAtleta) {
        return connetti_query(
			"
				select 
					atleta.ID as ID,
					atleta.COGNOME as COGNOME, 
					atleta.NOME as NOME, 
					atleta.SESSO as SESSO,
					DATE_FORMAT(atleta.DATA_NASCITA, '%d/%m/%Y') as DATA_NASCITA,
					DATE_FORMAT(atleta.DATA_TESSERAMENTO, '%d/%m/%Y') as DATA_TESSERAMENTO,
					atleta.CODICE_FIDAL as CODICE_FIDAL,
					DATE_FORMAT((select certificato_medico.data_scadenza 
					 from certificato_medico 
					 where certificato_medico.id_atleta = atleta.id), '%d/%m/%Y') as DATA_SCADENZA_CERTIFICATO_MEDICO,
					 atleta.COMUNE_RESIDENZA as COMUNE_RESIDENZA,
					 atleta.PROVINCIA_RESIDENZA as PROVINCIA_RESIDENZA,
					 atleta.INDIRIZZO_RESIDENZA as INDIRIZZO_RESIDENZA,
					 atleta.TELEFONO as TELEFONO,
					 atleta.CELLULARE as CELLULARE,
					 atleta.EMAIL as EMAIL,
					 atleta.TAGLIA as TAGLIA,
					 atleta.CONSENSO_DATI_PERSONALI as CONSENSO_DATI_PERSONALI
				from 
					atleta atleta
				where atleta.ID = '".$idAtleta."'
				group by atleta.COGNOME, atleta.NOME
			");
    }
	
	function inserisci (
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
			$consensoTrattamentoDati) {
	
		include "funzioni_mysql.php";
		
		list($d, $m, $y) = explode('/', $dataNascita);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		$dataDiNascita=strftime('%Y-%m-%d',$mk);
		
                list($d, $m, $y) = explode('/', $dataTesseramento);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		$dataDiTesseramento=strftime('%Y-%m-%d',$mk);

		$t = "atleta"; # nome della tabella
		$v = array (
			$cognome,
			$nome,
			$sesso,
			$dataDiNascita,
			$dataDiTesseramento,
			$codiceFidal,
			$comuneResidenza,
			$provinciaResidenza,
			$indirizzoResidenza,
			$telefono,
			$cellulare,
			$email,
			$taglia,
			$consensoTrattamentoDati, 
			date("Y-m-d h:i:s"),
			date("Y-m-d h:i:s")
		); # valori da inserire
		$r =  "
			cognome,
			nome,
			sesso,
			data_nascita,
			data_tesseramento,
			codice_fidal,
			comune_residenza,
			provincia_residenza,
			indirizzo_residenza,
			telefono,
			cellulare,
			email,
			taglia,
			consenso_dati_personali,
			created,
			modified"; 
			# campi da popolare
		
		$data = new MysqlClass();
		$data->connetti();
		$data->inserisci($t,$v,$r);
		$data->disconnetti();
	}
	
	function modifica (
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
			$consensoTrattamentoDati) {
	
		include "funzioni_mysql.php";
		
		list($d, $m, $y) = explode('/', $dataNascita);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		$dataDiNascita=strftime('%Y-%m-%d',$mk);
		
		list($d, $m, $y) = explode('/', $dataTesseramento);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		$dataDiTesseramento=strftime('%Y-%m-%d',$mk);

		$tabella = "atleta"; # nome della tabella
		$valori = array (
			$cognome,				//1
			$nome,					//2
			$sesso,					//3
			$dataDiNascita,			//4
			$dataDiTesseramento,		//5
			$codiceFidal,				//6
			$comuneResidenza,			//7
			$provinciaResidenza,		//8
			$indirizzoResidenza,			//9
			$telefono,					//10
			$cellulare,				//11
			$email,					//12
			$taglia,					//13
			$consensoTrattamentoDati,	//14
			date("Y-m-d h:i:s")			//15
			); # valori da inserire
		$campi =  array (
			'cognome',				//1
			'nome',					//2
			'sesso',					//3
			'data_nascita',				//4
			'data_tesseramento',			//5
			'codice_fidal',				//6
			'comune_residenza',			//7
			'provincia_residenza',		//8
			'indirizzo_residenza',			//9
			'telefono',					//10
			'cellulare',					//11
			'email',					//12
			'taglia',					//13
			'consenso_dati_personali',		//14
			'modified'					//15
			); # campi da popolare
		
		$data = new MysqlClass();
		$data->connetti();
		$data->modifica($tabella,$valori,$campi,$idAtleta);
		$data->disconnetti();
	}
	
	function cancella ($idAtleta) {
	
		include "PresenzaManager.php";
		$PresenzaManager = new PresenzaManager();
		$listaPresenze = $PresenzaManager->listaAtleta($idAtleta);
		while ($listaPresenze_row = dbms_fetch_array($listaPresenze)) {
			return "-1";
		}
		
		$query = "delete from atleta where ID = ".$idAtleta;
        return connetti_query($query);
	}
	
}
?>