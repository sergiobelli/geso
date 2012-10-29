<?php

require_once("dblib.php");
require_once("clublib.php");

class ClassificaManager {
    function lista ($stagione) {
        return connetti_query(
			"
				select 
					a.ID as ID_ATLETA, 
					a.COGNOME as COGNOME, 
					a.NOME as NOME, 
					a.SESSO as SESSO,
					count(*) as PRESENZE
				from 
					presenza p, 
					atleta a, 
					stagione s
				where 
					p.ID_ATLETA = a.ID
					and p.ID_STAGIONE = s.ID
					and s.ANNO = '".$stagione."'
				group by p.ID_ATLETA
				order by PRESENZE desc
			");
    }
}
?>