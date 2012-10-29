<?php
global $PHP_SELF;
session_start();

//session_register("session");

// dir per le immagini e gli uploads
$image_dir = "images/";
$image_url = "images/";
$upload_dir = "uploads/";
$upload_url = "uplloads/";

// coppia di funzioni che inseriscono gli slash a seconda della configurazione di PHP
function ref_addslashes (&$var)
		{
		$var = addcslashes($var, "'");
		}
		
function makeSlashes ($array)
	{
	$magic_quotes = get_magic_quotes_gpc();
	if ($magic_quotes == "0")
		{
		array_walk ($array, "ref_addslashes");
		}
	return $array;	
	}
	
	
// funzione che controlla se il sistema e' stato configurato 
function checkConfig ()
	{
	global $config_table;
	$result = dynQuery("*", $config_table);
	$config = mysql_num_rows($result);
	return $config;
	}

setlocale (LC_ALL, 'it');

class select_codice_iva
// classe per la generazione di select box dinamiche per i campi iva
	{

	function addSelected ($selected)
		{
		$this->selected=$selected;
		}
	function addSelectName($name)
		{
		$this->name=$name;
		}
	
	function output()
		{
		global $vat_table, $name;	
		print "\t <select name=\"$this->name\" class=\"FacetSelect\">\n";
		// print "\t\t <option value=\"\"></option>\n";
		
		$result = dynQuery("*", $vat_table);
		while ($a_row = dbms_fetch_array($result))
			{
			$selected = "";
		   	if($a_row["Percentuale"] == $this->selected)
				$selected = "selected"; 
				
			print "\t\t <option value=\"".$a_row["Percentuale"]."\" $selected >".$a_row["Descrizione"]."</option>\n";
			}
		print "\t </select>\n";
		}
	}

class selectPagamento
// classe per la generazione di select box per il tipo pagamento
	{

	function addSelected ($selected)
		{
		$this->selected=$selected;
		}
	function addSelectName($name)
		{
		$this->name=$name;
		}
	
	function output()
		{
		global $payment_table, $name;	
		print "\t <select name=\"$this->name\" class=\"FacetSelect\">\n";
		print "\t\t <option value=\"\"></option>\n";
		
		$result = dynQuery("*", $payment_table);
		while ($a_row = dbms_fetch_array($result))
			{
			$selected = "";
		   	if($a_row["Tipo_Pagamento"] == $this->selected)
				$selected = "selected"; 
				
			print "\t\t <option value=\"".$a_row["Tipo_Pagamento"]."\" $selected >".$a_row["Tipo_Pagamento"]."</option>\n";
			}
		print "\t </select>\n";
		}
	}
class selectBank
// classe per la generazione dinamica di select box con le banche aziendali
	{
	var $name;
		// assegno subito il nome della select box
		function selectBank($name)
			{
			$this -> name = $name;
			}
		
		function addSelected ($selected)
			{
			$this->selected = $selected;
			}
		
		function output()
			{
			global $bank_table;	
			print "\t <select name=\"$this->name\" class=\"FacetSelect\">\n";
			print "\t\t <option value=\"\"></option>\n";
			//$result = dynQuery("*", $bank_table);
      $result = connetti_query("select 	* from 		sd_banche where		deleted = 'N' order by banca");
				while ($a_row = dbms_fetch_array($result))
					{
					$selected = "";
				   	if($a_row["ID_Banca"] == $this->selected)
						$selected = "selected"; 
						
					print "\t\t <option value=\"".$a_row["ID_Banca"]."\" $selected >".$a_row["Banca"]."</option>\n";
					}
			print $this->selected;
			print "\t </select>\n";
			
			}
	}

	
