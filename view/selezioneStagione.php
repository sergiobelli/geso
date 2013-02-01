<?php
	
	require_once("../StagioneManager.php");
	require_once("../CategoriaManager.php");
	
	// inizializzazione della sessione
	//session_start();
	// se la sessione di autenticazione
	// è già impostata non sarà necessario effettuare il login
	// e il browser verrà reindirizzato alla pagina di scrittura dei post
	if (!isset($_SESSION['login'])) {
		// reindirizzamento alla homepage in caso di login mancato
		header("Location: ../index.php");
	}
	
	if (isset($_POST['submit']) 
			&& (trim($_POST['submit']) == "seleziona")
			&& isset($_POST['stagione'])
			) {
		
		
			$_SESSION['stagione'] = $_POST['stagione'];

			$elencoCategorie = null;
			
			$CategoriaManager = new CategoriaManager();
			$elencoCategorieDb = CategoriaManager::lista();
			
			$contatore = 0;
			
			while ($elencoCategorieDb_row = dbms_fetch_array($elencoCategorieDb)) {
				
				$elencoCategorie[$contatore] = array(
					$elencoCategorieDb_row["id"],
					$elencoCategorieDb_row["codice"],
					$elencoCategorieDb_row["sesso"],
					$elencoCategorieDb_row["descrizione"],
					$elencoCategorieDb_row["da"],
					$elencoCategorieDb_row["a"]);
					
				$contatore++;
			
			}
			
			$_SESSION['categorie'] = $elencoCategorie;


		header("Location: ../AtletaView.php");
		
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
	<head>
		<title>Selezione stagione</title><link rel="stylesheet" type="text/css" href="../stylesheet.css">
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
		
		<div align="center">Selezione stagione</div>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">

				<tr>
					<td class="FacetFormHeaderFont">Stagione</td>
					<td align="right">
						<select name="stagione">
<?php
							$StagioneManager = new StagioneManager();
							$elencoStagioni = StagioneManager::lista();
							while ($elencoStagioni_row = dbms_fetch_array($elencoStagioni)) {
								if ($elencoStagioni_row["ID"] == $idStagione) {
									print( "<option selected value='".$elencoStagioni_row["ID"]."'>".$elencoStagioni_row["ANNO"]."</option>" );
								} else {
									print( "<option value='".$elencoStagioni_row["ID"]."'>".$elencoStagioni_row["ANNO"]."</option>" );
								}
							}
?>
						</select>							
					</td>
				</tr>	

				<tr>
					<td class="FacetFormHeaderFont">&nbsp;</td>
					<td align="right">
						<input class="FacetButton" type="submit" id="seleziona" name="submit" value="seleziona" />
					</td>
				</tr>
				
			</table>
		</form>

	</body>
</html>