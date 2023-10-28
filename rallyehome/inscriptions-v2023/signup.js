// signup form handling

function signup() {

	var error = "";
	adminmail = document.getElementById("admin-mail").value;	// ! GLOBALS
	adminname = document.getElementById("admin-name").value;	// ! GLOBALS
	teamname  = document.getElementById("team-name").value; 	// ! GLOBALS
	teamlogin = undefined;										// ! GLOBALS

	if 		(teamname == "") 	error = "Vous avez oublié le nom de l'équipe !";
    else if (adminname == "") error = "Vous avez oublié le nom du chef d'équipe !";
    else if (adminmail == "") error = "Vous avez oublié l'adresse mail du chef d'équipe";
    else if (!validateEmail(adminmail)) error = "Attention ce n'est pas une adresse email valide";

	if (error == "") {

		// display loading animation ...
		push('loader');
		
		var httpRequest = new XMLHttpRequest();

		// Coéquipiers
		var els = document.getElementsByClassName("coeq-mail");
		var coeq = '';
		Array.prototype.forEach.call(els, function(el) { coeq += el.value!='' ? el.value+',':''; });

		var data = {
			"team": teamname, 
			"leader": adminname, 
			"leadermail": adminmail
		};
		if (coeq != '') data['membersmails'] = coeq;

		// sending the payment request to our backend, then to Stripe
	    fetch('https://3e5yu7zdeut5by5k7mlm3sesia0iftbx.lambda-url.eu-west-1.on.aws', { 
	        method: "POST",
	        body: JSON.stringify(data)
	    })
	    .then(function(response) { return response.json(); })
	    .then(function(data) { 
	    	var els = document.getElementsByClassName("t-name");
			Array.prototype.forEach.call(els, function(el) { el.innerHTML = teamname });
			var els = document.getElementsByClassName("a-mail");
			Array.prototype.forEach.call(els, function(el) { el.innerHTML = adminmail });
			teamlogin = data.login;
            push('payment'); 
	    })
	    .catch(function(error) { 
	    	console.error('Error:', error); 
	    	document.getElementById("form-error").style.display = 'block';
	        document.getElementById("form-error").innerHTML = "Désolé, il y a eu un problème :(";
	    });

	} else {
		document.getElementById("form-error").style.display = 'block';
		document.getElementById("form-error").innerHTML = error;
	}
}

function validateEmail(txt) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(txt).toLowerCase());
}

function ajouterCo () {
	var newNode = document.createElement('div');
	newNode.className = "guys";
	newNode.innerHTML = '<input type="text" name="coeq-name" class="coeq-name" placeholder="Prénom et nom du coéquipier"><input type="mail" name="coeq-mail" class="coeq-mail mailinput" placeholder="Son adresse e-mail"><div id="addCo" onclick="ajouterCo();"></div>';
	var nodes = document.querySelectorAll(".guys");
	var lastNode = nodes[nodes.length- 1];

	lastNode.parentNode.insertBefore(newNode, lastNode.nextSibling);

}