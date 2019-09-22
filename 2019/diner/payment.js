/* Payment processing using Stripe Checkout via Ajax and Lambda */

function processPayment(token) {

	// display loading animation ...
	// TO DO
	
    var httpRequest = new XMLHttpRequest();
		
	var data = {
		"token": token.id, 
		"email": token.email,
		"amount": window.price,
		"item": window.item
	};
	
	httpRequest.onreadystatechange = function() {
	    if (httpRequest.readyState === 4) {
	    	if (httpRequest.status === 200) {
                // payment is processed, we can move to the confirmation page
                alert("payment is ok !!");
                // TO DO
                // popup with name and description
            } else {
                // problem while processing payment
                alert("Désolé, il y a eu un problème dans le traitement de votre paiement. Aucune somme n'a été débitée. Nous vons invitons à réessayer ou bien à nous contacter directement : audreyetsimon.p@gmail.com")
                // TO DO move to landing page
            }
        }
	};
	
	httpRequest.open('POST', 'https://x97t9hqk1e.execute-api.eu-west-3.amazonaws.com/prod/payment', true);
	httpRequest.setRequestHeader('Content-Type', 'application/json');
	httpRequest.send(JSON.stringify(data));
}

// handle Checkout payment
var handler = StripeCheckout.configure({
	key: 'pk_test_i3F1oxvyea82K4mpspGI9lCN',
	image: 'img/profile.png',
	locale: 'fr',
	token: function(token) {
		processPayment(token);
	}
});

var els = document.getElementsByClassName('paybutton');
Array.prototype.forEach.call(els, function(el) {
	el.addEventListener('click', function(e) {
		
		// setting global variables
		window.price = this.attributes.relprice.value*100;
		window.item = this.attributes.reldesc.value;

		// display checkout popup
		handler.open({
			name: "Liste de mariage A&S",
			description: window.item,
			currency: 'eur',
			amount: window.price,
			allowRememberMe: false,
		});

		e.preventDefault();
	});
});

window.addEventListener('popstate', function() {
	handler.close();
});