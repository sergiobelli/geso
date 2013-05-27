<?php

//require_once("Config.php");

//require_once ("util/Log.php");
require_once("ConfigManager.php");


function sendMail($changeType, $change) {

	if ($_SERVER['SERVER_NAME'] != '127.0.0.1') {

	  //$result = connetti_query();

	  $intestazione  = "MIME-Version: 1.0\r\n";

	  $intestazione .= "Content-type: text/html; charset=iso-8859-1\r\n";

	  $intestazione .= "From: info@$SERVER_NAME";

	  //mail("sergio.belli@email.it", $changeType, $change, $intestazione);

  }

}









//connectToDB();

function connectToDB() {
	global $link, $Host, $Database, $User, $Password;
	$link = mysql_pconnect($Host, $User, $Password);
	if (! $link) 
		die("Impossibile connettersi a MySql");
	mysql_select_db( $Database, $link)
  	or die ("Impossibile connettersi al database");

}



function getRow( $table, $fnm, $fval) {

    /*global $link;

    $result = mysql_query("SELECT * FROM $table WHERE $fnm = '$fval'", $link);

    if (!$result) {

        die("Errore di getRow: ".mysql_error());

    }*/

    $result = connetti_query("SELECT * FROM $table WHERE $fnm = '$fval'");

    return mysql_fetch_array($result);

}





function connetti_query($query) {

    global $Host,$User,$Password,$Database,$link;

$ConfigManager = new ConfigManager();
$Host = $ConfigManager->getHost ();
$User = $ConfigManager->getUser ();
$Database = $ConfigManager->getDatabase ();
$Password = $ConfigManager->getPassword ();

    // Connessione al database 

    if ( !( $link = mysql_connect( $Host, $User, $Password ) ) ) {

      die( "Errore nella connessione al database! -> " . mysql_error() );

    }

            

    // Apertura del database
    if ( !mysql_select_db( $Database, $link ) ) {

      die( "Errore nell'apertura del database mba!"  . mysql_error());
    }

    

    // Esucuzione della query

    if ( !( $result = mysql_query( $query, $link ) ) ) {

      print( "Errore nell'esecuzione della query! <br />" );

      die( mysql_error() );

    }

    

    //chiusura del collegamento al database

    mysql_close( $link );

		

    //restituzione all'ambiente chiamante del risultato della query

    return $result;

}





// funzione che compone una query con i parametri: tabella, where, orderby, limit e passo (riga di inizio e n. record)

// restituisce la risorsa



