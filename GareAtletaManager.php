
<?php

require_once("dblib.php");
require_once("clublib.php");

class GareAtletaManager {
    function lista ($idAtleta) {
        return connetti_query(
			"
				select 
					g.ID as ID,
					g.NOME as NOME, 
					g.LOCALITA as LOCALITA,
					g.CAMPIONATO as CAMPIONATO,
					DATE_FORMAT(g.DATA, '%d/%m/%Y') as DATA,
					s.ANNO as STAGIONE
				from 
					presenza p,
					atleta a,
					gara g,
					stagione s
				where 
					p.ID_ATLETA = a.ID
					and p.ID_GARA = g.ID
					and p.ID_STAGIONE = s.ID
					and a.ID = ".$idAtleta."
				group by p.ID
				order by g.DATA desc
			");
    }

}
