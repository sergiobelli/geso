<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type"
              content="text/html; charset=iso-8859-1" />
        <title>Autocomplete </title>
        <link rel="stylesheet" href="reset.css" type="text/css" />
        <link rel="stylesheet" href="base.css" type="text/css" />
        <link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.20.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-1.8.20.custom.min.js"></script>


        <script type="text/javascript">
            $(function() {
		
		$( "#utente" ).autocomplete({
			source: "../controller/cerca.php",
			select: function(event, ui){
					$("#idutente").text(ui.item.idutente)
				}
		});
	});
        </script>
        
    </head>
    <body>
        <p>
        Utente: <input type="text" id="utente" /><br />
        id:  <input type="hidden" id="idutente" />
        </p>
    </body>
</html>