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

	$cmd = "
		select 
			p.ID as ID,
			a.ID as ID_ATLETA,
			a.NOME as NOME_ATLETA, 
			a.COGNOME as COGNOME_ATLETA, 
			g.ID as ID_GARA,
			g.NOME as NOME_GARA,
			g.LOCALITA as LOCALITA_GARA,
			g.DATA as DATA_GARA,
			tg.ID as ID_TIPOLOGIA_GARA,
			tg.TIPO as TIPOLOGIA_GARA_DESCRIZIONE,
			tg.PUNTEGGIO as TIPOLOGIA_GARA_PUNTEGGIO,
			s.ID as ID_STAGIONE,
			s.ANNO as ANNO
		from 
			presenza p,
			atleta a,
			gara g,
			tipologia_gara tg,
			stagione s
		where 
			p.ID_ATLETA = a.ID
			and p.ID_GARA = g.ID
			and p.ID_TIPOLOGIA_GARA = tg.ID
			and p.ID_STAGIONE = s.ID
			and s.ID = ".$idStagione."
		group by p.ID
		order by g.DATA desc, g.NOME, a.COGNOME";

	$result = $conn->prepare($cmd);
	$result->execute();
	$return_arr = array();
	$row_array = array();

	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$row_array['id'] = utf8_encode($row['ID']);
		$row_array['idAtleta'] = utf8_encode($row['ID_ATLETA']);
		$row_array['nomeAtleta'] = utf8_encode($row['NOME_ATLETA']);
		$row_array['cognomeAtleta'] = utf8_encode($row['COGNOME_ATLETA']);
		$row_array['idGara'] = utf8_encode($row['ID_GARA']);
		$row_array['nomeGara'] = utf8_encode($row['NOME_GARA']);
		$row_array['localitaGara'] = utf8_encode($row['LOCALITA_GARA']);
		$row_array['dataGara'] = utf8_encode($row['DATA_GARA']);
		$row_array['tipologiaGara'] = utf8_encode($row['ID_TIPOLOGIA_GARA']);
		$row_array['tipologiaGaraDescrizione'] = utf8_encode($row['TIPOLOGIA_GARA_DESCRIZIONE']);
		$row_array['tipologiaGaraPunteggio'] = utf8_encode($row['TIPOLOGIA_GARA_PUNTEGGIO']);
		$row_array['idStagione'] = utf8_encode($row['ID_STAGIONE']);
		$row_array['anno'] = utf8_encode($row['ANNO']);
		array_push($return_arr,$row_array);
	}
	
	$conn = NULL;
	
	echo json_encode($return_arr);
	
} catch(PDOException $e) {
	echo $e->getMessage();
}


?>