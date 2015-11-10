<?php
require('isLogged.php');
require('functions.php');

?>

<html>
<head>
<title>Scegli Festivi</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body id="body-color" onload='retrieveMESE()'> 

<?php

echo "Seleziona i numeri dei giorni festivi di ";
echo "<form id='ritornaGiorni' method='POST'>";
echo "<input id='meseScelto' type='text' name='meseOggetto' size='5' value='ND'>
      <input id='numeroMESE' type='text' name='numeroMESEoggetto' value='ND' hidden='true' >
	  <input id='bisestoCBFESTIVI' name='bisestileFESTIVI' type='checkbox' hidden='true' ><br>
      <input id='calcola' type='submit' name='calcola' size='5' value='calcola'>
<script>function retrieveMESE(){
	var x=window.opener.mese.value;
	var z=window.opener.bisestoCB.checked;
	var y;
	if(x=='1'){
		y='GENNAIO';
	}
	else if(x=='2'){
		y='FEBBRAIO';
	}
	else if(x=='3'){
		y='MARZO';
	}
	else if(x=='4'){
		y='APRILE';
	}
	else if(x=='5'){
		y='MAGGIO';
	}
	else if(x=='6'){
		y='GIUGNO';
	}
	else if(x=='7'){
		y='LUGLIO';
	}
	else if(x=='8'){
		y='AGOSTO';
	}
	else if(x=='9'){
		y='SETTEMBRE';
	}
	else if(x=='10'){
		y='OTTOBRE';
	}
	else if(x=='11'){
		y='NOVEMBRE';
	}
	else if(x=='12'){
		y='DICEMBRE';
	}
	if(z==true){
		bisestoCBFESTIVI.checked=true;
		
	}
	numeroMESE.value=x;
	meseScelto.value=y;
}</script>";
echo "</form>";
if(isset($_POST['calcola'])){
$giorno=1;
$vettoreFestivi=array();
echo "<form id='listaGiorni' method='POST'>";
$numeroMESE=$_POST['numeroMESEoggetto'];
$bisestoFESTIVI=0;
if(isset($_POST['bisestileFESTIVI'])){                                                                  //check su febbraio bisestile
		$bisestoFESTIVI=1;
}
$maxGiorni=ritorna_giorni($numeroMESE,$bisestoFESTIVI);

while($giorno<=$maxGiorni){
	echo "<input id='check$giorno' name='checkPressed[]' type='checkbox' value='$giorno'>$giorno  ";
	
	$giorno++;
}
echo "<br><input id='inviaFestivi' name='sceltaFestivi' value='scegli' type='submit'>";
echo "</form>";


}
if(isset($_POST['checkPressed'])){
	foreach($_POST['checkPressed'] as $value){
		$vettoreFestivi[]=$value;
	}
	$_SESSION['festivi']=$vettoreFestivi;
	chiudiPagina();
}

?>


</html>