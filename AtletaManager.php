<?php

require_once("dblib.php");
require_once("clublib.php");

class AtletaManager {
    function lista () {
        return connetti_query(
			"
				select 
					a.ID as ID,
					a.COGNOME as COGNOME, 
					a.NOME as NOME, 
					a.SESSO as SESSO,
					DATE_FORMAT(a.DATA_NASCITA, '%d/%m/%Y') as DATA_NASCITA
				from 
					atleta a
				group by a.COGNOME, a.NOME
			");
    }
	
	function get ($idAtleta) {
        return connetti_query(
			"
				select 
					a.ID as ID,
					a.COGNOME as COGNOME, 
					a.NOME as NOME, 
					a.SESSO as SESSO,
					DATE_FORMAT(a.DATA_NASCITA, '%d/%m/%Y') as DATA_NASCITA
				from 
					atleta a
				where a.ID = '".$idAtleta."'
				group by a.COGNOME, a.NOME
			");
    }
	
	function inserisci ($cognome, $nome, $sesso, $dataNascita) {
	
		include "funzioni_mysql.php";
		
		list($d, $m, $y) = explode('/', $dataNascita);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		$data=strftime('%Y-%m-%d',$mk);
		
		$t = "atleta"; # nome della tabella
		$v = array ($cognome,$nome,$sesso,$data,date("Y-m-d h:i:s"),date("Y-m-d h:i:s")); # valori da inserire
		$r =  "cognome,nome,sesso,data_nascita,created,modified"; # campi da popolare
		
		$data = new MysqlClass();
		$data->connetti();
		$data->inserisci($t,$v,$r);
		$data->disconnetti();
	}
	
	function modifica ($idAtleta, $cognome, $nome, $sesso, $dataNascita) {
	
		include "funzioni_mysql.php";
		
		list($d, $m, $y) = explode('/', $dataNascita);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		$data=strftime('%Y-%m-%d',$mk);
		
		$tabella = "atleta"; # nome della tabella
		$valori = array ($cognome,$nome,$sesso,$data,date("Y-m-d h:i:s"),date("Y-m-d h:i:s")); # valori da inserire
		$campi =  array ('cognome','nome','sesso','data_nascita','created','modified'); # campi da popolare
		
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