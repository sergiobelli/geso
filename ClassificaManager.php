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
				order by PUNTEGGIO desc
			");
    }

	function listaByCategoria ($stagione, $codiceCategoria) {
		
		$CategoriaManager = new CategoriaManager();
		
		$query = "
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
				order by PUNTEGGIO desc";
		
		$result = null;
		$contatore = 0;
		$presenze = connetti_query($query);
		while ($presenze_row = dbms_fetch_array($presenze)) {
			$categoria = CategoriaManager::getByDataNascitaAndSesso($presenze_row["DATA_NASCITA"],$presenze_row["SESSO"]);
			
			if ($categoria == $codiceCategoria) {
				$result[$contatore] = array(
					$presenze_row["ATLETA"],
					$presenze_row["COGNOME"],
					$presenze_row["NOME"],
					$presenze_row["SESSO"],
					$categoria,
					$presenze_row["DATA_NASCITA"],
					$presenze_row["PRESENZE"],
					$presenze_row["PUNTEGGIO"]);
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