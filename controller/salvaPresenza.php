<?php

require_once("../ConfigManager.php");
$ConfigManager = new ConfigManager();
$dbhost = $ConfigManager->getHost ();
$dbuser = $ConfigManager->getUser ();
$dbname = $ConfigManager->getDatabase ();
$dbpass = $ConfigManager->getPassword ();

try {
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
} catch(PDOException $e) {
echo $e->getMessage();
}

$nome = $_GET['Nome']; 
$cognome = $_GET['Cognome'];
$sesso = $_GET['Sesso'];

$cmd = "insert into atleta (nome, cognome, sesso) values (:nome, :cognome, :sesso)" ;
$result = $conn->prepare($cmd);


$result->bindValue(":nome", $nome);
$result->bindValue(":cognome", $cognome);
$result->bindValue(":sesso", $sesso);

$result->execute();

$conn = NULL;

?>
