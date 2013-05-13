<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbname = 'atletica_valsesia';
$dbpass = '';
try {
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
} catch (PDOException $e) {
    echo $e->getMessage();
}
$cognome = $_GET['cognome'];
$nome = $_GET['nome'];
$sesso = $_GET['sesso'];
$dataNascita =  $_GET['dataNascita'];

$cmd = 'SELECT * FROM atleta where COGNOME = :cognome and NOME = :nome and SESSO = :sesso and DATA_NASCITA = :dataNascita ';

$result = $conn->prepare($cmd);

$result->bindValue(":cognome", $cognome);
$result->bindValue(":nome", $nome);
$result->bindValue(":sesso", $sesso);
$result->bindValue(":dataNascita", $dataNascita);

$result->execute();
if ($result->rowCount() >= 1) {
    echo "true";
} else {
    echo "false";
}
?>