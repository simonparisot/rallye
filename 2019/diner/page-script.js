		function signup() {

			var error = "";
			guests = new Array();
			id = "";
			teamname = document.getElementById("team-name").value;

			if (teamname == "") error = "Vous avez oublié le nom de l'équipe";

			var guys = document.getElementsByClassName("guys");
			for (var i = 0; i < guys.length; i++) {

				var name = guys[i].querySelector('input[name="name"]').value;
				var email = guys[i].querySelector('input[name="email"]').value;

			    if (name != "" || email != "") { 
			    	if (name == "") error = "Merci de renseigner le nom de tous les participants, pour les reconnaitre sur place !";
			    	else if (email == "") error = "Merci de renseigner l'adresse e-mail de tous les participants, pour pouvoir les contacter !";
			    	else if (!validateEmail(email)) error = "Attention ce n'est pas une adresse e-mail valide";
			    	else guests.push([name, email]);
			    }

			}
			if (guests.length == 0) error = "Vous devez renseigner au moins un participant";

			if (error == "") {

				// display loading animation ...
				changecontent("processing");
				
				var httpRequest = new XMLHttpRequest();
				var data = {
					"team": teamname, 
					"guests": guests
				};
				console.log(JSON.stringify(data));
				
				httpRequest.onreadystatechange = function() {
				    if (httpRequest.readyState === 4) {
				    	if (httpRequest.status === 201) {
			                
			                var response = JSON.parse(httpRequest.response)
			                id = response.id;

			                // display the team name in the other sections
			                var els = document.getElementsByClassName("t-name");
							Array.prototype.forEach.call(els, function(el) { el.innerHTML = teamname });
							var els = document.getElementsByClassName("t-count");
							Array.prototype.forEach.call(els, function(el) { el.innerHTML = guests.length });
							var els = document.getElementsByClassName("t-price");
							Array.prototype.forEach.call(els, function(el) { el.innerHTML = 25*guests.length });

			                changecontent("payment");
			            } else {
			                document.getElementById("form-error").innerHTML = "Désolé, il y a eu un problème :(";
			            }
			        }
				};
				
				httpRequest.open('POST', 'https://g1t0ssi5cb.execute-api.eu-west-3.amazonaws.com/prod/diner-signup', true);
				httpRequest.setRequestHeader('Content-Type', 'application/json');
				httpRequest.send(JSON.stringify(data));

			} else {
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
			newNode.innerHTML = '<input type="text" name="name" placeholder="Prénom et nom"><input type="mail" name="email" class="coeq-mail mailinput" placeholder="Adresse e-mail"><div id="addCo" onclick="ajouterCo();">Ajouter un participant</div>';
			var nodes = document.querySelectorAll(".guys");
			var lastNode = nodes[nodes.length- 1];

			var addCo = document.getElementById("addCo");
			lastNode.removeChild(addCo);


			lastNode.parentNode.insertBefore(newNode, lastNode.nextSibling);

		}

		function changecontent(page) {
			document.getElementsByClassName("active")[0].classList.remove("active")
			document.getElementById(page).classList.add("active")
		}

		function processPayment(token) {

			// display loading animation ...
			changecontent("processing");
			
		    var httpRequest = new XMLHttpRequest();
 			
			var data = {
				"token": token.id, 
				"email": token.email,
				"team": teamname,
				"id": id,
				"amount": 2500*guests.length
			};
			
			httpRequest.onreadystatechange = function() {
			    if (httpRequest.readyState === 4) {
			    	if (httpRequest.status === 200) {
		                // payment is processed, we can move to the confirmation page
		                var els = document.getElementsByClassName("a-mail");
						Array.prototype.forEach.call(els, function(el) { el.innerHTML = token.email });
		                changecontent("allgood");
		            } else {
		                // problem while processing payment
		                alert("Désolé, il y a eu un problème dans le traitement de votre paiement par CB. Aucune somme n'a été débitée. Je vous redirige vers le paiment par chèque comme plan B. Toutes les excuses de l'organisation.")
		                changecontent("cheque");
		            }
		        }
			};
			
			httpRequest.open('POST', 'https://g1t0ssi5cb.execute-api.eu-west-3.amazonaws.com/prod/diner-payment', true);
			httpRequest.setRequestHeader('Content-Type', 'application/json');
			httpRequest.send(JSON.stringify(data));
		}

		// handle Checkout payment
		var handler = StripeCheckout.configure({
			//key: 'pk_test_hbwOKb2RetfdKpJR28GzEWO7',
			key: 'pk_live_cCDQlUF3TzwDqP15EBt3JHcP',
			image: 'res/logo-small.jpg',
			locale: 'fr',
			token: function(token) {
				processPayment(token);
			}
		});

		var els = document.getElementsByClassName('paybutton');
		Array.prototype.forEach.call(els, function(el) {
			el.addEventListener('click', function(e) {
				
				// display checkout popup
				handler.open({
					name: "Rallye d'Hiver 2019",
					description: "Inscription au diner",
					currency: 'eur',
					amount: 2500*guests.length,
					allowRememberMe: false,
				});

				e.preventDefault();
			});
		});

		window.addEventListener('popstate', function() {
			handler.close();
		});