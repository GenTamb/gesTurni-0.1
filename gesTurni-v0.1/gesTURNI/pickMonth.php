<?php
require('isLogged.php');
require('connectDB.php');
require('functions.php');

$test=array();
$num=0;
$queryTabelle="SHOW TABLES FROM turni";
$ricerca=mysql_query($queryTabelle);
while($tabelle=mysql_fetch_row($ricerca)){
	$test[]=$tabelle[0];
}


while(list($chiave,$nome)=each($test)){
	if($nome!= 'profili' && $nome!='utenti') {
		echo "<input id='tabella$nome' name='nomeTabella' type='radio' value='$nome' onclick='copiaValori(this)'>".substr($nome,4)." ".substr($nome,0,4)."<br>
		<script>
             function copiaValori(elem){
	         var x=elem.value;
	         window.opener.meseCercato.value=x;
}
</script>";
	}
}
echo "<button id='closePick' name='chiudiPICK' onclick='window.close()'>Chiudi</button>";
?>
