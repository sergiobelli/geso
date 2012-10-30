<?php

require_once("dblib.php");
require_once("clublib.php");

class CertificatoMedicoManager {
    function lista () {
        return connetti_query(
			"
			select 
				certificato_medico.id as id_certificato_medico,
				atleta.id as id_atleta,
				atleta.NOME nome_atleta,
				atleta.COGNOME cognome_atleta,
				atleta.SESSO sesso_atleta,
				DATE_FORMAT(atleta.DATA_NASCITA, '%d/%m/%Y') data_nascita_atleta,
				atleta.email as email_atleta,
				DATE_FORMAT(certificato_medico.data_scadenza, '%d/%m/%Y') data_scadenza,
				certificato_medico.agonistico,
				DATE_FORMAT(certificato_medico.avviso_90_gg, '%d/%m/%Y') data_avviso_90_gg,
				DATE_FORMAT(certificato_medico.avviso_60_gg, '%d/%m/%Y') data_avviso_60_gg,
				DATE_FORMAT(certificato_medico.avviso_30_gg, '%d/%m/%Y') data_avviso_30_gg,
				DATE_FORMAT(certificato_medico.avviso_7_gg, '%d/%m/%Y') data_avviso_7_gg,
				DATE_FORMAT(certificato_medico.avviso_scaduto, '%d/%m/%Y') data_avviso_scaduto
			from 
				certificato_medico, 
				atleta
			where
				certificato_medico.id_atleta = atleta.id
			order by
				certificato_medico.data_scadenza
			");
    }
	
	function get ($idCertificatoMedico) {
        return connetti_query(
			"
			select 
				certificato_medico.id,
				certificato_medico.id_atleta,
				DATE_FORMAT(certificato_medico.data_scadenza, '%d/%m/%Y') data_scadenza,
				certificato_medico.agonistico
			from 
				certificato_medico
			where
				certificato_medico.id = '".$idCertificatoMedico."'
			");
    }
	
	function getByAtleta ($idAtleta) {
        return connetti_query(
			"
			select 
				certificato_medico.id,
				certificato_medico.id_atleta,
				DATE_FORMAT(certificato_medico.data_scadenza, '%d/%m/%Y') data_scadenza,
				certificato_medico.agonistico
			from 
				certificato_medico
			where
				certificato_medico.id_atleta = '".$idAtleta."'
			");
    }
	
	function inserisci ($idAtleta, $dataScadenza, $agonistico) {
	
		include "funzioni_mysql.php";
		
		list($d, $m, $y) = explode('/', $dataScadenza);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		$dataDiScadenza=strftime('%Y-%m-%d',$mk);
		
		$t = "certificato_medico"; # nome della tabella
		$v = array ($idAtleta,$dataDiScadenza,$agonistico); # valori da inserire
		$r =  "id_atleta,data_scadenza,agonistico"; # campi da popolare
		
		$data = new MysqlClass();
		$data->connetti();
		$data->inserisci($t,$v,$r);
		$data->disconnetti();
		
	}
	
	function modifica ($idCertificatoMedico, $idAtleta, $dataScadenza, $agonistico) {
	
		include "funzioni_mysql.php";
		
		list($d, $m, $y) = explode('/', $dataScadenza);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		$dataDiScadenza=strftime('%Y-%m-%d',$mk);

		$tabella = "certificato_medico"; # nome della tabella
		$valori = array ($idCertificatoMedico,$idAtleta,$dataScadenza,$agonistico); # valori da inserire
		$campi =  array ('id','id_atleta','data_scadenza','agonistico'); # campi da popolare
		
		$data = new MysqlClass();
		$data->connetti();
		$data->modifica($tabella,$valori,$campi,$idAtleta);
		$data->disconnetti();
	}
	
	function cancella ($idCertificatoMedico) {	
		$query = "delete from certificato_medico where ID = ".$idCertificatoMedico;
        return connetti_query($query);
	}
	
}
?>