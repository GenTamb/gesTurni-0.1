<?php
require('isLogged.php');
require('connectDB.php');
require('functions.php');

?>

<html>
<head>
<title>Home TURNI</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body id="body-color"> 



<div id='ConsoleDIV'>
<fieldset id='Consolefield' style='width:250px'><legend>Console</legend>
<form id='ConsoleFORM' method='POST'>
<input id='addUtenti' name='addUTENTI' type='checkbox' onchange='unHidden(addUSERdiv)'>Aggiungi utenti<br>
<input id='seeUtenti' name='seeUTENTI' type='checkbox' onchange='unHidden(seeUSERdiv)'>Vedi utenti<br>
<input id='addMonth' name='addMESE' type='checkbox' onchange='unHidden(addMESEdiv)'>Aggiungi mese<br>
<input id='seeMonth' name='seeMESE' type='checkbox' onchange='unHidden(seeMESEdiv)'>Vedi mese<br>
<input id='refresh' name='refreshbtn' type='submit' value='REFRESH'>
</form>
</fieldset>
</div>

<div id='addUSERdiv' hidden='true'>
<fieldset id='addUSERfield' style='width:250px'><legend>ADD USER</legend>
<form id='addUSERform' method='POST'>
COGNOME&nbsp&nbsp<input id='cognome' name='userCOGNOME' type='text' size='25'><br><br>
TIPO&nbsp&nbsp<select name='tipo'>
<option value="" selected>seleziona orario</option>
<option value="eight">8 ore</option>
<option value="six">6 ore</option>
</select><br><br>
<input id='addUSERin' name='addUSERin' type='submit' value='ADD'> 
</form>
</fieldset>
</div>

<div id='seeUSERdiv' hidden='true'>
<fieldset id='seeUSERfield' style='width:250px'><legend>SEE USERS</legend>
<?php
$sqlSELECT="SELECT * FROM utenti WHERE 1 ORDER BY tipo";                              //query per ricercare dipendenti
$querySELECT=mysql_query($sqlSELECT);
$numeroDIPENDENTI=0;
$turnistiOTTO=array();
$turnistiSEI=array();
echo "<table id='users'><tr>";                                                        //disegno tabella
echo "<td>UTENTE</td><td>ORARIO</td></tr>";
while($dipendente=mysql_fetch_assoc($querySELECT)){                                         //query per visualizzare dipendenti
	echo "<tr><td>".$dipendente['COGNOME']."</td><td>";
	if($dipendente['TIPO']==1){
		$turnistiOTTO[]=mysql_real_escape_string($dipendente['COGNOME']);
		echo "8 ore";
	}
	else{
		$turnistiSEI[]=mysql_real_escape_string($dipendente['COGNOME']);
		echo "6 ore";
	}
	echo "</td></tr>";
	$numeroDIPENDENTI++;
}
echo "</table>";
echo "ci sono $numeroDIPENDENTI utenti";
?>
</fieldset>
</div>

<div id='addMESEdiv' hidden='true'>
<fieldset id='addMESEfield' style='width:400px'><legend>ADD MONTH</legend>
<form id='addMESEform' method='POST'>
ANNO&nbsp&nbsp<input id='anno' name='annoNEW' type='text' size='10'><br><br>
MESE&nbsp&nbsp<select id ='mese' name='meseNEW' onChange='checkFebbraio(mese,bisesto)'>
<option value='' selected>Seleziona Mese</option>
<option value='1'>GENNAIO</option>
<option value='2'>FEBBRAIO</option>
<option value='3'>MARZO</option>
<option value='4'>APRILE</option>
<option value='5'>MAGGIO</option>
<option value='6'>GIUGNO</option>
<option value='7'>LUGLIO</option>
<option value='8'>AGOSTO</option>
<option value='9'>SETTEMBRE</option>
<option value='10'>OTTOBRE</option>
<option value='11'>NOVEMBRE</option>
<option value='12'>DICEMBRE</option>
</select><br>
<div id='bisesto' hidden='true'>
Bisestile<input id='bisestoCB' name='bisestile' type='checkbox'>
</div>
PRIMO GIORNO<select name='primoGiorno'>
<option value='' selected>Seleziona Giorno</option>
<option value='1'>LUNEDI'</option>
<option value='2'>MARTEDI'</option>
<option value='3'>MERCOLEDI'</option>
<option value='4'>GIOVEDI'</option>
<option value='5'>VENERDI'</option>
<option value='6'>SABATO</option>
<option value='7'>DOMENICA</option>
</select><br>
<input id='addnewMONTH' name='addnewMONTH' type='submit' value='ADD'>
</form>
</fieldset>
</div>

