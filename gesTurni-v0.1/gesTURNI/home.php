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
<input id='addUtenti' name='addUTENTI' type='checkbox' onchange='unHide(addUSERdiv)'>Aggiungi utenti<br>
<input id='seeUtenti' name='seeUTENTI' type='checkbox' onchange='unHide(seeUSERdiv)'>Vedi utenti<br>
<input id='addMonth' name='addMESE' type='checkbox' onchange='unHide(addMESEdiv)'>Aggiungi mese<br>
<input id='seeMonth' name='seeMESE' type='checkbox' onchange='unHide(seeMESEdiv)'>Vedi mese<br>
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
<option value="four">part time</option>
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
$turnistiPARTTIME=array();
$turnistiRESPONSABILI=array();
$lista=array();
echo "<table id='users'><tr>";                                                        //disegno tabella
echo "<td>UTENTE</td><td>ORARIO</td></tr>";
while($dipendente=mysql_fetch_assoc($querySELECT)){                                         //query per visualizzare dipendenti
	echo "<tr><td>".$dipendente['COGNOME']."</td><td>";
	$lista[]=$dipendente['COGNOME'];
	if($dipendente['TIPO']==1){
		$turnistiOTTO[]=mysql_real_escape_string($dipendente['COGNOME']);
		echo "8 ore";
		if($dipendente['RESPONSABILE']==1){
			$turnistiRESPONSABILI[]=mysql_real_escape_string($dipendente['COGNOME']);
			echo "responsabile ";
		}
	}
	else if($dipendente['TIPO']==0){
		$turnistiSEI[]=mysql_real_escape_string($dipendente['COGNOME']);
		echo "6 ore";
	}
	else if($dipendente['TIPO']==2){
		$turnistiPARTTIME[]=mysql_real_escape_string($dipendente['COGNOME']);
		echo "4 ore";
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
<br>
PRIMO GIORNO<select id='pGIORNO' name='primoGiorno' onChange='unHide(scegliFestiviID)'>
<option value='' selected>Seleziona Giorno</option>
<option value='1'>LUNEDI'</option>
<option value='2'>MARTEDI'</option>
<option value='3'>MERCOLEDI'</option>
<option value='4'>GIOVEDI'</option>
<option value='5'>VENERDI'</option>
<option value='6'>SABATO</option>
<option value='7'>DOMENICA</option>
</select><br>
<button id='scegliFestiviID' name='scegliFestivi' onClick="openPage('scegliFestivi.php','Scegli Festivi',450,390,100,350);return false;" hidden='true'>Scegli Festivi</button><br>
<input id='addnewMONTH' name='addnewMONTH' type='submit' value='ADD'>
</form>
</fieldset>
</div>

<div id='seeMESEdiv' hidden='true'>
<fieldset id='seeMESEfield' style='width:250px'><legend>SEE MESE</legend>
<form id='seeMESEform' method='POST'>
<button id='scegliMeseID' name='scegliMese' onClick="openPage('pickMonth.php','Scegli Mese',600,250,100,350);return false;">Lista Mesi</button><br>
MESEANNO<input id='meseCercato' name='meseVoluto' type='text' size='10'><br><br>
<input id='seeMONTH' name='seeMONTH' type='submit' value='Vedi'> 
</form>
</fieldset>
</div>

</html>

<?php
$numeroTURNISTIotto=count($turnistiOTTO);
$numeroTURNISTIsei=count($turnistiSEI);
$supportoT8=$numeroTURNISTIotto;
$supportoT6=$numeroTURNISTIsei;
$supportoT8--;
$supportoT6--;
$maxRANDotto=$supportoT8;
$maxRANDsei=$supportoT6;
if(isset($_POST['addUSERin'])){                 //aggiungi dipendente
	$cognome=mysql_real_escape_string($_POST['userCOGNOME']);             
	if($_POST['tipo']=='eight'){                //tipo turno
		$tipo=1;
	}
	else if($_POST['tipo']=='six'){
		$tipo=0;
	}
	else if($_POST['tipo']=='four'){
		$tipo=2;
	}
	
    $sqlINSERT="INSERT INTO utenti (COGNOME,TIPO) VALUES ('$cognome','$tipo')";  //query di aggiunta
	if(mysql_query($sqlINSERT)){
		alert_pop('Utente aggiunto');
	}
	else echo mysql_error();
	
}

if(isset($_POST['addnewMONTH'])){               //aggiungi mese

	$settimana=['ZERO','LUNEDI','MARTEDI','MERCOLEDI','GIOVEDI','VENERDI','SABATO','DOMENICA'];      //array nomi giorni
	//$nomeCampoPausa=['PausaRXL','PausaN1','PausaN2','PausaN3','PausaN4'];
	$nomeCampoPausa=generaCAMPIpausa($numeroTURNISTIotto);
	$numeroCAMPI=count($nomeCampoPausa);
	$mese=$_POST['meseNEW'];
	$anno=mysql_real_escape_string($_POST['annoNEW']);
	if(isset($_POST['bisestile'])){                                                                  //check su febbraio bisestile
		$bisesto=1;
	}else $bisesto=0;
	$giorni=ritorna_giorni($mese,$bisesto);                                                          //ritorno numero giorni in base al mese
	$primoG=$_POST['primoGiorno'];
	$tabella=$anno.$mese;
	
	if($anno>=2015 && $anno<2100){                                                                                 //creo tabella
		$sqlTABLE="CREATE TABLE `$tabella`                                                       
		(numGiorno int(2) PRIMARY KEY,
		nomeGiorno varchar(20),
		Turno8 varchar(20),
		Turno6 varchar(20)
		)";
		$queryTABLE=mysql_query($sqlTABLE) or die(mysql_error());
		if($queryTABLE){
			if($mese==12){
				openLoadingPage('loading/loadingPageNAT.php');
			}
			else{
			openLoadingPage('loading/loadingPage.php');
			}
			$indice=$primoG;
			$numGiornoAttuale=1;
			$i=mt_rand(0,$maxRANDotto);
			$l=mt_rand(0,$maxRANDsei);
			
			while($numGiornoAttuale<=$giorni){                                                                 //popolo tabella
			  if(!in_array($numGiornoAttuale,$_SESSION['festivi'])){
			    if($indice==6 || $indice==7){                                                                  //inserisci solo giorno
					mysql_query("INSERT INTO `$tabella` (numGiorno,nomeGiorno,Turno8,Turno6) VALUES ('$numGiornoAttuale','$settimana[$indice]','','')");
					
				}
				else{
					if($mese==12){                                                                             //check su turno vigilia natale e capodanno DICEMBRE
                                  if($numGiornoAttuale==24){
				                                        	$turnistaSEIvigiliaNAT=$turnistiSEI[$l];
															$turnistaOTTOvigiliaNAT=$turnistiOTTO[$i];
				                                           }
                                  if($numGiornoAttuale==31){
					                                        if($turnistiSEI[$l]==$turnistaSEIvigiliaNAT){
																$l++;
																if($l==$numeroTURNISTIsei){
                                                                                           $l=0;
																}																						   
															}
															if($turnistiOTTO[$i]==$turnistaOTTOvigiliaNAT){
																$i++;
																if($i==$numeroTURNISTIotto){
																	                        $i=0;
				                                                }
															}
															
				                                            }			
					}				
				//inserisco giorno con turno8 e turno6	
				mysql_query("INSERT INTO `$tabella` (numGiorno,nomeGiorno,Turno8,Turno6) VALUES ('$numGiornoAttuale','$settimana[$indice]','$turnistiOTTO[$i]','$turnistiSEI[$l]')");
				//calcolo turni individuali
				$risultatoINDICI=array();
	            $varSUP=1;
				$varXUP=1;
 	            if($i==0){
		                  while($varSUP<=$maxRANDotto){
		                         $risultatoINDICI[]=$numeroTURNISTIotto-$varSUP;
                                 $varSUP++;  								 	 
	                                                }
	                    }
                else{
		             while($varSUP<=$maxRANDotto){
		                         $sonda=$i-$varSUP;
								 if($sonda<0){
									$sonda=$numeroTURNISTIotto-$varXUP;
									$varXUP++;
					             			 }
								 $risultatoINDICI[]=$sonda;
		                         $varSUP++;
	                                           }	
	                }		 
				//aggiorno entry con turni individuali
				$nomeCamp=1;
				$contatore=0;
				$index=0;
				$valoreAggiunto=0;
				$tappo=count($risultatoINDICI);
				while($contatore<=$maxRANDotto){
					$cambia=$risultatoINDICI[$index];
                    mysql_query("ALTER TABLE `$tabella` ADD $nomeCampoPausa[0] VARCHAR(20)");				
					mysql_query("ALTER TABLE `$tabella` ADD $nomeCampoPausa[$nomeCamp] VARCHAR(20)");
					if(!in_array($turnistiOTTO[$cambia],$turnistiRESPONSABILI)){
				        mysql_query("UPDATE `$tabella` SET $nomeCampoPausa[$nomeCamp]='$turnistiOTTO[$cambia]' WHERE numGiorno='$numGiornoAttuale'");
					}
					else{
						mysql_query("UPDATE `$tabella` SET PausaRESP='$turnistiOTTO[$cambia]' WHERE numGiorno='$numGiornoAttuale'");
					}
				    $nomeCamp++;
				    if($nomeCamp==$numeroCAMPI){
				     	$nomeCamp=0;
				    }
				    $index++;
				    if($index==$tappo){
						$index=0;
					}
				    $contatore++;	
				}
					
				
				$i++;
				$l++;
				}
				
			}
			else{
				if($indice==6 || $indice==7){
					mysql_query("INSERT INTO `$tabella` (numGiorno,nomeGiorno,Turno8,Turno6) VALUES ('$numGiornoAttuale','$settimana[$indice]','','')");
				}
				else{
				mysql_query("INSERT INTO `$tabella` (numGiorno,nomeGiorno,Turno8,Turno6) VALUES ('$numGiornoAttuale','$settimana[$indice]','FESTIVO','FESTIVO')");  //numGiornoAttuale nei festivi
             	}	
			}
			$indice++;                                                                                     //incremento indice giorno settimana
				
				if($i==$numeroTURNISTIotto){                                                                   //resetto indice turnistiotto
					$i=0;
				}
				if($l==$numeroTURNISTIsei){                                                                    //resetto indice turnistisei
					$l=0;
				}
				if($indice==8){                                                                                //resetto indice giorno settimana
					$indice=1;
				}
				$numGiornoAttuale++;                                                                           //aumento giorno attuale
			}
			unset($_SESSION['festivi']);                                                                       //distruggo festivi scelti
			/*if($numGiornoAttuale==$giorni){
				alert_pop("Tabella popolata");
			}*/
		}
		else alert_pop(mysql_error());
		
	}
	else alert_pop("Hai inserito un valore per anno non valido:                            VALORI AMMESSI 2015-2099!");
	
}

if(isset($_POST['seeMONTH'])){
	$nomiMESI=['ZERO','GENNAIO','FEBBRAIO','MARZO','APRILE','MAGGIO','GIUGNO','LUGLIO','AGOSTO','SETTEMBRE','OTTOBRE','NOVEMBRE','DICEMBRE'];
	$tabellaDESIDERATA=mysql_real_escape_string($_POST['meseVoluto']);
	$annoDESIDERATO=substr($tabellaDESIDERATA,0,4);
	$meseDESIDERATO=substr($tabellaDESIDERATA,4);
	$sqlVEDI="SELECT * FROM `$tabellaDESIDERATA` WHERE 1";
	$eseguiVEDI=mysql_query($sqlVEDI) or die(mysql_error());
	echo "<table id='orario' border='1px solid black'><tr><th>ANNO:$annoDESIDERATO</th><th>MESE:$nomiMESI[$meseDESIDERATO]</th></tr>";                                                        //disegno tabella
    echo "<tr><td id='intestazione' align='center'>GIORNO</td><td></td>";
	while(list($chiave,$valore)=each($lista)){
		echo "<td id='nomeDIPENDENTE' align='center' width='80px'>$valore</td>";
	}
	echo "</tr>";
	$numeroTURNISTI=$numeroTURNISTIotto+$numeroTURNISTIsei;
    while($risultato=mysql_fetch_assoc($eseguiVEDI)){                                         //query per visualizzare dipendenti
        
		echo "<tr>
       		  <td id='numGiorno' align='center' bgcolor='#BCF650'>".$risultato['numGiorno']."</td>
			  <td id='nomeGiorno' align='center' bgcolor='#BCF650'>".$risultato['nomeGiorno']."</td>
			  ";
			  $numero=0;
			  while($numero<$numeroDIPENDENTI){
			  if($risultato['Turno8']==''){                                                  //disegna casella per sabato/domenica
				   echo "<td id='casellaSABDOM' align='center' bgcolor='#608DBD'></td>";              
			  }
			  else if($risultato['Turno8']=='FESTIVO'){                                     //disegna casella per festivo
				  echo "<td id='casellaFestivo' align='center' bgcolor='#ff8080'>FESTIVO</td>";
			  }
			  else if($lista[$numero]==$risultato['Turno8'] || $lista[$numero]==$risultato['Turno6']){           //disegna casella per turno dipendente
				  echo "<td id='casellaDip' align='center' bgcolor='#f8ff00'>XL</td>";
			  }
			  else if($lista[$numero]==$risultato['PausaRESP']){
				   echo "<td id='casellaDip' align='center' bgcolor='#e1c0f4'>RESP</td>";
			  }
			  else if($lista[$numero]==$risultato['PausaRXL']){
				   echo "<td id='casellaDip' align='center' bgcolor='#e1c0f4'>RXL</td>";
			  }
			  else if($lista[$numero]==$risultato['PausaN1']){
				   echo "<td id='casellaDip' align='center' bgcolor='#e1c0f4'>N1</td>";
			  }
			   else if($lista[$numero]==$risultato['PausaN2']){
				   echo "<td id='casellaDip' align='center' bgcolor='#e1c0f4'>N2</td>";
			  }
			     else if($lista[$numero]==$risultato['PausaN3']){
				   echo "<td id='casellaDip' align='center' bgcolor='#e1c0f4'>N3</td>";
			  }
			    else if($lista[$numero]==$risultato['PausaN4']){
				   echo "<td id='casellaDip' align='center' bgcolor='#e1c0f4'>N4</td>";
			  }
			  else if($numero>=$numeroTURNISTI){                                                                 //disegna casella per dipendente non turnista
				  echo "<td id='casellaDipPT' align='center' bgcolor='#00ff84'>PT</td>";
			  }
			  else{
				  
				  echo "<td id='casellaDipVuota' align='center' bgcolor='#f8ff84'></td>";                        //disegna casella vuota
			  }
			  $numero++;
			  }

	echo "</tr>";
	}
echo "</table>";
echo "<button id='buttonExportTable' name='buttonExportTable' onclick='exporTable(orario)'>EXPORT</button>
<script>function exporTable(table){
		var tabella= table;
			
        var html = tabella.outerHTML;
		
		var a = document.createElement('a');
		var datatype='data:html';
		a.href=datatype+','+html;
		a.download='export'+'.html';
		a.click();
	}
	</script>";

}

?>