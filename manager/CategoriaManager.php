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
	
	function getByDataNascitaAndSesso ($dataDiNascita, $sesso, $annoAttuale) {
		
		list($giornon,$mesen,$annon)=explode('/',$dataDiNascita); 
		$eta=$annoAttuale-$annon; 

		if (isset($_SESSION['categorie'])) {
      
			for($pos=0; $pos<count($_SESSION['categorie']); $pos++) {
				
				if ($_SESSION['categorie'][$pos][4] <= $eta 
						&& $eta <= $_SESSION['categorie'][$pos][5]
						&& $_SESSION['categorie'][$pos][2] == $sesso) {
							
					return $_SESSION['categorie'][$pos][1];
						
				}
				
			}			
			
		} else {
			
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
}
?>