class selectFornitore
// classe per la generazione dinamica di select box con i fornitori
	{
	var $name;
		// assegno subito il nome della select box
		function selectFornitore($name)
			{
			$this -> name = $name;
			}
		
		function addSelected ($selected)
			{
			$this->selected = $selected;
			}
		
		function output()
			{
			global $suppliers_table;	
			print "\t <select name=\"$this->name\" class=\"FacetSelect\">\n";
			print "\t\t <option value=\"\"></option>\n";
			//$result = dynQuery("*", $suppliers_table, 1, "Ragione_Sociale , Cognome");
      $result = connetti_query("select 	* from 		sd_fornitori where		1 order by Ragione_Sociale , Cognome");
				while ($a_row = dbms_fetch_array($result))
					{
					$selected = "";
				   	if($a_row["ID_Fornitore"] == $this->selected)
						$selected = "selected"; 
						
					print "\t\t <option value=\"".$a_row["ID_Fornitore"]."\" $selected >".$a_row["Ragione_Sociale"]." ".$a_row["Cognome"]." ".$a_row["Nome"]."</option>\n";
					}
			print $this->selected;
			print "\t </select>\n";
			
			}
	}	
	
class selectCliente
// classe per la generazione dinamica di select box con i fornitori
	{
	var $name;
		// assegno subito il nome della select box
		function selectCliente($name)
			{
			$this -> name = $name;
			}
		
		function addSelected ($selected)
			{
			$this->selected = $selected;
			}
		
		function output()
			{
			global $customers_table;	
			print "\t <select name=\"$this->name\" class=\"FacetSelect\">\n";
			print "\t\t <option value=\"\"></option>\n";
                
      $result = connetti_query("select 	* from 		sd_clienti where		1 order by Ragione_Sociale , Cognome");
				while ($a_row = dbms_fetch_array($result))
					{
					$selected = "";
				   	if($a_row["ID_Cliente"] == $this->selected)
						$selected = "selected"; 
						
					print "\t\t <option value=\"".$a_row["ID_Cliente"]."\" $selected >".$a_row["Ragione_Sociale"]." ".$a_row["Cognome"]." ".$a_row["Nome"]."</option>\n";
					}
			print $this->selected;
			print "\t </select>\n";
			
			}
	}	

class selectSoggetto {// classe per la generazione dinamica di select box con i soggetti
	var $name;
  // assegno subito il nome della select box
  function selectSoggetto($name) {
    $this -> name = $name;
  }
		
  function addSelected ($selected) {
    $this->selected = $selected;
  }
		
  function output() {
    global $customers_table;	
    print "\t <select name=\"$this->name\" class=\"FacetSelect\">\n";
    print "\t\t <option value=\"\"></option>\n";
              
    $result = connetti_query("select 	* from 		sd_soggetti where		Deleted = 'N' order by Cognome, Nome, Ragione_Sociale ");
    while ($a_row = dbms_fetch_array($result)) {
      $selected = "";
      if($a_row["ID_Soggetto"] == $this->selected) {
        $selected = "selected";
      }  
      print "\t\t <option value=\"".$a_row["ID_Soggetto"]."\" $selected >".$a_row["Ragione_Sociale"]." ".$a_row["Cognome"]." ".$a_row["Nome"]."</option>\n";
    }
    print $this->selected;
    print "\t </select>\n";
  }
}	

class selectVociBilancio {
  // classe per la generazione dinamica di select box con le voci bilancio
  var $name;

  // assegno subito il nome della select box
  function selectVociBilancio($name){
    $this -> name = $name;
  }
  
  function addSelected ($selected){ //come parametro in input mettere l'id della voce bilancio desiderata
    $this->selected = $selected;
  }
  
  function output() {
    global $customers_table;	
    print "\t <select name=\"$this->name\" class=\"FacetSelect\">\n";
    print "\t\t <option value=\"\"></option>\n";
    $result = connetti_query("select 	* from 		sd_voci_bilancio where		1 order by voce");
    while ($a_row = dbms_fetch_array($result)) {
      $selected = "";
      if($a_row["id"] == $this->selected) {
        $selected = "selected"; 
      }
      print "\t\t <option value=\"".$a_row["id"]."\" $selected >".$a_row["voce"]."</option>\n";
    }
    print $this->selected;
    print "\t </select>\n";
    }
}

