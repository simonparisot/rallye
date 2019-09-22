var stripe = require("stripe")("sk_live_BXgR9yumzGdkKOPJvYyM9e9V");

var AWS = require('aws-sdk');
var docClient = new AWS.DynamoDB.DocumentClient();

var simplifyString = require("simplify-string");

exports.handler = function(event, context, callback) {
	
    console.log('EVENT RECEIVED');
    console.log('DEBUG: Received event:', JSON.stringify(event));
    const requestBody = JSON.parse(event.body);
	const team = requestBody.team;
	const login = simplifyString(team);
	
	const chargeParams = {
		currency: 'eur',
		amount: 100,
		source: requestBody.token,
		description: 'Inscription ' + team,
		receipt_email: requestBody.email
	};

	var dbParams = {
	    TableName:process.env.TABLE_NAME,
	    Key:{ "login": login },
	    UpdateExpression: "set payment = :p",
	    ExpressionAttributeValues:{ ":p":"Paid by CB" },
	    ReturnValues:"UPDATED_NEW"
	};
    
    console.log("trying to charge ...");
    stripe.charges.create(chargeParams, function(err, charge) {
    	
    	console.log("charge has been attempted");
    	console.log("charge : ", JSON.stringify(charge, null, 2));
    	console.log("err : ", JSON.stringify(err, null, 2));
    	const status = charge ? charge.status : null;
    	
    	if (err) {
	        console.error("Unable to charge. Error JSON:", JSON.stringify(err, null, 2));
	    } else if (status != "succeeded") {
	    	console.error("Charge was not succeeded: ", JSON.stringify(charge, null, 2));
	    } else {
	        console.log("charge succeeded:", JSON.stringify(charge, null, 2));
	    	
			docClient.update(dbParams, function(error, data) {
			    if (error) {
			        console.error("Unable to update DB. Error JSON:", JSON.stringify(error, null, 2));
			    } else {
			        console.log("DB update succeeded.");
			        callback(null, {
			            statusCode: 200,
			            body: JSON.stringify({
			                msg: "everything is ok"
			            }),
			            headers: {
			                'Access-Control-Allow-Origin': '*',
			            },
			        });
			    }
			});
	    }
    });
};