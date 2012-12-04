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
					count(*) as PRESENZE,
					(select 	sum(tg.punteggio)
					from 	presenza p, stagione s, tipologia_gara tg
					where
						p.id_atleta = a.ID
						and p.id_stagione = s.id
						and p.id_tipologia_gara = tg.id
						and s.id = ".$stagione.") as PUNTEGGIO
				from 
					presenza p, 
					atleta a, 
					stagione s
				where 
					p.ID_ATLETA = a.ID
					and p.ID_STAGIONE = s.ID
					and s.id = ".$stagione."
				group by p.ID_ATLETA
				order by PUNTEGGIO desc
			");
    }
    
    function getUltimoAggiornamento($stagione) {
        return connetti_query(
			"
select 
	max(presenza.created) ULTIMO_AGGIORNAMENTO
from 
	presenza, 
	stagione
where
	presenza.ID_STAGIONE = stagione.ID
	and stagione.ID = '".$stagione."'
			");
    }
}
?>