<?php

function alert_pop($msg){
	echo "<script> alert('$msg'); </script>";
}

function ritorna_giorni($mese,&$flag){
	$giorni=0;
	if($mese=='1' || $mese=='3' || $mese=='5' || $mese=='7' || $mese=='8' || $mese=='10' || $mese=='12'){
		$giorni=31;
	}
	else if($mese=='4' || $mese=='6' || $mese=='9' || $mese=='11'){
		$giorni=30;
	}
	else if($mese=='2' && $flag==1){
		$giorni=29;
	}
	else if($mese=='2' && $flag==0){
		$giorni=28;
	}
	return $giorni;
}

function openLoadingPage($paginaPHP){
	echo "<script>
	var h=160;
	var w=270;
	var y=250;
	var x=350;
	window.open('$paginaPHP','Caricamento..','height='+h+',width='+w+',top='+y+',left='+x+',');
	
	</script>";
}

function chiudiPagina(){
	echo "<script> window.close();</script>";
}


function generaCAMPIpausa(&$numeroTURNISTIotto){
	$vettore=array();
	$vettore[]='PausaRESP';
	$vettore[]='PausaRXL';
	$conta=1;
	while($conta<=$numeroTURNISTIotto){
		$vettore[]='PausaN'.$conta;
		$conta++;
	}
	return $vettore;
}

?>
<html>
<script>

function unHide(elem){
	if(elem.hidden){
		elem.hidden=false;
	}
	else elem.hidden=true;
}

function hide(elem){
	elem.hidden=true;
}

function openPage(paginaPHP,nome,altezza,larghezza,daSopra,daSinistra){
	var h=altezza;
	var w=larghezza;
	var y=daSopra;
	var x=daSinistra;
	window.open(paginaPHP,nome,'height='+h+',width='+w+',top='+y+',left='+x+'');
	return false;
}

function unDisable(elem){
	elem.disabled=false;
}

function checkFebbraio(mese,bisesto){
	var x='2';
	if(mese.value==x){
		bisesto.hidden=false;
	}
	else bisesto.hidden=true;
	return false;
}



</script>
</html>