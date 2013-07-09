<?php

session_start();

require_once("../ConfigManager.php");
$ConfigManager = new ConfigManager();
$dbhost = $ConfigManager->getHost ();
$dbuser = $ConfigManager->getUser ();
$dbname = $ConfigManager->getDatabase ();
$dbpass = $ConfigManager->getPassword ();

require_once("../GaraManager.php");

try {
	$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$cmd = 'SELECT g.id, g.localita, g.nome, g.data 
		FROM gara g, stagione s 
		WHERE (g.localita LIKE :localita or g.nome like :nome) 
			and g.id_stagione = s.id and s.id = '.$_SESSION['idStagioneSessione'].' 
		order by g.data desc, g.nome, g.localita';

	$term = "%" . $_GET['term'] . "%";
	
	$result = $conn->prepare($cmd);
	$result->bindValue(":localita", $term);
	$result->bindValue(":nome", $term);
	$result->execute();
	
	$return_arr = array();
	$row_array = array();
	
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	
		$localita = utf8_encode($row['localita']);
		$nome = utf8_encode($row['nome']);
		$data = utf8_encode($row['data']);
		
		$row_array['value'] = $localita . " - " . $nome . " (" . $data .")";
		$row_array['label'] = $localita . " - " . $nome . " (" . $data .")";
			
		$row_array['idGara'] = $row['id'];
		array_push($return_arr,$row_array);
	}
	
	$conn = NULL;
	
	echo json_encode($return_arr);
	
} catch(PDOException $e) {
	echo $e->getMessage();
}


?>