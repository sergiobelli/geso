<?php

require_once("dblib.php");
require_once("clublib.php");

class PresenzaManager {

    function lista ($idStagione) {
    	$query = "
				select 
					p.ID as ID,
					a.ID as ID_ATLETA,
					a.NOME as NOME_ATLETA, 
					a.COGNOME as COGNOME_ATLETA, 
					g.ID as ID_GARA,
					g.NOME as NOME_GARA,
					g.LOCALITA as LOCALITA_GARA,
					g.DATA as DATA_GARA,
					s.ID as ID_STAGIONE,
					s.ANNO as ANNO
				from 
					presenza p,
					atleta a,
					gara g,
					stagione s
				where 
					p.ID_ATLETA = a.ID
					and p.ID_GARA = g.ID
					and p.ID_STAGIONE = s.ID";
		
		if(isset($idStagione)) {
			$query = $query." and s.ID = ".$idStagione;
		}
		
		$query = $query." group by p.ID
				order by g.DATA desc, g.NOME, a.COGNOME";
				
        return connetti_query($query);
    }

	function listaAtleta ($idAtleta) {
		return connetti_query(
			"
				select 
					p.ID as ID
				from 
					presenza p
				where 
					p.ID_ATLETA = ".$idAtleta."
			");
	}

	function listaGara ($idGara) {
		return connetti_query(
			"
				select 
					p.ID as ID
				from 
					presenza p
				where 
					p.ID_GARA = ".$idGara."
			");
	}

	function get ($idPresenza) {
        return connetti_query(
			"
				select 
					p.ID as ID,
					a.ID as ID_ATLETA,
					a.NOME as NOME_ATLETA, 
					a.COGNOME as COGNOME_ATLETA, 
					g.ID as ID_GARA,
					g.NOME as NOME_GARA,
					g.LOCALITA as LOCALITA_GARA,
					g.DATA as DATA_GARA,
					s.ID as ID_STAGIONE,
					s.ANNO as ANNO
				from 
					presenza p,
					atleta a,
					gara g,
					stagione s
				where 
					p.ID_ATLETA = a.ID
					and p.ID_GARA = g.ID
					and p.ID_STAGIONE = s.ID
					and p.ID = '".$idPresenza."'
			");
    }
	
	function inserisci ($idAtleta, $idGara, $idStagione) {
	
		include "funzioni_mysql.php";
		
		$t = "presenza"; # nome della tabella
		$v = array ($idAtleta,$idGara,$idStagione,date("Y-m-d H:i:s"),date("Y-m-d H:i:s")); # valori da inserire
		$r =  "id_atleta,id_gara,id_stagione,created,modified"; # campi da popolare
		
		$data = new MysqlClass();
		$data->connetti();
		$data->inserisci($t,$v,$r);
		$data->disconnetti();
	}

	function modifica ($idPresenza, $idAtleta, $idGara, $idStagione) {
	
		include "funzioni_mysql.php";
		
		$tabella = "presenza"; # nome della tabella
		$valori = array ($idAtleta,$idGara,$idStagione,date("Y-m-d H:i:s"),date("Y-m-d H:i:s")); # valori da inserire
		$campi =  array ('id_atleta','id_gara','id_stagione','created','modified'); # campi da popolare
		
		$data = new MysqlClass();
		$data->connetti();
		$data->modifica($tabella,$valori,$campi,$idPresenza);
		$data->disconnetti();
	}
	
	function cancella ($idPresenza) {
		$query = "delete from presenza where ID = ".$idPresenza;
        return connetti_query($query);
	}
	
}
?>