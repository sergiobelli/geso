<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbname = 'atletica_valsesia';
$dbpass = '';
try {
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
} catch(PDOException $e) {
echo $e->getMessage();
}
$cmd = 'SELECT id, cognome, nome FROM atleta WHERE cognome LIKE :cognome or nome like :nome and (ex_atleta is null or ex_atleta = \'N\') ';

$term = $_GET['term'] . "%";

$result = $conn->prepare($cmd);
$result->bindValue(":cognome", $term);
$result->bindValue(":nome", $term);
$result->execute();
$return_arr = array();
$row_array = array();

 while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $row_array['value'] = $row['nome'] . " " . $row['cognome'];
        $row_array['label'] = $row['nome'] . " " . $row['cognome'];
		$row_array['idAtleta'] = $row['id'];
		
        array_push($return_arr,$row_array);
    
}
$conn = NULL;
echo json_encode($return_arr);
?>