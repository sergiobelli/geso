<?php

require_once("dblib.php");
require_once("clublib.php");

class CategoriaManager {
    function lista () {
        return connetti_query(
			"
				select 
					ID as id, 
					CODICE as codice, 
					SESSO as sesso, 
					DESCRIZIONE as descrizione,
					DA as da, 
					A as a
				from 
					categoria
				order by 
					DA, SESSO
			");
    }
	
	function get ($idCategoria) {
        return connetti_query(
			"
			select 
					ID as id, 
					CODICE as codice, 
					SESSO as sesso, 
					DESCRIZIONE as descrizione,
					DA as da, 
					A as a			from 
				categoria
			where
				id = '".$idCategoria."'
			");
    }
	
	function getByDataNascitaAndSesso ($dataDiNascita, $sesso, $stagione) {
		
		list($giornon,$mesen,$annon)=explode('/',$dataDiNascita); 

		require_once("StagioneManager.php");
		$StagioneManager = new StagioneManager();
		$annoAttuale = StagioneManager::getDescrizioneStagione($stagione);

		$eta=$annoAttuale-$annon; 
		
		$query =	 "
			select 
					ID as id, 
					CODICE as codice, 
					SESSO as sesso, 
					DESCRIZIONE as descrizione,
					DA as da, 
					A as a			from 
				categoria
			where
				SESSO = '".$sesso."'
				and DA <= '".$eta."' and '".$eta."' <= A ";		
		
		$res = connetti_query($query);
		while ($res_row = dbms_fetch_array($res)) {
		
			return $res_row["codice"];
		}
        
    }	
}
?>