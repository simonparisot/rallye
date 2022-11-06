//var stripe = require("stripe")("sk_test_???????????????????");
var stripe = require("stripe")("sk_live_???????????????????");

var AWS = require('aws-sdk'),
	ddb = new AWS.DynamoDB({apiVersion: '2012-08-10'});

exports.handler = async (event, context, callback) => {
    
    console.log('DEBUG: Received event:', JSON.stringify(event));
    const requestBody = JSON.parse(event.body)
	const team = requestBody.team;
	const token = requestBody.token;
	const amount = requestBody.amount;;
	const email = requestBody.email;
	const id = requestBody.id;

	const currency = 'eur';
	const nbTickets = amount/2500;

	console.log("charging stripe ...");
	// try to charge Stripe
    return stripe.charges.create({
		
		amount: amount,
		currency: currency,
		description: 'Inscription au diner pour ' + team,
		source: token,
		receipt_email: email

	// then try to update DB for the given team
    }).then(() => {

    	console.log("updating db ...");
		var params = {
			ExpressionAttributeNames: {
				"#PY": "Payment",
			}, 
			ExpressionAttributeValues: {
				":p": { S: nbTickets.toString() }
			}, 
			Key: {
				"id": { S: id }
			}, 
			ReturnValues: "ALL_NEW", 
			TableName: process.env.TABLE_NAME, 
			UpdateExpression: "SET #PY = :p"
		};
    	return ddb.updateItem(params).promise();

    }).then((charge) => {

    	console.log("returning...");
	    callback(null, {
	        statusCode: 200,
	        body: JSON.stringify({ 
	        	message: `Charge processed succesfully!`,
          		charge
          	}),
	        headers: { 'Access-Control-Allow-Origin': '*' }
	    });
	    
	}).catch((err) => {
	    
	    console.log('ERROR:', JSON.stringify(err));
	    callback(null, {
	        statusCode: 500,
	        body: JSON.stringify({ Error: err.message }),
	        headers: { 'Access-Control-Allow-Origin': '*' }
	    });
	    
	});
};