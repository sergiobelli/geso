<?php

require_once("../ConfigManager.php");
$ConfigManager = new ConfigManager();
$dbhost = $ConfigManager->getHost ();
$dbuser = $ConfigManager->getUser ();
$dbname = $ConfigManager->getDatabase ();
$dbpass = $ConfigManager->getPassword ();

$conn = null;
try {
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$cmd = 'SELECT id, cognome, nome 
		FROM atleta 
		WHERE (cognome LIKE :cognome or nome like :nome) 
			and (ex_atleta is null or ex_atleta = \'N\') 
		order by cognome, nome';

	$term = "%" . $_GET['term'] . "%";

$result = $conn->prepare($cmd);
$result->bindValue(":cognome", $term);
$result->bindValue(":nome", $term);
$result->execute();
$return_arr = array();
$row_array = array();

 while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		
		$nome = utf8_encode($row['nome']);
		$cognome = utf8_encode($row['cognome']);
		
		$row_array['value'] = $cognome . " " . $nome;
		$row_array['label'] = $cognome . " " . $nome;
		
		$row_array['idAtleta'] = $row['id'];
		
        array_push($return_arr,$row_array);
	}
    
$conn = NULL;
	
echo json_encode($return_arr);
	
} catch(PDOException $e) {
	echo $e->getMessage();
}


?>