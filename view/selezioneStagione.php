<?php
	
// inizializzazione della sessione
session_start();
	
	require_once("../StagioneManager.php");
	require_once("../CategoriaManager.php");
	

$ConfigManager = new ConfigManager();
$versione = $ConfigManager->getVersione();
$utenza   = $_SESSION['username'];
$ambiente = $ConfigManager->getAmbiente();
$stagione = "n.d.";

	
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
		
		
		$_SESSION['idStagioneSessione'] = $_POST['stagione'];

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
		<title>Selezione stagione</title>
		
		<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
		<link type="text/css" href="../css/redmond/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />
		
		<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-1.8.20.custom.min.js"></script>
		
		<script type="text/javascript">
			
			$(function(){
				$( "#seleziona" ).button();
			});

            $(function(){
                var browser
                if ($.browser.msie) {
                    browser = "Internet Explorer";
                } else if ($.browser.mozilla) {
                    browser = "Mozilla";
                }else if ($.browser.webkit) {
                    browser = "SafariWE";
                }else if ($.browser.opera) {
                    browser = "Opera";
                } else {
                    browser = "sconosciuto"
                }
                var versione = $.browser.version

                $("#browser").append(browser + " versione: " + versione)
            })
		</script>
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
		
<div align="right" class="version">
	<table>
		<tr><td>versione</td><td>:</td><td><?php echo $versione; ?></td></tr>
		<tr><td>ambiente</td><td>:</td><td><?php echo $ambiente; ?></td></tr>
		<tr><td>utenza</td><td>:</td><td><?php echo $utenza; ?></td></tr>
		<tr><td>stagione</td><td>:</td><td><?php echo $stagione; ?></td></tr>
		<tr><td>browser</td><td>:</td><td id="browser"></td></tr>
	</table>
</div>

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