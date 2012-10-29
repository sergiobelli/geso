<?php

require_once("dblib.php");
require_once("clublib.php");

class GaraManager {
	
	function randomAlphaNum($length){ 

		$rangeMin = pow(36, $length-1); //smallest number to give length digits in base 36 
		$rangeMax = pow(36, $length)-1; //largest number to give length digits in base 36 
		$base10Rand = mt_rand($rangeMin, $rangeMax); //get the random number 
		$newRand = base_convert($base10Rand, 10, 36); //convert it 
		
		return $newRand; //spit it out 

	} 


    function lista () {
        return connetti_query(
			"
				select 
					g.ID as ID,
					g.CODICE as CODICE,
					g.NOME as NOME, 
					g.LOCALITA as LOCALITA,
				    g.CAMPIONATO as CAMPIONATO,
				    g.NOSTRA as NOSTRA,
					DATE_FORMAT(g.DATA, '%d/%m/%Y') as DATA
				from 
					gara g
				group by g.LOCALITA, g.NOME, g.DATA
                                order by g.DATA desc
			");
    }

    function listaOrganizzate () {
        return connetti_query(
			"
				select 
					g.ID as ID,
					g.CODICE as CODICE,
					g.NOME as NOME, 
					g.LOCALITA as LOCALITA,
				    g.CAMPIONATO as CAMPIONATO,
				    g.NOSTRA as NOSTRA,
					DATE_FORMAT(g.DATA, '%d/%m/%Y') as DATA
				from 
					gara g
				where
					g.nostra = true
				group by g.NOME, g.LOCALITA, g.DATA
			");
    }

	function get ($idGara) {
        return connetti_query(
			"
				select 
					g.ID as ID,
					g.CODICE as CODICE,
					g.NOME as NOME, 
					g.LOCALITA as LOCALITA,
				    g.CAMPIONATO as CAMPIONATO,
				    g.NOSTRA as NOSTRA,
					DATE_FORMAT(g.DATA, '%d/%m/%Y') as DATA
				from 
					gara g
				where g.ID = '".$idGara."'
				group by g.NOME, g.LOCALITA, g.DATA
			");
    }
	
	function inserisci ($nome, $localita, $campionato, $nostra, $dataGara) {
	
		include "funzioni_mysql.php";
		
		list($d, $m, $y) = explode('/', $dataGara);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		$data=strftime('%Y-%m-%d',$mk);
		
		$length = 5;
		
		$rangeMin = pow(36, $length-1); //smallest number to give length digits in base 36 
		$rangeMax = pow(36, $length)-1; //largest number to give length digits in base 36 
		$base10Rand = mt_rand($rangeMin, $rangeMax); //get the random number 
		$a = base_convert($base10Rand, 10, 36); //convert it 
		
		$rangeMin = pow(36, $length-1); //smallest number to give length digits in base 36 
		$rangeMax = pow(36, $length)-1; //largest number to give length digits in base 36 
		$base10Rand = mt_rand($rangeMin, $rangeMax); //get the random number 
		$b = base_convert($base10Rand, 10, 36); //convert it 
		
		$rangeMin = pow(36, $length-1); //smallest number to give length digits in base 36 
		$rangeMax = pow(36, $length)-1; //largest number to give length digits in base 36 
		$base10Rand = mt_rand($rangeMin, $rangeMax); //get the random number 
		$c = base_convert($base10Rand, 10, 36); //convert it 
		
		$codice = $a . $b . $c;		
		
		$t = "gara"; # nome della tabella
		$v = array ($codice, $nome,$localita,$campionato, $nostra, $data,date("Y-m-d h:i:s"),date("Y-m-d h:i:s")); # valori da inserire
		$r =  "codice, nome,localita,campionato,nostra,data,created,modified"; # campi da popolare
		
		$data = new MysqlClass();
		$data->connetti();
		$data->inserisci($t,$v,$r);
		$data->disconnetti();
	}

	function modifica ($idGara, $nome, $localita, $campionato, $nostra, $dataGara) {
	
		include "funzioni_mysql.php";
		
		list($d, $m, $y) = explode('/', $dataGara);
		$mk=mktime(0, 0, 0, $m, $d, $y);
		$data=strftime('%Y-%m-%d',$mk);
		
		$tabella = "gara"; # nome della tabella
		$valori = array ($nome,$localita,$campionato, $nostra, $data,date("Y-m-d h:i:s"),date("Y-m-d h:i:s")); # valori da inserire
		$campi =  array ('nome','localita','campionato','nostra', 'data','created','modified'); # campi da popolare
		
		$data = new MysqlClass();
		$data->connetti();
		$data->modifica($tabella,$valori,$campi,$idGara);
		$data->disconnetti();
	}
	
	function cancella ($idGara) {
		
		include "PresenzaManager.php";
		$PresenzaManager = new PresenzaManager();
		$listaPresenze = $PresenzaManager->listaGara($idGara);
		while ($listaPresenze_row = dbms_fetch_array($listaPresenze)) {
			return "-1";
		}
		
		$query = "delete from gara where ID = ".$idGara;
        return connetti_query($query);
	}
	
}
?>