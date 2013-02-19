<?php

require_once("dblib.php");
require_once("clublib.php");

class TipologiaGaraManager {

    function lista () {
        return connetti_query(
			"
				select 
					tg.ID as ID,
					tg.TIPO as TIPO,
					tg.PUNTEGGIO as PUNTEGGIO
				from 
					tipologia_gara tg
				group by tg.ID
            order by tg.ID
			");
    }

}
?>