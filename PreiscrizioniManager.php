<?php

require_once("dblib.php");
require_once("clublib.php");

class PreiscrizioniManager {
	
    function lista ($codiceGara) {
		$query = 
			"
				select 
					p.ID as ID,
					p.COGNOME_ATLETA as COGNOME_ATLETA, 
					p.NOME_ATLETA as NOME_ATLETA, 
					p.SESSO_ATLETA as SESSO_ATLETA,
					p.ANNO_NASCITA_ATLETA as ANNO_NASCITA_ATLETA,
					p.CATEGORIA_ATLETA as CATEGORIA_ATLETA,
					p.CODICE_FIDAL_ATLETA as CODICE_FIDAL_ATLETA,
					p.NOME_SOCIETA as NOME_SOCIETA,
					p.CODICE_SOCIETA as CODICE_SOCIETA,
					p.EMAIL_ATLETA as EMAIL_ATLETA,
					p.ID_GARA as ID_GARA,
					g.NOME as GARA, 
					p.CREATED as CREATED,
					p.MODIFIED as MODIFIED
				from 
					preiscrizioni p, gara g
				where
					p.codice_gara = ".$codiceGara."
					and p.id_gara = g.id
				order by p.CREATED
			";
		echo $query;
        return connetti_query($query);
    }
	
	function inserisci (
			$cognomeAtleta, $nomeAtleta, $sessoAtleta, $annoNascitaAtleta, 
			$categoriaAtleta, $codiceFidalAtleta, $codiceFidalSocieta, $nomeSocieta, 
			$idGara, $codiceGara, $emailAtleta) {
	
		include "funzioni_mysql.php";
		
		$t = "preiscrizioni"; # nome della tabella
		$v = array ($cognomeAtleta,$nomeAtleta,$sessoAtleta,$annoNascitaAtleta, 
			$categoriaAtleta, $codiceFidalAtleta, $codiceFidalSocieta, $nomeSocieta, 
			$idGara, $codiceGara, $emailAtleta, date("Y-m-d h:i:s"),
			date("Y-m-d h:i:s")); # valori da inserire
		$r =  "cognome_atleta,nome_atleta,sesso_atleta,anno_nascita_atleta,
			categoria_atleta, codice_fidal_atleta, codice_societa, 
			nome_societa, id_gara, codice_gara, email_atleta, created,modified"; # campi da popolare
		
		$data = new MysqlClass();
		$data->connetti();
		$data->inserisci($t,$v,$r);
		$data->disconnetti();
	}
	
	function cancella ($idPreiscrizioni) {	
		$query = "delete from preiscrizioni where ID = ".$idPreiscrizioni;
        return connetti_query($query);
	}
	
}
?>