<?php
/*
require_once("../PresenzaManager.php");
$PresenzaManager = new PresenzaManager();

try {

	$idPresenza = $_GET['idPresenza']; 
	$idAtleta = $_GET['idAtleta']; 
	$idGara = $_GET['idGara'];
	$idTipologiaGara = $_GET['idTipologiaGara'];
	$posizioneAssoluta = $_GET['posizioneAssoluta'];
	$totaleAssoluti = $_GET['totaleAssoluti'];
	$posizioneAssolutaFemminile = $_GET['posizioneAssolutaFemminile'];
	$posizioneCategoria = $_GET['posizioneCategoria'];
	$totaleCategoria = $_GET['totaleCategoria'];
	$stagione = $_GET['idStagioneSessione'];

	$created = date("Y-m-d H:i:s");
	$modified = date("Y-m-d H:i:s");

	$bonus = '';

	if (isset($idPresenza) and $idPresenza != '') {
		
		PresenzaManager::modifica(
					$idPresenza, 
					$idAtleta, 
					$idGara,  
					$stagione,
					$idTipologiaGara);
		
	} else {

		PresenzaManager::inserisci(
					$idAtleta, 
					$idGara, 
					$stagione,
					$idTipologiaGara);
		
	}


} catch(Exception $e) {
	echo $e->getMessage();
}
*/

require_once("../ConfigManager.php");
$ConfigManager = new ConfigManager();
$dbhost = $ConfigManager->getHost ();
$dbuser = $ConfigManager->getUser ();
$dbname = $ConfigManager->getDatabase ();
$dbpass = $ConfigManager->getPassword ();

try {
$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);


$idPresenza = $_GET['idPresenza']; 
$idAtleta = $_GET['idAtleta']; 
$idGara = $_GET['idGara'];
$idTipologiaGara = $_GET['idTipologiaGara'];
$posizioneAssoluta = $_GET['posizioneAssoluta'];
$totaleAssoluti = $_GET['totaleAssoluti'];
$posizioneAssolutaFemminile = $_GET['posizioneAssolutaFemminile'];
$posizioneCategoria = $_GET['posizioneCategoria'];
$totaleCategoria = $_GET['totaleCategoria'];
	$stagione = $_GET['idStagioneSessione'];

	$created = date("Y-m-d H:i:s");
	$modified = date("Y-m-d H:i:s");

	$bonus = '';

	$conn->beginTransaction();

	if (isset($idPresenza) and $idPresenza != '') {
		$sql = "
		update presenza set 
				id_atleta 			= ?,
				id_gara 			= ?, 
				id_tipologia_gara	= ?, 
				id_stagione			= ?, 
				POSIZIONE_ASSOLUTA	= ?, 
				TOTALE_ASSOLUTI		= ?, 
				POSIZIONE_CATEGORIA	= ?, 
				TOTALE_CATEGORIA	= ?, 
				BONUS				= ?, 
				modified			= ?
		where
				id					= ?";
		
		$statement = $conn->prepare($sql);	
		$statement->execute(
			array(
				$idAtleta, $idGara, $idTipologiaGara, $stagione, $posizioneAssoluta, $totaleAssoluti,
				$posizioneCategoria, $totaleCategoria, $bonus, $modified, $idPresenza));
		
} else {
		
		$sql = "
		insert into presenza (
			id_atleta, id_gara, id_tipologia_gara, id_stagione, 
			POSIZIONE_ASSOLUTA, TOTALE_ASSOLUTI, POSIZIONE_CATEGORIA, 
			TOTALE_CATEGORIA, BONUS, created, modified) 

		values (
			:idAtleta, :idGara, :idTipologiaGara, :stagione, 
			:posizioneAssoluta, :totaleAssoluti, :posizioneCategoria, 
			:totaleCategoria, :bonus, :created, :modified)" ;
				
		$statement = $conn->prepare($sql);
		$statement->execute(
			array(
				':idAtleta'=>$idAtleta,
				':idGara'=>$idGara,
				':idTipologiaGara'=>$idTipologiaGara,
				':stagione'=>$stagione,
				':posizioneAssoluta'=>$posizioneAssoluta,
				':totaleAssoluti'=>$totaleAssoluti,
				':posizioneCategoria'=>$posizioneCategoria,
				':totaleCategoria'=>$totaleCategoria,
				':bonus'=>$bonus,
				':modified'=>$modified,
				':created'=>$created
			)
		);
		
}

	$conn->commit();

} catch(PDOException $e) {
	echo $e->getMessage();
}

$conn = NULL;

?>
