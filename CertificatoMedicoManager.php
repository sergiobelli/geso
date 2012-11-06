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
				atleta.NOME as nome_atleta,
				atleta.COGNOME as cognome_atleta,
				atleta.SESSO as sesso_atleta,
				DATE_FORMAT(atleta.DATA_NASCITA, '%d/%m/%Y') as data_nascita_atleta,
				atleta.email as email_atleta,
				DATE_FORMAT(certificato_medico.data_scadenza, '%d/%m/%Y') as data_scadenza,
				certificato_medico.agonistico,
				DATE_FORMAT(certificato_medico.avviso_90_gg, '%d/%m/%Y') as data_avviso_90_gg,
				DATE_FORMAT(certificato_medico.avviso_60_gg, '%d/%m/%Y') as data_avviso_60_gg,
				DATE_FORMAT(certificato_medico.avviso_30_gg, '%d/%m/%Y') as data_avviso_30_gg,
				DATE_FORMAT(certificato_medico.avviso_7_gg, '%d/%m/%Y') as data_avviso_7_gg,
				DATE_FORMAT(certificato_medico.avviso_scaduto, '%d/%m/%Y') as data_avviso_scaduto
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
	
	function modificaAvviso ($idCertificatoMedico, $avviso) {
		if ($avviso == 0) {
			connetti_query("
				update certificato_medico
				set avviso_scaduto = '".date("Y-m-d H:i:s")."'
				where id = '".$idCertificatoMedico."' ");			
		} else if ($avviso == 7) {
			connetti_query("
				update certificato_medico
				set avviso_7_gg = '".date("Y-m-d H:i:s")."'
				where id = '".$idCertificatoMedico."' ");	
		} else if ($avviso == 30) {
			connetti_query("
				update certificato_medico
				set avviso_30_gg = '".date("Y-m-d H:i:s")."'
				where id = '".$idCertificatoMedico."' ");	
		} else if ($avviso == 60) {
			connetti_query("
				update certificato_medico
				set avviso_60_gg = '".date("Y-m-d H:i:s")."'
				where id = '".$idCertificatoMedico."' ");	
		} else if ($avviso == 90) {
			connetti_query("
				update certificato_medico
				set avviso_90_gg = '".date("Y-m-d H:i:s")."'
				where id = '".$idCertificatoMedico."' ");	
		}
	}
	
	function cancella ($idCertificatoMedico) {	
		$query = "delete from certificato_medico where ID = ".$idCertificatoMedico;
        return connetti_query($query);
	}
	
}
?>