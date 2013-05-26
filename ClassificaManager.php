<?php

require_once("dblib.php");
require_once("clublib.php");
require_once("CategoriaManager.php");

class ClassificaManager {
    function lista ($stagione) {
        return connetti_query(
			"
				select 
					a.ID as ID_ATLETA, 
					a.COGNOME as COGNOME, 
					a.NOME as NOME, 
					a.SESSO as SESSO,
					DATE_FORMAT(a.DATA_NASCITA, '%d/%m/%Y') as DATA_NASCITA,
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
				order by PUNTEGGIO desc, PRESENZE
			");
    }

	function listaByCategoria ($presenze, $stagione, $codiceCategoria) {
		
		//echo $presenze;
		$result = null;
		$contatore = 0;
		
		for($pos=0; $pos<count($presenze); $pos++) {
			
			$categoria = $presenze[$pos][4];
			
			if ($categoria == $codiceCategoria) {
				$result[$contatore] = array(
					$presenze[$pos][0],
					$presenze[$pos][1],
					$presenze[$pos][2],
					$presenze[$pos][3],
					$presenze[$pos][4],
					$presenze[$pos][5],
					$presenze[$pos][6],
					$presenze[$pos][7]);
				$contatore++;
			}
		}
		
		return $result;
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
					and stagione.ID = '".$stagione."'");
    }
    
}
?>