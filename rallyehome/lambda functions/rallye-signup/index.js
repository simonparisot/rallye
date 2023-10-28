const aws = require("aws-sdk");
const dynamo = new aws.DynamoDB.DocumentClient();
const ses    = new aws.SES({ region: "eu-west-1" });
const simplifyString = require("simplify-string");


exports.handler = async (event) => {

    console.log("request: " + JSON.stringify(event));
    let body = JSON.parse(event.body);
    let login = simplifyString(body.team);

    await storeTeam(body.team, login, body.leader, body.leadermail, body.membersmails);

    let responseBody = { 
        team: body.team, 
        login: login 
    };

    let response = {
        statusCode: 201,
        body: JSON.stringify(responseBody)
    };

    return response;


/*    storeTeam(body.team, login, body.leader, body.leadermail, body.membersmails).then(() => {

        callback(null, {
            statusCode: 201,
            body: JSON.stringify({
                team: body.team,
                login: login
            }),
            headers: {
                "Content-Type": "application/json"
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
              "Content-Type": "application/json"
            },
        });
        
    });
*/

};

function storeTeam(team, login, leader, leadermail, membersmails) {
    return dynamo.put({
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