var quebrada = false;
function mudaLampada(tipo){
	if(!quebrada){
		document.getElementById("lampada").src="lib/images/"+ tipo +".jpg";
		if(tipo == 'lampada_acesa'){ 
			document.getElementById("label-lampada").innerHTML="Quanto vale Sua ideia ?"; 
			}
		if(tipo == 'lampada_apagada'){ document.getElementById("label-lampada").innerHTML="Quanto vale uma ideia ?"; }
		if(tipo == 'lampada_quebrada'){
			quebrada = true;
			document.getElementById("label-lampada").innerHTML="É melhor pensar nisso.";
		}
	}
}
