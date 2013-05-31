<?php
	require_once("Header.php");
	require_once("PresenzaManager.php");
	require_once("AtletaManager.php");
	require_once("GaraManager.php");
	require_once("StagioneManager.php");
	require_once("TipologiaGaraManager.php");
	
	global $operazione;
	$operazione = '';
	
	global $presenza;
	
	global $idPresenza, $idAtleta, $idGara, $idStagione, 
		$idTipologiaGara, $posizioneAssoluta, $totaleAssoluti, 
		$posizioneCategoria, $totaleCategoria;
		
	$idPresenza = '';
	
	$idAtleta = '';
	$sessoAtleta = '';
	$descrizioneAtleta = '';
	
	$idGara = '';
	$descrizioneGara = '';
	$idStagione = '';
	$idStagioneSessione = $_SESSION['stagione'];
	
	$descrizioneTipologiaGara = '';
	
	$posizioneAssoluta = '';
	$posizioneAssolutaFemminile = '';
	$totaleAssoluti = '';
	$posizioneCategoria = '';
	$totaleCategoria = '';
		
	// inizializzazione della sessione
	//session_start();
	// se la sessione di autenticazione
	// è già impostata non sarà necessario effettuare il login
	// e il browser verrà reindirizzato alla pagina di scrittura dei post
	if (!isset($_SESSION['login'])) {
		// reindirizzamento alla homepage in caso di login mancato
		header("Location: index.php");
	}

	$PresenzaManager = new PresenzaManager();
	
	if (isset($_GET['operazione']) && $_GET['operazione'] == 'modifica') {
		$operazione = 'modifica';
		$presenza = PresenzaManager::get($_GET['idPresenza']);
		while ($presenza_row = dbms_fetch_array($presenza)) {
			$idPresenza = $presenza_row["ID"];
			
			$idAtleta = $presenza_row["ID_ATLETA"];
			$descrizioneAtleta = $presenza_row["COGNOME_ATLETA"] . " " . $presenza_row["NOME_ATLETA"];
			
			$idGara = $presenza_row["ID_GARA"];
			$descrizioneGara = $presenza_row["LOCALITA_GARA"] 
				. " - " . $presenza_row["NOME_GARA"] 
				. " (". $presenza_row["DATA_GARA"] . ")";
			
			$idStagione = $presenza_row["ID_STAGIONE"];
			
			$idTipologiaGara = $presenza_row["ID_TIPOLOGIA_GARA"];
			$descrizioneTipologiaGara = $presenza_row["TIPOLOGIA_GARA_DESCRIZIONE"] 
				. " (" . $presenza_row["TIPOLOGIA_GARA_PUNTEGGIO"] . " punti)";
			
			$posizioneAssoluta = $presenza_row["POSIZIONE_ASSOLUTA"];
			$totaleAssoluti = $presenza_row["TOTALE_ASSOLUTI"];
			$posizioneCategoria = $presenza_row["POSIZIONE_CATEGORIA"];
			$totaleCategoria = $presenza_row["TOTALE_CATEGORIA"];
		}
	} else if (isset($_GET['operazione']) && $_GET['operazione'] == 'cancella') {
		$operazione = 'cancella';
		PresenzaManager::cancella($_GET['idPresenza']);
		$idPresenza = null;
		$operazione = null;
	} else {
		$operazione = 'inserisci';
	}
	
	// controllo sul parametro d'invio
	if(isset($_POST['submit']) && (trim($_POST['submit']) == "salva")) {
		if( !isset($_POST['atleta']) || $_POST['atleta']=="" ){
			echo "Attenzione, inserire l'atleta.";
		} elseif( !isset($_POST['gara']) || $_POST['gara'] =="") {
			echo "Attenzione, inserire la gara.";
		//} elseif( !isset($_POST['stagione']) || $_POST['stagione'] =="") {
		//	echo "Attenzione, inserire la stagione.";
		} else {
			// validazione dei parametri tramite filtro per le stringhe
			$idPresenza = trim($_POST['idPresenza']);
			$atleta = trim($_POST['idAtleta']);
			$gara = trim($_POST['idGara']);
			$stagione = trim($_POST['stagione']);
			$tipologiaGara = trim($_POST['idTipologiaGara']);
			
			if (isset($idPresenza) && $idPresenza != '') {
				PresenzaManager::modifica(
					$idPresenza, 
					$atleta, 
					$gara,  
					$_SESSION['stagione'],
					$tipologiaGara);
				$idPresenza = null;
				$operazione = null;
				$atleta = null;
				$gara = null;
				$tipologiaGara = null;
			} else {
				PresenzaManager::inserisci(
					$atleta, 
					$gara, 
					$_SESSION['stagione'],
					$tipologiaGara);
				$idPresenza = null;
				$operazione = null;
				$atleta = null;
				$gara = null;
				$tipologiaGara = null;				
			}
		}	
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Presenze</title>
		
		<script type="text/javascript">
		
		    $(function(){
                caricaTabella();
				
				$("#salva").click(function(){               
                    $("#modulo_presenza").ajaxSubmit({                     
                        success: caricaTabella,
                        clearForm: true                      
                    })
                })
				
				function caricaTabella(){
					$.getJSON(
						"controller/elencoPresenze.php",
						{idStagione:$("#idStagioneSessione").val()},
						function(data){
							var contatore = '0';
							$.each(data, function(i, data){ contatore++; });
							
							var tabella = 
								"<table border='0' cellpadding='3' cellspacing='1' class='FacetFormTABLE' align='center'>" + 
								"	<tr> " + 
								"		<td class='FacetFormHeaderFont'>#</td> " + 
								"		<td class='FacetFormHeaderFont'>Atleta</td> " + 
								"		<td class='FacetFormHeaderFont'>Gara</td> " + 
								"		<td class='FacetFormHeaderFont'>Tipologia gara</td> " + 
								"		<td class='FacetFormHeaderFont'>Data Gara</td> " + 
								"		<td class='FacetFormHeaderFont'>Stagione</td> " + 
								"		<td class='FacetFormHeaderFont' colspan='2'>Operazioni</td> " + 
								"	</tr> ";
								
							$.each(data, function(i, data){
								var riga = 	
									"<tr>" +
									"	<td class=\"FacetDataTD\" align=\"left\">"+contatore+"</td>" +
									"	<td class=\"FacetDataTD\" align=\"left\">"+data.cognomeAtleta+"&nbsp;"+data.nomeAtleta+" &nbsp;</td>" +
									"	<td class=\"FacetDataTD\" align=\"left\">"+data.localitaGara+" - "+data.nomeGara+"</td>" +
									"	<td class=\"FacetDataTD\" align=\"center\">"+data.tipologiaGaraDescrizione+" ("+data.tipologiaGaraPunteggio+" punti)</td>" +			
									"	<td class=\"FacetDataTD\" align=\"left\">"+data.dataGara+"</td>" +
									"	<td class=\"FacetDataTD\" align=\"center\">"+data.anno+" &nbsp;</td>" +
									"	<td class=\"FacetDataTD\" align=\"center\"><a href='PresenzaView.php?operazione=modifica&idPresenza="+data.id+"'>modifica</a></td>" +
									"	<td class=\"FacetDataTD\" align=\"center\"><a href='PresenzaView.php?operazione=cancella&idPresenza="+data.id+"'>cancella</a></td>";
									"</tr>";
								contatore--;
								tabella = tabella + riga;
							});
							
							tabella = tabella + "</table>";
							
							$(tabella).appendTo("#elencoPresenze");
						}
					);
				};
			});

			$(function(){
				$( "#salva" ).button();
			});
			
			$(function(){
				$( "#cancella" ).button();
				$( "#cancella" ).click( 
					function() { 
						$('#modulo_presenza')[0].reset();
					} 
				);
			});
			
			$(function() {
                $( "#atleta" ).autocomplete({
                    source: "controller/elencoAtletiEffettivi.php",
					select: function(event, ui){
                        $("#idAtleta").val(ui.item.idAtleta);
						$("#sessoAtleta").val(ui.item.sessoAtleta);
						if ($("#sessoAtleta").val() == 'F') {
							$('#rigaPosizioneAssolutaFemminile').css('display', 'block');
							$('#rigaPosizioneAssolutaFemminile').css('align', 'right');
						} else {
							$('#rigaPosizioneAssolutaFemminile').css('display', 'none');
							$('#rigaPosizioneAssolutaFemminile').css('align', 'right');
						}
                    },
					minLength: 2
                });
            });
			
			$(function() {
                $( "#gara" ).autocomplete({
                    source: "controller/elencoGareStagione.php",
					select: function(event, ui){
                        $("#idGara").val(ui.item.idGara);
                    },
					minLength: 2
                });
            });
			
			$(function() {
                $( "#tipologiaGara" ).autocomplete({
                    source: "controller/elencoTipologieGare.php",
					select: function(event, ui){
                        $("#idTipologiaGara").val(ui.item.idTipologiaGara);
                    },
					minLength: 2
                });
            });
		</script>
		
		
	</head>
	<body bgcolor="#FFFFFF" link="#504C43" alink="#000000" vlink="#504C43" text="#000000">
	
		<div align="center">Inserimento/Modifica Presenza</div>
		<form id="modulo_presenza" action="controller/salvaPresenza.php">
			
			<input type="hidden" id="idStagioneSessione" name="idStagioneSessione" value="<?php echo $idStagioneSessione ?>" />
			<input type="hidden" id="idPresenza" name="idPresenza" value="<?php echo $idPresenza ?>" />
			
			<table border="0" cellpadding="3" cellspacing="1" class="FacetFormTABLE" align="center">
				<tr>
					<td class="FacetFormHeaderFont">Atleta</td>
					<td align="right">
						<input type="text" id="atleta" name="atleta" size="80" value="<?php echo $descrizioneAtleta ?>" />
						<input type="hidden" id="idAtleta" name="idAtleta" value="<?php echo $idAtleta ?>" />
						<input type="hidden" id="sessoAtleta" name="sessoAtleta" value="<?php echo $sessoAtleta ?>" />
					</td>
				</tr>				
				<tr>
					<td class="FacetFormHeaderFont">Gara</td>
					<td align="right">
						<input type="text" id="gara" name="gara" size="80" value="<?php echo $descrizioneGara ?>" />
						<input type="hidden" id="idGara" name="idGara" value="<?php echo $idGara ?>" />
					</td>
				</tr>
				<tr>
					<td class="FacetFormHeaderFont">Tipologia Gara</td>
					<td align="right">
						<input type="text" id="tipologiaGara" name="tipologiaGara" size="80" value="<?php echo $descrizioneTipologiaGara ?>" />
						<input type="hidden" id="idTipologiaGara" name="idTipologiaGara" value="<?php echo $idTipologiaGara ?>" />
					</td>
				</tr>
				
				<tr>
					<td class="FacetFormHeaderFont">Posizione assoluta</td>
					<td align="right">
						<input type="text" id="posizioneAssoluta" name="posizioneAssoluta" size="5" />
						<font class="FacetFormHeaderFont">/</font>
						<input type="text" id="totaleAssoluti" name="totaleAssoluti" size="5" />			
					</td>
				</tr>
				<tr id="rigaPosizioneAssolutaFemminile" style="display: none" >
					<td class="FacetFormHeaderFont">Posizione assoluta femminile</td>
					<td align="right">
						<input type="text" id="posizioneAssolutaFemminile" name="posizioneAssolutaFemminile" size="5" />
					</td>
				</tr>				
				<tr>
					<td class="FacetFormHeaderFont">Posizione di categoria</td>
					<td align="right">
						<input type="text" id="posizioneCategoria" name="posizioneCategoria" size="5" />
						<font class="FacetFormHeaderFont">/</font>
						<input type="text" id="totaleCategoria" name="totaleCategoria" size="5" />			
					</td>
				</tr>
				
				<tr>
					<td class="FacetFormHeaderFont">Stagione</td>
					<td align="right">
						<select name="stagione" disabled="disabled">
<?php
							$StagioneManager = new StagioneManager();
							$elencoStagioni = StagioneManager::lista();
							while ($elencoStagioni_row = dbms_fetch_array($elencoStagioni)) {
								if ($elencoStagioni_row["ID"] == $_SESSION['stagione']) {
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
					<td align="center">&nbsp;</td>
					<td align="right">
						<input class="FacetButton" type="button" id="cancella" name="cancella" value="cancella" />
						<input class="FacetButton" type="button" id="salva" name="submit" value="salva" />
					</td>
				</tr>
			</table>
		</form>
		
		<br />
		<br />
		<br />
		
	
	
		<div align="center">Elenco Presenze</div>
		<div id="elencoPresenze"></div>
		
	</body>
</html>