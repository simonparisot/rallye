function acceder(file){
	var xhr_object = null;
	
	if(window.XMLHttpRequest){ 			// Firefox
		xhr_object = new XMLHttpRequest();
	}else if(window.ActiveXObject){		// Internet Explorer
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	}else{ 								// XMLHttpRequest non supporté par le navigateur
	   return "XMLHttpRequest non supportée";
	}
	
	file += '&' + (new Date()).getTime();
	xhr_object.open("GET", file, false);
	xhr_object.send(null);
	return xhr_object.responseText;
}

function isTouchDevice(){
	try{
		document.createEvent("TouchEvent");
		return true;
	}catch(e){
		return false;
	}
}
		
function touchScroll(id){
	if(isTouchDevice()){ //if touch events exist...
		var el=document.getElementById(id);
		var scrollStartPos=0;

		document.getElementById(id).addEventListener("touchstart", function(event) {
			scrollStartPos=this.scrollTop+event.touches[0].pageY;
			event.preventDefault();
		},false);

		document.getElementById(id).addEventListener("touchmove", function(event) {
			this.scrollTop=scrollStartPos-event.touches[0].pageY;
			event.preventDefault();
		},false);
	}
}

function nav(){
	var detect = navigator.userAgent.toLowerCase();
	
	if (detect.indexOf('safari')+1){
		return 200;
	}else if (detect.indexOf('msie')+1){
		var ua = navigator.userAgent;
		var version = ua.split('MSIE ');
		return version[1].charAt(0);
	}else{
		return 100;
	}
}

function no_accent (my_string) {
	var new_string = "";
	var pattern_accent = new Array("é", "è", "ê", "ë", "ç", "à", "â", "ä", "î", "ï", "ù", "ô", "ó", "ö");
	var pattern_replace_accent = new Array("e", "e", "e", "e", "c", "a", "a", "a", "i", "i", "u", "o", "o", "o");
	if (my_string && my_string!= "") {
		new_string = preg_replace (pattern_accent, pattern_replace_accent, my_string);
	}
	return new_string;
}

function preg_replace (array_pattern, array_pattern_replace, my_string)  {
	var new_string = String (my_string);
	for (i=0; i<array_pattern.length; i++) {
		var reg_exp= RegExp(array_pattern[i], "gi");
		var val_to_replace = array_pattern_replace[i];
		new_string = new_string.replace (reg_exp, val_to_replace);
	}
	return new_string;
}