class selectAnniBilancio {
  // classe per la generazione dinamica di select box con gli anni bilancio
  var $name;

  // assegno subito il nome della select box
  function selectAnniBilancio($name){
    $this -> name = $name;
  }
  
  function addSelected ($selected){ //come parametro in input mettere l'anno bilancio desiderato
    $this->selected = $selected;
  }
  
  function output() {
    global $customers_table;	
    print "\t <select name=\"$this->name\" class=\"FacetSelect\">\n";
    print "\t\t <option value=\"\"></option>\n";
    $result = connetti_query("select 	* from 		sd_anni_bilancio where		1 order by Anno");
    while ($a_row = dbms_fetch_array($result)) {
      $selected = "";
      if($a_row["Anno"] == $this->selected) {
        $selected = "selected"; 
      }
      print "\t\t <option value=\"".$a_row["Anno"]."\" $selected >".$a_row["Anno"]."</option>\n";
    }
    print $this->selected;
    print "\t </select>\n";
    }
}
	
class selectTipiSoci {
  // classe per la generazione dinamica di select box con i tipi soci
  var $name;

  // assegno subito il nome della select box
  function selectTipiSoci($name){
    $this -> name = $name;
  }
  
  function addSelected ($selected){ //come parametro in input mettere l'id della voce bilancio desiderata
    $this->selected = $selected;
  }
  
  function output() {
    global $customers_table;	
    print "\t <select name=\"$this->name\" class=\"FacetSelect\">\n";
    print "\t\t <option value=\"\"></option>\n";
    $result = connetti_query("select 	* from 		sd_tipi_soci where		1 order by Tipo");
    while ($a_row = dbms_fetch_array($result)) {
      $selected = "";
      if($a_row["ID"] == $this->selected) {
        $selected = "selected"; 
      }
      print "\t\t <option value=\"".$a_row["ID"]."\" $selected >".$a_row["Tipo"]."</option>\n";
    }
    print $this->selected;
    print "\t </select>\n";
    }
}
    
		
class selectDate
// classe per la generazione dinamica di select box per le date
	{
	// le proprieta' sono i nomi dei select e i tag "selected" sulle option
	var $giorno;
	var $mese;
	var $anno;
	var $dayselected;
	var $monthselected;
	var $yearselected;
	
		// assegno subito il nome delle select box
		function selectDate($giorno, $mese, $anno)
			{
			$this -> giorno = $giorno;
			$this -> mese = $mese;
			$this -> anno = $anno;
			}
		
		function daySelected ($selected)
			{
			if (!$selected)
			$selected = strftime("%d");
			$this->dayselected = $selected;
			}
		function monthSelected ($selected)
			{
			if (!$selected)
			$selected = strftime("%m");
			$this->monthselected = $selected;
			}
		function yearSelected ($selected)
			{
			if (!$selected)
			$selected = strftime("%Y");
			$this->yearselected = $selected;
			}
		function output()
			{
			// select del giorno
			print "\t <select name=\"$this->giorno\" class=\"FacetSelect\">\n";
			
			for( $counter = 1; $counter <= 31; $counter++ )
				{
				$selected = "";
			   	if($counter == $this->dayselected)
						$selected = "selected"; 
				print "\t\t <option value=\"$counter\" $selected >$counter</option>\n";
				}
			
			print "\t </select>\n";			
			
			// select del mese
			print "\t <select name=\"$this->mese\" class=\"FacetSelect\">\n";

			for( $counter = 1; $counter <= 12; $counter++ )
				{
				$selected = "";
			   	if($counter == $this->monthselected)
						$selected = "selected"; 
				$nome_mese = ucwords(strftime("%B", mktime (0,0,0,$counter,1,0)));
				print "\t\t <option value=\"$counter\"  $selected >$nome_mese</option>\n";
				}
			
			print "\t </select>\n";		
			
			// select del anno
			print "\t <select name=\"$this->anno\" class=\"FacetSelect\">\n";
			
			for( $counter = 2000; $counter <= 2010; $counter++ )
				{				
				$selected = "";
			   	if($counter == $this->yearselected)
						$selected = "selected"; 
				print "\t\t <option value=\"$counter\"  $selected >$counter</option>\n";
				}
			print "\t </select>\n";		
			
			}
	}	
	
						/* SEZIONE PER L'ORDINAMENTO DEI RECORD IN OUTPUT */

				/* SONO IMPOSTATE TUTE LE VARIABILI NECESSARIE ALLA FUNZIONE dynQuery */

