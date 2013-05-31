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

$idPresenza = $_GET['idPresenza']; 
$idAtleta = $_GET['idAtleta']; 
$idGara = $_GET['idGara'];
$idTipologiaGara = $_GET['idTipologiaGara'];
$posizioneAssoluta = $_GET['posizioneAssoluta'];
$totaleAssoluti = $_GET['totaleAssoluti'];
$posizioneAssolutaFemminile = $_GET['posizioneAssolutaFemminile'];
$posizioneCategoria = $_GET['posizioneCategoria'];
$totaleCategoria = $_GET['totaleCategoria'];
$stagione = $_GET['stagione'];


if (isset($idPresenza)) {
	$cmd = "
		update presenza set 
			id_atleta 			= :idAtleta,
			id_gara 			= :idGara, 
			id_tipologia_gara	= :idTipologiaGara, 
			id_stagione			= :stagione, 
			POSIZIONE_ASSOLUTA	= :posizioneAssoluta, 
			TOTALE_ASSOLUTI		= :totaleAssoluti, 
			POSIZIONE_CATEGORIA	= :posizioneCategoria, 
			TOTALE_CATEGORIA	= :totaleCategoria, 
			BONUS				= :bonus, 
			modified			= :modified
		where
			id_presenza			= :idPresenza" ;
} else {
	$cmd = "
		insert into presenza (
			id_atleta, id_gara, id_tipologia_gara, id_stagione, 
			POSIZIONE_ASSOLUTA, TOTALE_ASSOLUTI, POSIZIONE_CATEGORIA, 
			TOTALE_CATEGORIA, BONUS, created, modified) 

		values (
			:idAtleta, :idGara, :idTipologiaGara, :stagione, 
			:posizioneAssoluta, :totaleAssoluti, :posizioneCategoria, 
			:totaleCategoria, :bonus, :created, :modified)" ;
}
$result = $conn->prepare($cmd);


$result->bindValue(":idAtleta", $idAtleta);
$result->bindValue(":idGara", $idGara);
$result->bindValue(":idTipologiaGara", $idTipologiaGara);
$result->bindValue(":stagione", $stagione);
$result->bindValue(":posizioneAssoluta", $posizioneAssoluta);
$result->bindValue(":totaleAssoluti", $totaleAssoluti);
$result->bindValue(":posizioneCategoria", $posizioneCategoria);
$result->bindValue(":totaleCategoria", $totaleCategoria);
$result->bindValue(":bonus", $bonus);
$result->bindValue(":modified", $modified);
if (isset($idPresenza)) { 
	$result->bindValue(":idPresenza", $idPresenza);
} else {
	$result->bindValue(":created", $created);
}

$result->execute();

$conn = NULL;

?>
