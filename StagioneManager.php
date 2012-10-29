<?php

require_once("dblib.php");
require_once("clublib.php");

class StagioneManager {

    function lista () {
        return connetti_query(
			"
				select 
					s.ID as ID,
					s.ANNO as ANNO
				from 
					stagione s
				group by s.ANNO
			");
    }

	function getUltimaStagione () {
		$ultimaStagione = connetti_query(
			"
				select 
				s.ID as ID,
				s.ANNO as ANNO
				from 
				stagione s
				group by s.ANNO
				order by s.ANNO desc				
			");
		while ($ultimaStagione_row = dbms_fetch_array($ultimaStagione)) {
			return $ultimaStagione_row["ANNO"];
		}
    }
}
?>