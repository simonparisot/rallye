'use strict';

var AWS = require('aws-sdk'),
	ddb = new AWS.DynamoDB.DocumentClient(); 

var simplifyString = require("simplify-string");


exports.handler = function(event, context, callback){
    
    //console.log("DEBUG:" + "New request: " + JSON.stringify(event));
    
    global.requestBody = JSON.parse(event.body);
    global.team = requestBody.team;
    global.leader = requestBody.leader;
    global.leadermail = requestBody.leadermail;
    global.membersmails = requestBody.membersmails;
    global.login = simplifyString(team);

    store().then(() => {

        callback(null, {
            statusCode: 201,
            body: JSON.stringify({
                team: team
            }),
            headers: {
                'Access-Control-Allow-Origin': '*',
            },
        });
        
    }).catch((err) => {
        
        console.log('ERROR:', JSON.stringify(err));
        callback(null, {
            statusCode: 500,
            body: JSON.stringify({
              Error: err.message
            }),
            headers: {
              'Access-Control-Allow-Origin': '*',
            },
        });
        
    });

};

function store() {
    return ddb.put({
        TableName: process.env.TABLE_NAME,
        Item: {
            team: team,
            login: login,
            leader: leader,
            leadermail: leadermail,
            membersmails: membersmails,
            RequestTime: new Date().toISOString(),
        },
    }).promise();
}