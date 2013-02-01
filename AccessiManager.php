<?php

require_once("dblib.php");
require_once("clublib.php");

class AccessiManager {

    function lista () {
        return connetti_query(" select ID, USER, IP, HOST, PAGINA, OPERAZIONE, DATA from accessi order by id desc ");
    }


	function inserisci ($user, $ip, $host, $pagina, $operazione) {
	
		include "funzioni_mysql.php";
		
		$t = "accessi"; # nome della tabella

		$v = array ( $user, $ip, $host, $pagina, $operazione, date("Y-m-d H:i:s") );
		
		$r =  "user, ip, host, pagina, operazione, data";
		
		$data = new MysqlClass();
		$data->connetti();
		$data->inserisci($t,$v,$r);
		$data->disconnetti();
	}
		
}
?>