<div id='seeMESEdiv' hidden='true'>
<fieldset id='seeMESEfield' style='width:250px'><legend>SEE MESE</legend>
<form id='seeMESEform' method='POST'>
MESE&nbsp&nbsp<select id ='mese' name='meseSEE'>
<option value='' selected>Seleziona Mese</option>
<option value='1'>GENNAIO</option>
<option value='2'>FEBBRAIO</option>
<option value='3'>MARZO</option>
<option value='4'>APRILE</option>
<option value='5'>MAGGIO</option>
<option value='6'>GIUGNO</option>
<option value='7'>LUGLIO</option>
<option value='8'>AGOSTO</option>
<option value='9'>SETTEMBRE</option>
<option value='10'>OTTOBRE</option>
<option value='11'>NOVEMBRE</option>
<option value='12'>DICEMBRE</option>
</select><br>
ANNO&nbsp&nbsp<input id='anno' name='annoSEE' type='text' size='10'><br><br>
<input id='seeMONTH' name='seeMONTH' type='submit' value='Vedi'> 
</form>
</fieldset>
</div>

</html>

<?php
$numeroTURNISTIotto=count($turnistiOTTO);
$numeroTURNISTIsei=count($turnistiSEI);

while(list($num,$val)=each($turnistiSEI)) echo $num.$val ."<br>";

while(list($num,$val)=each($turnistiOTTO)) echo $num.$val ."<br>";

$indiceTURNISTIotto=$numeroTURNISTIotto++;
$indiceTURNISTIsei=$numeroTURNISTIsei++;

if(isset($_POST['addUSERin'])){                 //aggiungi dipendente
	$cognome=mysql_real_escape_string($_POST['userCOGNOME']);             
	if($_POST['tipo']=='eight'){                //tipo turno
		$tipo=1;
	}
	else $tipo=0;
	
    $sqlINSERT="INSERT INTO utenti (COGNOME,TIPO) VALUES ('$cognome','$tipo')";  //query di aggiunta
	if(mysql_query($sqlINSERT)){
		alert_pop('Utente aggiunto');
	}
	else echo mysql_error();
	
}

if(isset($_POST['addnewMONTH'])){               //aggiungi mese

	$settimana=['ZERO','LUNEDI','MARTEDI','MERCOLEDI','GIOVEDI','VENERDI','SABATO','DOMENICA'];      //array nomi giorni
	$mese=$_POST['meseNEW'];
	$anno=mysql_real_escape_string($_POST['annoNEW']);
	if(isset($_POST['bisestile'])){                                                                  //check su febbraio bisestile
		$bisesto=1;
	}else $bisesto=0;
	$giorni=ritorna_giorni($mese,$bisesto);                                                          //ritorno numero giorni in base al mese
	$primoG=$_POST['primoGiorno'];
	$tabella=$mese.$anno;
	
	if($anno>=2015){                                                                                 //creo tabella
		$sqlTABLE="CREATE TABLE `$tabella`                                                       
		(numGiorno int(2) PRIMARY KEY,
		nomeGiorno varchar(20),
		Turno8 varchar(20),
		Turno6 varchar(20)
		)";
		$queryTABLE=mysql_query($sqlTABLE) or die(mysql_error());
		if($queryTABLE){
			alert_pop("Tabella creata");
			$indice=$primoG;
			$numGiornoAttuale=1;
			$i=mt_rand(0,$numeroTURNISTIotto);
			$l=mt_rand(0,$numeroTURNISTIsei);
			while($numGiornoAttuale<=$giorni){                                                                 //popolo tabella
			    if($indice==6 || $indice==7){                                                                  //inserisci solo giorno
					mysql_query("INSERT INTO `$tabella` (numGiorno,nomeGiorno) VALUES ('$numGiornoAttuale','$settimana[$indice]')");
					
				}
				else{                
				mysql_query("INSERT INTO `$tabella` (numGiorno,nomeGiorno,Turno8,Turno6) VALUES ('$numGiornoAttuale','$settimana[$indice]','$turnistiOTTO[$i]','$turnistiSEI[$l]')");
				$i++;
				$l++;
				}
				$numGiornoAttuale++;                                                                           //aumento giorno attuale
				$indice++;
				
				if($i==$indiceTURNISTIotto){
					$i=0;
				}
				if($l==$indiceTURNISTIsei){
					$l=0;
				}
				if($indice==8){
					$indice=1;
				}
			}
			/*if($numGiornoAttuale==$giorni){
				alert_pop("Tabella popolata");
			}*/
		}
		else alert_pop(mysql_error());
		
	}
	else alert_pop("Hai inserito un valore per anno non valido o inferiore a 2015!");
	
}


?>