
<?php

require_once("LoginManager.php");

	// inizializzazione della sessione
	//session_start();
	// se la sessione di autenticazione
	// è già impostata non sarà necessario effettuare il login
	// e il browser verrà reindirizzato alla pagina di scrittura dei post
	if (isset($_SESSION['login'])) {
		// reindirizzamento alla homepage in caso di login mancato
		header("Location: LoginView.php");
	}
	
	$LoginManager = new LoginManager();	
	
	// controllo sul parametro d'invio
	if(isset($_POST['submit']) && (trim($_POST['submit']) == "Login")) {
		
		// controllo sui parametri di autenticazione inviati
		if( !isset($_POST['username']) || $_POST['username']=="" ){
			echo "Attenzione, inserire la username.";
		} elseif( !isset($_POST['password']) || $_POST['password'] =="") {
			echo "Attenzione, inserire la password.";
		} else {
			// validazione dei parametri tramite filtro per le stringhe
			
			$username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));
			$password = trim(filter_var($_POST['password'], FILTER_SANITIZE_STRING));
			//$password = sha1($password);
			
			// inclusione del file della classe
			include "funzioni_mysql.php";
			
			// istanza della classe
			$data = new MysqlClass();
			
			// chiamata alla funzione di connessione
			$data->connetti();
			
			// interrogazione della tabella
			$auth = $LoginManager::autenticate($username, $password);
			//$auth = $data->query("SELECT id FROM login WHERE username = '$username' AND password = '$password'");
			
			// controllo sul risultato dell'interrogazione
			if(mysql_num_rows($auth)==0) {
				// reindirizzamento alla homepage in caso di insuccesso
				header("Location: LoginView.php");
			} else {
				// chiamata alla funzione per l'estrazione dei dati
				$res =  $data->estrai($auth);
				
				// creazione del valore di sessione
				$_SESSION['login'] = $res-> id;
				
				$LoginManager::gestioneCertificatiMedici();
				
				// disconnessione da MySQL
				$data->disconnetti();
				
				// reindirizzamento alla pagina di amministrazione in caso di successo
				header("Location: GaraView.php");
			}
		}
	} else {
		// form per l'autenticazione
?>
		<h1>Accesso all'amministrazione:</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			Username:<br />
			<input name="username" type="text"><br />
			Password:<br />
			<input name="password" type="password" size="20"><br />
			<input name="submit" type="submit" value="Login">
		</form>
<?php
	}
?>