// imposto le variabili di sessione con i valori di default

if (!isset ($session["flag_order"]))

	$session["flag_order"] = "" ;

if (!isset ($session["limit"]))

	$session["limit"] = "0";

if (!isset ($session["passo"]))

	$session["passo"] = "40";
	
if (!isset ($session["field"]))
	$session["field"] = "2" ;
	

//flag di ordinamento ascendente e discendente	
if (isset ($flag_order))

	{

	if ($session["flag_order"]=="ASC")

		{

		$session["flag_order"]="DESC";

		}

	elseif (!($session["flag_order"] == "ASC")) 

		{

		$session["flag_order"]="ASC";

		}

	}

// se $PHP_SELF e' compreso nel referer (ricaricamento dalla stessa pagina), conservo tutte le variabili di 
// sessione, altrimenti resetto $session['field'], $session['limit'], $session['passo'], $session['where'] e session['order']
if (!isset($_SERVER["HTTP_REFERER"]))
	{
	$_SERVER["HTTP_REFERER"] = "";
	}
if (!strstr($_SERVER["HTTP_REFERER"], $PHP_SELF))
	{
	 $session['field'] = "2";  // valore che indica alla dynQuery che orderby non va usato
	 $session['flag_order'] = "DESC"; // per default utilizziamo un LIFO, i dati piu' recenti sono i primi
	 $session['limit'] = "0";
	 $session['passo'] = "40";
	 $orderby = $session['field'] ." ".$session['flag_order'];
	 $session['where'] = '1'; // come insegna phpMyAdmin....
	 /*
	 print "<pre>";
	 print_r ($_SERVER);
	 print_r ($_GET);
	 print_r ($_POST);
	 print "</pre>";
	 */
	}

	
// imposto il nuovo campo per l'ordinamento	

if (isset ($field))	

	$session["field"] = $field;
	
$orderby = $session["field"]." ".$session["flag_order"];	

if (isset ($limit))	

	$session["limit"] = $limit;
	

// statement where di default = 1

if (!isset ($session['where']))

	$session['where'] = "1";

else

	$session['where'] = $session['where'];		
	
	
					/* FINE IMPOSTAZIONE VARIABILI */	