function dynQuery ($select, $tabella, $where=1, $orderby=2, $limit=0, $passo=40)

	{

	global $link, $session;

	

	if ($orderby == '2 ')

	{

		$query = "SELECT $select FROM $tabella WHERE $where LIMIT $limit, $passo";

	}

	 else

	{	

		$query = "SELECT $select FROM $tabella WHERE $where ORDER BY $orderby LIMIT $limit, $passo";

	}



	$result = connetti_query($query);	



	if (! $result )

		{

		// questo e' buono per il debug

		$result = "<br>Errore nell'esecuzione di <b>dynQuery</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	// print $query;	// per visualizzare la query - debug

	return $result;

	}





// funzione che svincola il fetching dal DBMS specifico, questa funziona con mysql

function dbms_fetch_array ($resource)

	{

	$result = mysql_fetch_array($resource);	

	return $result;

	}

	

	

function configInsert ($Ragione_Sociale,$Cognome, $Nome, $PI, $CF, $Indirizzo, $Citta, $CAP, $Provincia, $Telefono, $Telefono2, $Telefono3,$Fax, $Cell, $E_mail,$Web)

	{

	global $link, $config_table;

	$query = "	INSERT INTO ".$config_table." 

	(

	Ragione_Sociale, 

	Cognome, 

	Nome, 

	PI, 

	CF, 

	Indirizzo, 

	Citta, 

	CAP, 

	Provincia, 

	Telefono, 

	Telefono2, 

	Telefono3, 

	Fax, 

	Cell, 

	E_mail, 

	Web

)

	VALUES 

(

	'$Ragione_Sociale', 

	'$Cognome', 

	'$Nome', 

	'$PI', 

	'$CF', 

	'$Indirizzo', 

	'$Citta', 

	'$CAP', 

	'$Provincia', 

	'$Telefono', 

	'$Telefono2', 

	'$Telefono3', 	

	'$Fax', 

	'$Cell', 

	'$E_mail', 

	'$Web'

	)";

	$result = connetti_query($query);	

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>configInsert</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	return $result;

	}



	

	

function configUpdate($ID_Azienda, $Ragione_Sociale, $Cognome, $Nome, $PI, $CF, $Indirizzo, $Citta, $CAP, $Provincia, $Telefono, $Telefono2, $Telefono3, $Fax, $Cell, $E_mail, $Web)

	{

	global $link, $config_table;

	$query = "UPDATE ".$config_table." 

	SET 

	Ragione_Sociale='$Ragione_Sociale', 

	Cognome='$Cognome', 

	Nome='$Nome', 

	PI='$PI',

	CF='$CF', 

	Indirizzo='$Indirizzo', 

	Citta='$Citta',

	CAP='$CAP', 

	Provincia='$Provincia', 

	Telefono='$Telefono', 

	Telefono2='$Telefono2', 

	Telefono3='$Telefono3', 

	Fax='$Fax', 

	Cell='$Cell',

	E_mail='$E_mail', 

	Web='$Web' 

	WHERE 

	ID_Azienda='$ID_Azienda'";

	$result = connetti_query ($query);

	if (! $result )

		die ("errore di aggiornamento ".mysql_error() );

	

	}			

	

	

	

function clientInsert ($Ragione_Sociale,$Cognome, $Nome,$PI,$CF, $Indirizzo,$Citta, $CAP, $Provincia, $Telefono, $Telefono2, $Telefono3,$Fax, $Cell,$E_mail,$Password,$Web)

	{

	global $link, $customers_table;

	$query = "	INSERT INTO ".$customers_table." 

	(

	Ragione_Sociale, 

	Cognome, 

	Nome, 

	PI, 

	CF, 

	Indirizzo, 

	Citta, 

	CAP, 

	Provincia, 

	Telefono, 

	Telefono2, 

	Telefono3, 

	Fax, 

	Cell, 

	E_mail, 

	Password, 

	Web

)

	VALUES 

(

	'$Ragione_Sociale', 

	'$Cognome', 

	'$Nome', 

	'$PI', 

	'$CF', 

	'$Indirizzo', 

	'$Citta', 

	'$CAP', 

	'$Provincia', 

	'$Telefono', 

	'$Telefono2', 

	'$Telefono3', 	

	'$Fax', 

	'$Cell', 

	'$E_mail', 

	'$Password', 

	'$Web'

	)";

	$result = connetti_query($query);	

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>dynQuery</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	return $result;

	}



function subjectInsert ($Ragione_Sociale,$Cognome, $Nome,$PI,$CF, $Indirizzo,$Citta, $CAP, $Provincia, $Telefono, $Telefono2, $Telefono3,$Fax, $Cell,$E_mail,$Password,$Web,$Privacy)

	{

	global $link, $subject_table;

	$query = "	INSERT INTO ".$subject_table." 

	(

	Ragione_Sociale, 

	Cognome, 

	Nome, 

	PI, 

	CF, 

	Indirizzo, 

	Citta, 

	CAP, 

	Provincia, 

	Telefono, 

	Telefono2, 

	Telefono3, 

	Fax, 

	Cell, 

	E_mail, 

	Password, 

	Web,

  Privacy

)

	VALUES 

(

	'$Ragione_Sociale', 

	'$Cognome', 

	'$Nome', 

	'$PI', 

	'$CF', 

	'$Indirizzo', 

	'$Citta', 

	'$CAP', 

	'$Provincia', 

	'$Telefono', 

	'$Telefono2', 

	'$Telefono3', 	

	'$Fax', 

	'$Cell', 

	'$E_mail', 

	'$Password', 

	'$Web',

  '$Privacy'

	)";

	$result = connetti_query($query);	

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>dynQuery</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

		

 		$conf = array('mode' => 0600, 'timeFormat' => '%X %x');

		//$logger = &Log::singleton('file', 'logs/sd_soggetti.log', 'ident', $conf);

		//$logger->log("logged ".$query);

				

	return $result;

	}



function supplierInsert ($Ragione_Sociale,$Cognome, $Nome,$PI,$CF, $Indirizzo,$Citta, $CAP,$Provincia, $Telefono, $Telefono2, $Telefono3,$Fax, $Cell,$E_mail,$Password,$Web)

	{

	global $link, $suppliers_table;

	$query = "	INSERT INTO ".$suppliers_table." 

	(

	Ragione_Sociale, 

	Cognome, 

	Nome, 

	PI, 

	CF, 

	Indirizzo, 

	Citta, 

	CAP, 

	Provincia, 

	Telefono, 

	Telefono2, 

	Telefono3, 

	Fax, 

	Cell, 

	E_mail, 

	Password, 

	Web

)

	VALUES 

(

	'$Ragione_Sociale', 

	'$Cognome', 

	'$Nome', 

	'$PI', 

	'$CF', 

	'$Indirizzo', 

	'$Citta', 

	'$CAP', 

	'$Provincia', 

	'$Telefono', 

	'$Telefono2', 

	'$Telefono3', 	

	'$Fax', 

	'$Cell', 

	'$E_mail', 

	'$Password', 

	'$Web'

	)";

	$result = connetti_query($query);	

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>dynQuery</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	return $result;

	}

	

		

function clientUpdate($ID_Cliente, $Ragione_Sociale, $Cognome, $Nome, $PI, $CF, $Indirizzo, $Citta, $CAP, $Provincia, $Telefono, $Telefono2, $Telefono3, $Fax, $Cell, $Password, $Web, $E_Mail)

	{

	global $link, $customers_table;

	$query = "UPDATE ".$customers_table." 

	SET 

	Ragione_Sociale='$Ragione_Sociale', 

	Cognome='$Cognome', 

	Nome='$Nome', 

	PI='$PI',

	CF='$CF', 

	Indirizzo='$Indirizzo', 

	Citta='$Citta',

	CAP='$CAP', 

	Provincia='$Provincia', 

	Telefono='$Telefono', 

	Telefono2='$Telefono2', 

	Telefono3='$Telefono3', 

	Fax='$Fax', 

	Cell='$Cell',

	E_Mail='$E_Mail', 

	Password='$Password', 

	Web='$Web' 

	WHERE 

	ID_Cliente='$ID_Cliente'";

	$result = connetti_query ($query);

	if (! $result )

		die ("errore di aggiornamento ".mysql_error() );

	

	}		



function subjectUpdate($ID_Soggetto, $Ragione_Sociale, $Cognome, $Nome, $PI, $CF, $Indirizzo, $Citta, $CAP, $Provincia, $Telefono, $Telefono2, $Telefono3, $Fax, $Cell, $Password, $Web, $E_Mail, $Privacy)

	{

	global $link, $subject_table;

	$query = "UPDATE ".$subject_table." 

	SET 

	Ragione_Sociale='$Ragione_Sociale', 

	Cognome='$Cognome', 

	Nome='$Nome', 

	PI='$PI',

	CF='$CF', 

	Indirizzo='$Indirizzo', 

	Citta='$Citta',

	CAP='$CAP', 

	Provincia='$Provincia', 

	Telefono='$Telefono', 

	Telefono2='$Telefono2', 

	Telefono3='$Telefono3', 

	Fax='$Fax', 

	Cell='$Cell',

	E_Mail='$E_Mail', 

	Password='$Password', 

	Web='$Web',

  Privacy = '$Privacy'

	WHERE 

	ID_Soggetto='$ID_Soggetto'";

	$result = connetti_query ($query);

	if (! $result )

		die ("errore di aggiornamento ".mysql_error() );

	

	 		$conf = array('mode' => 0600, 'timeFormat' => '%X %x');

		//$logger = &Log::singleton('file', 'logs/sd_soggetti.log', 'ident', $conf);

		//$logger->log("logged ".$query);

	}	

  

function supplierUpdate($ID_Fornitore, $Ragione_Sociale, $Cognome, $Nome, $PI, $CF, $Indirizzo, $Citta, $CAP, $Provincia, $Telefono, $Telefono2, $Telefono3, $Fax, $Cell, $Password, $Web, $E_Mail)

	{

	global $link, $suppliers_table;

	$query = "UPDATE ".$suppliers_table." 

	SET 

	Ragione_Sociale='$Ragione_Sociale', 

	Cognome='$Cognome', 

	Nome='$Nome', 

	PI='$PI',

	CF='$CF', 

	Indirizzo='$Indirizzo', 

	Citta='$Citta',

	CAP='$CAP', 

	Provincia='$Provincia', 

	Telefono='$Telefono', 

	Telefono2='$Telefono2', 

	Telefono3='$Telefono3', 

	Fax='$Fax', 

	Cell='$Cell',

	E_Mail='$E_Mail', 

	Password='$Password', 

	Web='$Web' 

	WHERE 

	ID_Fornitore='$ID_Fornitore'";

	$result = connetti_query ($query);

	if (! $result )

		die ("errore di aggiornamento ".mysql_error() );

	

	}		

	

	

	

function orderInsert ($ID_Cliente, $Protocollo, $Oggetto, $Data_Ordine, $Data_Scadenza, $Tipo_Pagamento, $Prezzo, $Iva, $Ragione_Sociale, $Cognome, $Nome, $PI, $CF, $Indirizzo, $Citta, $CAP, $Provincia, $Telefono, $Fax, $E_mail, $Status)

	{

	global $link, $orders_table;

	$query = "	INSERT INTO ".$orders_table." 

	(

	ID_Cliente,

	Protocollo,

	Oggetto,

	Data_Ordine,

	Data_Scadenza,

	Tipo_Pagamento,

	Prezzo,

	Iva,

	Ragione_Sociale, 

	Cognome, 

	Nome, 

	PI, 

	CF, 

	Indirizzo, 

	Citta, 

	CAP, 

	Provincia, 

	Telefono, 

	Fax, 

	E_mail,

	Status

)

	VALUES 

(

	'$ID_Cliente',

	'$Protocollo',

	'$Oggetto',

	'$Data_Ordine',

	'$Data_Scadenza',

	'$Tipo_Pagamento',

	'$Prezzo',

	'$Iva',

	'$Ragione_Sociale', 

	'$Cognome', 

	'$Nome', 

	'$PI', 

	'$CF', 

	'$Indirizzo', 

	'$Citta', 

	'$CAP', 

	'$Provincia', 

	'$Telefono', 

	'$Fax', 

	'$E_mail',

	'$Status'

	)";

	$result = connetti_query($query);	

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>orderInsert</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	return $result;

	}	

	

	

function orderUpdate($ID_Ordine, $ID_Cliente, $Protocollo, $Oggetto, $ID_Fattura, $Data_Ordine, $Data_Scadenza, $Tipo_Pagamento, $Prezzo, $Iva, $Ragione_Sociale, $Cognome, $Nome, $PI, $CF, $Indirizzo, $Citta, $CAP, $Provincia, $Telefono, $Fax, $E_mail, $Status)

	{

	global $link, $orders_table;

	$query = "UPDATE ".$orders_table." 

	SET 

	ID_Cliente='$ID_Cliente',

	Protocollo='$Protocollo',

	Oggetto='$Oggetto',

	ID_Fattura='$ID_Fattura',

	Data_Ordine='$Data_Ordine',

	Data_Scadenza='$Data_Scadenza',

	Tipo_Pagamento='$Tipo_Pagamento',

	Prezzo='$Prezzo',

	Iva='$Iva',

	Ragione_Sociale='$Ragione_Sociale', 

	Cognome='$Cognome', 

	Nome='$Nome', 

	PI='$PI',

	CF='$CF', 

	Indirizzo='$Indirizzo', 

	Citta='$Citta',

	CAP='$CAP', 

	Provincia='$Provincia', 

	Telefono='$Telefono', 

	Fax='$Fax', 

	E_mail='$E_mail',

	Status='$Status'

	WHERE 

	ID_Ordine='$ID_Ordine'";

	$result = connetti_query ($query);

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>orderUpdate</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	return $result;

	

	}		



function bankInsert ($Banca, $Indirizzo, $Agenzia, $Abi, $Cab, $Conto, $Titolare)

	{

	global $link, $bank_table;

	$query = "	INSERT INTO ".$bank_table." 

	(

	Banca, 

	Indirizzo, 

	Agenzia, 

	Abi, 

	Cab, 

	Conto, 

	Titolare

)

	VALUES 

(

	'$Banca', 

	'$Indirizzo', 

	'$Agenzia', 

	'$Abi', 

	'$Cab', 

	'$Conto', 

	'$Titolare'

	)";

	$result = connetti_query($query);	

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>dynQuery</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	return $result;

	}		

	

function bankUpdate($ID_Banca, $Banca, $Agenzia, $Indirizzo, $Abi, $Cab, $Conto, $Titolare)

	{

	global $link, $bank_table;

	

	$Indirizzo = addslashes($Indirizzo); // aggiunge i caratteri di escape dove serve

	// todo: implementare una funzione che passeggia sull'array facendo il trim e 

	// lo slash davanti ai caratteri che necessitano

				

	$query = "UPDATE ".$bank_table." 

	SET 

	Banca='$Banca',

	Agenzia='$Agenzia',

	Indirizzo='$Indirizzo',

	Abi='$Abi',

	Cab='$Cab',

	Conto='$Conto',

	Titolare='$Titolare'

	WHERE 

	ID_Banca='$ID_Banca'";

	$result = connetti_query ($query);

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>bankUpdate</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	// print $query;

	return $result;

	

	}	

	

function invoiceInsert ($Prog_Fattura_Annuo, $ID_Cliente, $ID_Banca, $Data_Fattura, $Ragione_Sociale, $PI, $Indirizzo, $Citta, $CAP, $Provincia, $Totale, $Tipo_Pagamento, $Scadenza)

	{

	global $link, $invoices_table;

	$query = "	INSERT INTO ".$invoices_table." 

	(

	Prog_Fattura_Annuo,

	ID_Cliente,

	ID_Banca,

	Data_Fattura,

	Ragione_Sociale,

	PI,

	Indirizzo,

	Citta,

	CAP,

	Provincia,

	Totale,

	Tipo_Pagamento,

	Scadenza

	)

		VALUES 

	(

	'$Prog_Fattura_Annuo',

	'$ID_Cliente',

	'$ID_Banca',

	'$Data_Fattura',

	'$Ragione_Sociale',

	'$PI',

	'$Indirizzo',

	'$Citta',

	'$CAP',

	'$Provincia',

	'$Totale', 

	'$Tipo_Pagamento', 

	'$Scadenza'

	)";

	$result = connetti_query($query);	

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>invoiceInsert</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	return $result;

	}	

	

function noteInsert ($Prog_Nota_Annuo, $ID_Fattura, $ID_Cliente, $Ragione_Sociale, $PI, $Indirizzo, $Citta, $CAP, $Provincia, $Data_Nota, $Descrizione, $Iva, $Totale, $Note)

	{

	global $link, $credit_notes_table;

	$query = "	INSERT INTO ".$credit_notes_table." 

	(

	Prog_Nota_Annuo,

	ID_Fattura,

	ID_Cliente,

	Ragione_Sociale, 

	PI, 

	Indirizzo, 

	Citta, 

	CAP, 

	Provincia, 

	Data_Nota,

	Descrizione,

	Iva,

	Totale,

	Note

	)

		VALUES 

	(

	'$Prog_Nota_Annuo',

	'$ID_Fattura',

	'$ID_Cliente',

	'$Ragione_Sociale', 

	'$PI', 

	'$Indirizzo', 

	'$Citta', 

	'$CAP', 

	'$Provincia', 

	'$Data_Nota',

	'$Descrizione', 

	'$Iva', 

	'$Totale',

	'$Note'

	)";

	$result = connetti_query($query);	

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>noteInsert</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	return $result;

	}	

	

function spl_invoiceInsert ($ID_Fornitore, $N_Fattura, $Data_Fattura, $Ragione_Sociale, $PI, $Indirizzo, $Citta, $CAP, $Provincia, $Descrizione, $Totale, $Imposta, $Tipo_Pagamento, $Data_Scadenza, $Note)

	{

	global $link, $spl_invoices_table;

	$query = "	INSERT INTO ".$spl_invoices_table." 

	(

	ID_Fornitore, 

	N_Fattura, 

	Data_Fattura, 

	Ragione_Sociale, 

	PI, 

	Indirizzo, 

	Citta, 

	CAP, 

	Provincia, 

	Descrizione, 

	Totale, 

	Imposta, 

	Tipo_Pagamento, 

	Scadenza, 

	Note

)

	VALUES 

(

	'$ID_Fornitore', 

	'$N_Fattura', 

	'$Data_Fattura', 

	'$Ragione_Sociale', 

	'$PI', 

	'$Indirizzo', 

	'$Citta', 

	'$CAP', 

	'$Provincia', 

	'$Descrizione', 

	'$Totale', 

	'$Imposta', 

	'$Tipo_Pagamento', 

	'$Data_Scadenza', 

	'$Note'

	)";

	$result = connetti_query($query);	

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>spl_invoiceInsert</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	return $result;

	}	

	

function spl_invoiceUpdate($ID_Fattura_Acquisto, $ID_Fornitore, $N_Fattura, $Data_Fattura, $Ragione_Sociale, $PI, $Indirizzo, $Citta, $CAP, $Provincia, $Descrizione, $Totale, $Imposta, $Tipo_Pagamento, $Data_Scadenza, $Note)

	{

	global $link, $spl_invoices_table;

	$query = "UPDATE ".$spl_invoices_table." 

	SET 

	ID_Fattura_Acquisto = '$ID_Fattura_Acquisto',

	ID_Fornitore = '$ID_Fornitore', 

	N_Fattura = '$N_Fattura',

	Data_Fattura = '$Data_Fattura',

	Ragione_Sociale='$Ragione_Sociale', 

	PI='$PI',

	Indirizzo='$Indirizzo', 

	Citta='$Citta',

	CAP='$CAP', 

	Provincia='$Provincia', 

	Descrizione = '$Descrizione', 

	Totale = '$Totale', 

	Imposta = '$Imposta', 

	Tipo_Pagamento = '$Tipo_Pagamento', 

	Scadenza = '$Data_Scadenza', 

	Note = '$Note'

	WHERE 

	ID_Fattura_Acquisto='$ID_Fattura_Acquisto'";

	$result = connetti_query ($query);

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>spl_invoiceUpdate</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	return $result;

	

	}		

			

			

function spl_noteInsert ($ID_Fornitore, $N_Nota, $ID_Fattura_Acquisto, $Data_Nota, $Ragione_Sociale, $PI, $Indirizzo, $Citta, $CAP, $Provincia, $Descrizione, $Totale, $Imposta, $Tipo_Pagamento, $Note)

	{

	global $link, $spl_credit_notes_table;

	$query = "	INSERT INTO ".$spl_credit_notes_table." 

	(

	ID_Fornitore, 

	N_Nota, 

	ID_Fattura_Acquisto,

	Data_Nota, 

	Ragione_Sociale, 

	PI, 

	Indirizzo, 

	Citta, 

	CAP, 

	Provincia, 

	Descrizione, 

	Totale, 

	Imposta, 

	Tipo_Pagamento, 

	Note

)

	VALUES 

(

	'$ID_Fornitore', 

	'$N_Nota',

	'$ID_Fattura_Acquisto', 

	'$Data_Nota', 

	'$Ragione_Sociale', 

	'$PI', 

	'$Indirizzo', 

	'$Citta', 

	'$CAP', 

	'$Provincia', 

	'$Descrizione', 

	'$Totale', 

	'$Imposta', 

	'$Tipo_Pagamento', 

	'$Note'

	)";

	$result = connetti_query($query);	

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>spl_noteInsert</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	return $result;

	}	

function spl_noteUpdate ($ID_Nota, $ID_Fornitore, $N_Nota, $ID_Fattura_Acquisto, $Data_Nota, $Ragione_Sociale, $PI, $Indirizzo, $Citta, $CAP, $Provincia, $Descrizione, $Totale, $Imposta, $Tipo_Pagamento, $Note)

	{

	global $link, $spl_credit_notes_table;

	$query = "	UPDATE ".$spl_credit_notes_table." SET

	

	ID_Fornitore = '$ID_Fornitore', 

	N_Nota = '$N_Nota',

	ID_Fattura_Acquisto = '$ID_Fattura_Acquisto', 

	Data_Nota = '$Data_Nota', 

	Ragione_Sociale = '$Ragione_Sociale', 

	PI = '$PI', 

	Indirizzo = '$Indirizzo', 

	Citta = '$Citta', 

	CAP = '$CAP', 

	Provincia = '$Provincia',

	Descrizione = '$Descrizione', 

	Totale = '$Totale', 

	Imposta = '$Imposta', 

	Tipo_Pagamento = '$Tipo_Pagamento',

	Note = '$Note'

	

	WHERE 

	

	ID_Nota = '$ID_Nota'

	";

	$result = connetti_query($query);	

	if (! $result )

		{

		$result = "<br>Errore nell'esecuzione di <b>spl_noteInsert</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

		print $result;

		}

	return $result;

	}				

	



function tesInsert (

					$ID_Soggetto,

          $ID_Soggetto_Promotore,

					$Data_Competenza,					

					$Importo_Versato,

					$Validita,

					$ID_Tipo_Socio,

          $ID_Movimento

					) 

{

  global $link, $tes_table;

  $query = "	INSERT INTO ".$tes_table." 

  (

    ID_Soggetto,

    ID_Promotore,

    Data_Tessera,					

    Importo_Versato,

    Validita,

    Tipo_Socio,

    ID_Movimento

  ) VALUES (

    $ID_Soggetto,

    $ID_Soggetto_Promotore,

    '$Data_Competenza',					

    $Importo_Versato,

    $Validita,

    $ID_Tipo_Socio,

    $ID_Movimento

  )";

  

  $result = connetti_query($query);	

  if (! $result ) {

    $result = "<br>Errore nell'esecuzione di <b>tesInsert</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

    print $result;

  } else {

    $change  = "ID_Soggetto=".$ID_Soggetto;

    $change .= "\n ID_Soggetto_Promotore= ".$ID_Soggetto_Promotore;

    $change .= "\n Data_Tessera= ".$Data_Competenza;

    $change .= "\n Importo_Versato= ".$Importo_Versato;

    $change .= "\n Validita= ".$Validita;

    $change .= "\n Tipo_Socio= ".$Tipo_Socio;

    $change .= "\n ID_Movimento= ".$ID_Movimento;

    

 		$conf = array('mode' => 0600, 'timeFormat' => '%X %x');

		//$logger = &Log::singleton('file', 'logs/sd_tesseramenti.log', 'ident', $conf);

		//$logger->log("logged ".$query);



    sendMail("Insert sd_tesseramenti", $change);

  }

  

  return $result;

}



function movInsert (

					$ID_Soggetto,

					//$Ragione_Sociale,

					$Data_Valuta,

					$Data_Competenza,	

					$Anno_Bilancio,					

					$Tipo_Pagamento,

					$Entrate,

					$Uscite,

					$ID_Banca,

					$ID_Voce_Bilancio,					

					$Descrizione,

					$Admin_logged

					) 

{

  global $link, $mov_table;

  $query = "	INSERT INTO ".$mov_table." 

  (

  ID_Soggetto, 

  Data_Valuta, 

  Data_Competenza,

  Anno_Bilancio,

  Tipo_Pagamento,

  Entrate, 

  Uscite, 

  ID_Banca, 

  ID_Voce_Bilancio,

  Descrizione,

  ID_Admin

  ) VALUES (

   '$ID_Soggetto',

   '$Data_Valuta',

   '$Data_Competenza',

   '$Anno_Bilancio',

   '$Tipo_Pagamento',

   '$Entrate',

   '$Uscite',

   '$ID_Banca',

   '$ID_Voce_Bilancio',

   '$Descrizione',

   '$Admin_logged' 

  )";



  $result = connetti_query($query);	

  if (! $result ) {

    $result = "<br>Errore nell'esecuzione di <b>spl_noteInsert</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

    print $result;

  } else {

    $change  = "ID_Soggetto=".$ID_Soggetto;

    $change .= "\n Data_Valuta= ".$Data_Valuta;

    $change .= "\n Data_Competenza= ".$Data_Competenza;

    $change .= "\n Anno_Bilancio= ".$Anno_Bilancio;

    $change .= "\n Tipo_Pagamento= ".$Tipo_Pagamento;

    $change .= "\n Entrate= ".$Entrate;

    $change .= "\n Uscite= ".$Uscite;

    $change .= "\n ID_Banca= ".$ID_Banca;

    $change .= "\n ID_Voce_Bilancio= ".$ID_Voce_Bilancio;

    $change .= "\n Descrizione= ".$Descrizione;

    $change .= "\n Admin_logged= ".$Admin_logged;

    

		$conf = array('mode' => 0600, 'timeFormat' => '%X %x');

		//$logger = &Log::singleton('file', 'logs/sd_movimenti.log', 'ident', $conf);

		//$logger->log("logged ".str_replace("\r","...",$change));



    sendMail("Insert sd_movimenti", $change);

  }

  

  return $result;

}

						

function movUpdate (

          $ID_Movimento,

					$ID_Soggetto,

					$Data_Valuta,

					$Data_Competenza,

					$Anno_Bilancio,					

					$Tipo_Pagamento,

					$Entrate,

					$Uscite,

					$ID_Banca,

					$ID_Voce_Bilancio,					

					$Descrizione,

					$Admin_logged

					)

{

  global $link, $mov_table;

  $query = "	UPDATE ".$mov_table." SET

  ID_Soggetto       = '$ID_Soggetto',

  Data_Valuta       = '$Data_Valuta',

  Data_Competenza   = '$Data_Competenza',

  Anno_Bilancio			= '$Anno_Bilancio',

  Tipo_Pagamento    = '$Tipo_Pagamento',

  Entrate           = '$Entrate',

  Uscite            = '$Uscite',

  ID_Banca          = '$ID_Banca',

  ID_Voce_Bilancio  = '$ID_Voce_Bilancio',

  Descrizione       = '$Descrizione',

  ID_Admin          = '$Admin_logged'	

  WHERE 

  ID_Movimento = '$ID_Movimento' 	 

  ";

  

  $result = connetti_query($query);	

  if (! $result ) {

    $result = "<br>Errore nell'esecuzione di <b>movUpdate</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";

    print $result;

  } else {

    $change  = "ID_Soggetto=".$ID_Soggetto;

    $change .= "\n Data_Valuta= ".$Data_Valuta;

    $change .= "\n Data_Competenza= ".$Data_Competenza;

    $change .= "\n Anno_Bilancio= ".$Anno_Bilancio;

    $change .= "\n Tipo_Pagamento= ".$Tipo_Pagamento;

    $change .= "\n Entrate= ".$Entrate;

    $change .= "\n Uscite= ".$Uscite;

    $change .= "\n ID_Banca= ".$ID_Banca;

    $change .= "\n ID_Voce_Bilancio= ".$ID_Voce_Bilancio;

    $change .= "\n Descrizione= ".$Descrizione;

    $change .= "\n Admin_logged= ".$Admin_logged;



		$conf = array('mode' => 0600, 'timeFormat' => '%X %x');

		//$logger = &Log::singleton('file', 'logs/sd_movimenti.log', 'ident', $conf);

		//$logger->log("logged ".$change);



    sendMail("Update sd_movimenti", $change);

  }

  

  return $result;

}

		

function delRow( $table, $fname, $fval)

	{

	global $link;

	$result = connetti_query("DELETE FROM $table WHERE $fname = '$fval'");

	if (! $result )

	die (" Errore di cancellazione: ".mysql_error());

	}		

	

// restituisce il numero di record in una tabella	

function recordCount($table)

	{

	global $link;

	$result = connetti_query("SELECT * FROM $table");

	$count = mysql_num_rows($result);

	return $count;

	}	

// restituisce il numero record di una query	

function queryCount($table, $where)

	{

	global $link;

	$result = connetti_query("SELECT * FROM ".$table." WHERE ".$where."");

	$count = mysql_num_rows($result);

	return $count;

	}		

?>

