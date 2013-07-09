<?php

// inizializzazione della sessione
session_start();

require_once("../CategoriaManager.php");
require_once("../StagioneManager.php");

$ConfigManager = new ConfigManager();
$versione = $ConfigManager->getVersione();
$utenza   = $_SESSION['username'];
$ambiente = $ConfigManager->getAmbiente();

$StagioneManager = new StagioneManager();
$stagione = $StagioneManager->getDescrizioneStagione($_SESSION['idStagioneSessione']);



?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
	<head>
		<title>Diagnostica</title>
		
		<script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>

		<script type="text/javascript">
            $(function(){
                $("body").append(

                "<p>Supporto per <strong>Ajax</strong>: " 
                       + ($.support.ajax? "si":"no") + "<br />" +
                    "Supporto per <strong>boxModel standard</strong>: " 
                       + ($.support.boxModel? "si":"no") + "<br />" +
                    "Supporto per <strong>propagazione degli eventi standard</strong>: "
                       + ($.support.changeBubbles ? "si":"no") + "<br />" +
                    "Supporto per <strong>corretto clone dello stato checked</strong>: " 
                       + ($.support.checkClone ? "si":"no") + "<br />" +
                    "Supporto per <strong>valore on per checkbox</strong>: " 
                       + ($.support.checkOn  ? "si":"no") + "<br />" +
                    "Supporto per <strong>cors </strong>: "
                       + ($.support.cors ? "si":"no") + "<br />" +
                    "Usa  <strong>cssFloat </strong>: " 
                       + ($.support.cssFloat ? "si":"no") + "<br />" +
                    "Normalizza  <strong>il valore di href </strong>: " 
                       + ($.support.hrefNormalized ? "no":"si") + "<br />" +
                    "Serializza  <strong>&lt;link&gt;  </strong>: " 
                       + ($.support.htmlSerialize ? "si":"no") + "<br />" +
                    "Conserva gli  <strong>spazi vuoti iniziali </strong>: " 
                       + ($.support.leadingWhitespace ? "si":"no") + "<br />" +
                    "Clona  <strong>gestori di evento </strong>: " 
                       + ($.support.noCloneEvent ? "no":"si") + "<br />" +
                    "Gestisce <strong>opacity</strong>: " 
                       + ($.support.opacity ? "si":"no") + "<br />"+
                    "Disabilita automaticamente <strong>&lt;option&gt;</strong> in &lt;select&gt; disabilitata: " 
                       + ($.support.optDisabled ? "si":"no") + "<br />"+
                    "&lt;option&gt; preselezionata dispone di <strong>di proprietà selected</strong>: " 
                       + ($.support.optSelected ? "si":"no") + "<br />" +
                    " si leggono gli stili inline con<strong>.getAttribute('style')</strong> " 
                       + ($.support.style ? "si":"no") + "<br />" +
                    "  <strong>l'evento submit</strong> si propaga verso l'alto: " 
                       + ($.support.submitBubbles  ? "si":"no") + "<br />" +
                    "  Può esistere <strong>&lt;table&gt; senza &lt;tbody&gt;</strong>" 
                       + ($.support.tbody  ? "si":"no") + "</p>")
            })

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
		<div align="left" class="version">
			<table>
				<tr><td>versione</td><td>:</td><td><?php echo $versione; ?></td></tr>
				<tr><td>ambiente</td><td>:</td><td><?php echo $ambiente; ?></td></tr>
				<tr><td>utenza</td><td>:</td><td><?php echo $utenza; ?></td></tr>
				<tr><td>stagione</td><td>:</td><td><?php echo $stagione; ?></td></tr>
				<tr><td>browser</td><td>:</td><td id="browser"></td></tr>
			</table>
		</div>
	</body>
</html>
