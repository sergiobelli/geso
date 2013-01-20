<?php

class DiffUtil {
	
	function fDateDiff($dateFrom, $dateA) {
    	try {
    	if ($dateA != '') {
    		list($d, $m, $y) = explode('/', $dateA);
    		$mk=mktime(0, 0, 0, $m, $d, $y);
    		$dateTo=strftime('%Y-%m-%d',$mk);
    	} else {
    		return 100;
    	}
    		
    	if(empty($dateFrom)) $dateFrom = date('Y-m-d');
    	if(empty($dateTo)) $dateTo = date('Y-m-d');
    		
    	$a_1 = explode('-',$dateFrom);
    	$a_2 = explode('-',$dateTo);
    	$mktime1 = mktime(0, 0, 0, $a_1[1], $a_1[2], $a_1[0]);
    	$mktime2 = mktime(0, 0, 0, $a_2[1], $a_2[2], $a_2[0]);
    	$secondi = $mktime1 - $mktime2;
    	$giorni = intval($secondi / 86400);
    	return -($giorni);
    	} catch(Exception $e) {
				$message =  'Message: ' .$e->getMessage();
				echo $message;
		}
    }
	
}
	
?>