// classe che visualizza i pulsanti per la navigazione dei record
// input= tabella, session[where], limit e passo. 
// calcola i valori da impostare sulla variabile limit per scorrere i record
// visualizza il numero totale di record e i pulsanti
class	recordnav
		{
		var $table;
		var $where;
		var $limit;
		var $passo;
		var $last;
		
		function recordnav($table, $where, $limit, $passo)
				{
				// global $limit, $passo;
				$this->table = $table;
				$this->where = $where;
				$this->limit = $limit;
				$this->passo = $passo;
				// faccio il conto totale dei record selezionati dalla query
				$this->count = queryCount($table, $where);
				// (recordcount - modulo del numero di record diviso il passo)
				$this->last = queryCount($table, $where)-(queryCount($table, $where)%$this->passo);
				// return $last;	
				}
		
		function output ()
				{
				global $PHP_SELF;
					
				$first = 0; 
				
				$next = $this->limit + $this->passo;
				
				$prev = $this->limit - $this->passo;
				
				// se e' arrivato a fondo scala imposto il fermo
				if ($prev <= 0)
				
					$prev = 0;
				
				if ($next >= $this->last)
				
					$next = $this->last;
				
				if ( ($this->count) <= $this->passo )
					{
					// non visualizzo la barra di navigazione dei record
					print "<p><div align=\"center\"><font class=\"FacetFormDataFont\">Record trovati $this->count</font></div>";
					}
				else 
					{	
						print "<p><div align=\"center\"><font class=\"FacetFormDataFont\">Record trovati $this->count</font></div>";
						print "<div align=\"center\">";
						print "| << <a href=\"$PHP_SELF?limit=0\" >Primo</a> ";
						print "| < <a href=\"$PHP_SELF?limit=$prev\">Precedente</a> ";
						print "| <a href=\"$PHP_SELF?limit=$next\">Successivo</a> > ";
						print "| <a href=\"$PHP_SELF?limit=$this->last\">Ultimo</a> >> |"; 
						print "</div>";
					 }
			 	}
	}

class linkHeaders
// classe per la creazione di headers cliccabili per l'ordinamento dei record
// accetta come parametro un array associativo composto dalle label e relativi campi del db
	{
	var $headers = array(); // label e campi degli headers
	function linkHeaders ($headers)
		{
		$this->headers = $headers;
		}
	function output()
		{
		global $headers, $PHP_SELF;
		foreach($this->headers as $header => $field)
				{
				if (!$field == "")
					print "\t<th class=\"FacetFieldCaptionTD\"><a href=\"".$PHP_SELF."?field=".$field."&flag_order=\" title=\"Ordina per ".$header."\">".$header."</a></th>\n\r";
				else 
					print "\t<th class=\"FacetFieldCaptionTD\">".$header."</th>\n\r";
				}

		}

	}
	
function formatEuro($number)

	{

	//formatta l'argomento con due decimali, e' buono anche per i dollari (paypal)

	$result = number_format($number, 2, ',', '.');
    // money_format('%.2n', $numero)."\n";
	return $result;

	}
function formatNumber($numero)

	{
	// formatta il numero in modo comprensibile per il DBMS
	$result = number_format($numero, 2, '','');
	return $result;
	}
	
	
function formatDate($data)

	{

	$result = ucwords(strftime("%d %B %Y", strtotime($data)));

	return $result;

	}
	

	
function sendEmail($to, $from, $subject, $body) {
	$error="Mail Inviata";
	mail ($to, $subject, $body, "From: $from")
	or $error = "Impossibile inviare l'email";
	return $error;
}

function cleanMemberSession ($id, $login, $password) {
    global $session;
    $session["id"] = $id;
    $session["Login"] = $login;
    $session["Password"] = $password;
    $session["logged_in"] = true;
}

function checkAdmin() {
    global $session, $logged_in, $admin_table, $admin_logged;
    $session["logged_in"] = false;
    // $session["E_Mail"] = "Null";
    if (! isset ($session["Login"])) {
        $session["Login"]= "Null";
    }
    $club_row = getRow($admin_table, "Login", $session["Login"]);
    if (!$club_row 
    	 || $club_row["Password"] != $session["Password"]) {
        require_once("Login_admin.php");
	exit;
    }
    $session["logged_in"] = true;
    $session["admin_logged"] = $session["Login"];
    return $club_row;
}
	
