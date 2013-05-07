<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbname = 'atletica60358';
$dbpass = '';
try {
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
} catch(PDOException $e) {
echo $e->getMessage();
}
$cmd = 'SELECT id, cognome, nome FROM atleta WHERE cognome LIKE :term or nome LIKE :term';
$term = "%" . $_GET['term'] . "%";
$result = $conn->prepare($cmd);
$result->bindValue(":term", $term);
$result->execute();
$return_arr = array();
$row_array = array();

 while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $row_array['label'] = $row['cognome'] . " " . $row['nome'];
        $row_array['value'] = $row['cognome'] . " " . $row['nome'];
        $row_array['idutente'] = $row['id'];
     
        array_push($return_arr,$row_array);
    
}
$conn = NULL;
echo json_encode($return_arr);
