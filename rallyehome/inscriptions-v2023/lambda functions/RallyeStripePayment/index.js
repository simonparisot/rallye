var stripe = require("stripe")("sk_test_?????????????????????");

var AWS = require('aws-sdk'),
	ddb = new AWS.DynamoDB(); 

var simplifyString = require("simplify-string");

exports.handler = async (event, context, callback) => {
    
    //console.log('DEBUG: Received event:', JSON.stringify(event));
    const requestBody = JSON.parse(event.body)
	const team = requestBody.team;
	const token = requestBody.token;
	const amount = 2600;
  	const currency = 'eur';
	const email = requestBody.email;
	const login = simplifyString(team);

	var params = {
		ExpressionAttributeNames: {
			"#PY": "Payment", 
		}, 
		ExpressionAttributeValues: {
			":p": { S: "PAID BY CB" }
		}, 
		Key: {
			"login": { S: login }
		}, 
		ReturnValues: "ALL_NEW", 
		TableName: process.env.TABLE_NAME, 
		UpdateExpression: "SET #PY = :p"
	};

	// try to charge Stripe
    return stripe.charges.create({
		
		amount: amount,
		currency: currency,
		description: 'Inscription ' + team,
		source: token,
		receipt_email: email

	// then try to update DB for the given login
    }).then(() => {

    	return ddb.updateItem(params).promise();

    }).then((charge) => {

    	//console.log('DEBUG: Charge:', JSON.stringify(charge));
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