function checkUser() {
    global $session, $logged_in;
    $session["logged_in"] = false;
    if (! isset ($session["E_Mail"])) {
        $session["E_Mail"]= "Null";
    }
    $club_row = getRow("pws_clienti", "E_Mail", $session["E_Mail"]);
    if (!$club_row 
    	 || $club_row["Password"] != $session["Password"] 
	 || $club_row["Abilitato"] = '0') {
        header("Location: Login.php");
	exit;
    }
    $session["logged_in"] = true;
    return $club_row;
}	

	
function Saldo($ID_Banca, $Data)
// calcola il saldo della banca in oggetto (ID_Banca=0 => Cassa) dalla tabella movimenti fino alla data specificata
	{
	global $link, $mov_table;
	$query = " SELECT SUM(Entrate) - SUM(Uscite) FROM $mov_table where ID_Banca = '$ID_Banca' AND Data_Valuta <= '$Data' ";
	$result = mysql_query($query, $link);	
		if (! $result )
		{
		$result = "<br>Errore nell'esecuzione della funzione <b>Saldo</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";
		print $result;
		}
	$array_saldo = mysql_fetch_array( $result);
	return $array_saldo['0'];
	
	}	
	
	
function saldoCliente($ID_Cliente)
// calcola il saldo  del cliente dalla tabella scadenzario 
	{
	global $link, $terms_table;
	$query = " SELECT SUM(Entrate) - SUM(Uscite) FROM $terms_table where ID_Cliente = '$ID_Cliente' ";
	$result = mysql_query($query, $link);	
		if (! $result )
		{
		$result = "<br>Errore nell'esecuzione della funzione <b>saldoCliente</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";
		print $result;
		}
	$array_saldo = mysql_fetch_array( $result);
	return $array_saldo['0'];
	
	}	
	
function saldoFornitore($ID_Fornitore)
// calcola il saldo  del fornitore dalla tabella scadenzario 
	{
	global $link, $terms_table;
	$query = " SELECT SUM(Entrate) - SUM(Uscite) FROM $terms_table where ID_Fornitore = '$ID_Fornitore' ";
	$result = mysql_query($query, $link);	
		if (! $result )
		{
		$result = "<br>Errore nell'esecuzione della funzione <b>saldoFornitore</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";
		print $result;
		}
	$array_saldo = mysql_fetch_array( $result);
	return $array_saldo['0'];
	
	}		
	
function monteCliente($ID_Cliente)
// calcola il monte pagamenti del cliente dalla tabella scadenzario 
	{
	global $link, $terms_table;
	$query = " SELECT SUM(Uscite) FROM $terms_table where ID_Cliente = '$ID_Cliente' AND ID_Movimento <> '' ";
	$result = mysql_query($query, $link);	
		if (! $result )
		{
		$result = "<br>Errore nell'esecuzione della funzione <b>monteCliente</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";
		print $result;
		}
	$array_saldo = mysql_fetch_array( $result);
	return $array_saldo['0'];
	
	}	
	
function monteFornitore($ID_Fornitore)
// calcola il monte pagamenti al fornitore dalla tabella scadenzario 
	{
	global $link, $terms_table;
	$query = " SELECT SUM(Entrate) - SUM(Uscite) FROM $terms_table where ID_Fornitore= '$ID_Fornitore' AND ID_Movimento <> ''  ";
	$result = mysql_query($query, $link);	
		if (! $result )
		{
		$result = "<br>Errore nell'esecuzione della funzione <b>monteFornitore</b> <br>Query= <b>$query</b> <br> Errore Mysql = <b>".mysql_error()."</b><br>";
		print $result;
		}
	$array_saldo = mysql_fetch_array( $result);
	return $array_saldo['0'];	
	}
	

function salvaAccesso($user, $SID){
    //Salvo data ed ora
    $data = date("Y-m-d",time() + $timeadjust);
    $ora  = date("H:i:s",time() + $timeadjust);

    $query = "INSERT INTO `sd_accessi` ( SESSIONE, USERNAME, DATA, ORA) VALUES('$SID', '$user', '$data', '$ora')"; echo "query insert=".$query;
    $result = connetti_query($query);
}
?>
