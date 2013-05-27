<?php

require_once("../ConfigManager.php");
$ConfigManager = new ConfigManager();
$dbhost = $ConfigManager->getHost ();
$dbuser = $ConfigManager->getUser ();
$dbname = $ConfigManager->getDatabase ();
$dbpass = $ConfigManager->getPassword ();

try {
	$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$cmd = 'SELECT id, tipo, punteggio, ordine 
		FROM tipologia_gara
		WHERE tipo LIKE :tipo 
		order by ordine';

	$term = "%" . $_GET['term'] . "%";
	
	$result = $conn->prepare($cmd);
	$result->bindValue(":tipo", $term);
	$result->execute();
	
	$return_arr = array();
	$row_array = array();
	
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		
		$tipo = utf8_encode($row['tipo']);
		$punteggio = utf8_encode($row['punteggio']);
		$ordine = utf8_encode($row['ordine']);
		
		$row_array['value'] = $tipo . " (" . $punteggio ." punti )";
		$row_array['label'] = $tipo . " (" . $punteggio ." punti )";
			
		$row_array['idTipologiaGara'] = $row['id'];
		array_push($return_arr,$row_array);
	}
	
	$conn = NULL;
	
	echo json_encode($return_arr);
	
} catch(PDOException $e) {
	echo $e->getMessage();
}


?>