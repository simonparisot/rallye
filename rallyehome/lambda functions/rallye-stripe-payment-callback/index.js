const stripe = require('stripe')(process.env.STRIPE_SECRET_KEY);
const aws = require("aws-sdk");
const dynamo = new aws.DynamoDB.DocumentClient();
const ses    = new aws.SES({ region: "eu-west-1" });

exports.handler = async function (event, context, callback) {

  let body = { received: true };
  let statusCode = 200;
  const headers = {
    "Content-Type": "application/json"
  };
  
  try {

    // verifying signature
    const rawData = getRawDataFromBody(event.isBase64Encoded, event.body);
    const webhookSecret = process.env.STRIPE_WEBHOOK_SECRET;
    const sig = event?.headers['stripe-signature'];
    const stripeEvent = stripe.webhooks.constructEvent(rawData, sig, webhookSecret);
    console.log(stripeEvent);
    
    let livemode = stripeEvent.livemode;
    if(!livemode) {

      // this is a test payment, so we only send technical info to my email 
      console.log("Test payment. Sending dump on my email.");

      var params = {
          Destination: { ToAddresses: ["parisot.simon@gmail.com"] },
          Message: {
            Body: { Text: { Data: "New test payment. <br>Log is: <br>"+JSON.stringify(teamInfo) } },
            Subject: { Data: "TEST PAYMENT" }
          },
          Source: "parisot.simon@gmail.com",
        };
      return ses.sendEmail(params).promise();

    }


    else {
      // this is a live payment
      // we detect the Stripe Connect account to know how to handle the event
      switch (stripeEvent.account) {
        case 'acct_1M5rgPCB48kjOJ4Q': // Rallye Hiver 2023

          switch (stripeEvent.type) {
            case 'checkout.session.completed':

              let customerEmail = stripeEvent.data.object.customer_email;
              let customerId = stripeEvent.data.object.client_reference_id;

              console.log('getting team info in DDB');
      
              const teamInfo = await dynamo.get({
                  TableName: process.env.TABLE_NAME,
                  Key: {'login': customerId}
                })
                .promise();
              
              console.log(teamInfo);
              
              console.log('sending emails');
              
              var teamEmail = {
                Source: "hello@rallyehiver.fr",
                Destination: { ToAddresses: [teamInfo.Item.leadermail] },
                Message: {
                  Subject: { Data: "Inscription au Rallye d'Hiver 2023 confirmée !" },
                  Body: {
                    Html: {
                        Data: "Bonjour "+teamInfo.Item.leader+",<br><br>Nous vous confirmons que votre équipe "+teamInfo.Item.team+" est bien inscrite au Rallye d'Hiver 2023 ! Nous avons bien reçu vos frais d'inscription.<br>Rendez-vous le 21 décembre pour le lancement !<br><br>Les organisateurs",
                        Charset: 'UTF-8'
                    }
                  }
                },
                ReplyToAddresses: ['rallyehiver2023@gmail.com'],
                ReturnPath: 'parisot.simon@gmail.com'
              };

              var adminEmail = {
                Source: "hello@rallyehiver.fr",
                Destination: { ToAddresses: ["parisot.simon@gmail.com", "rallyehiver2023@gmail.com"] },
                Message: {
                  Subject: { Data: "Nouvelle inscription" },
                  Body: {
                    Html: {
                        Data: "L'équipe "+teamInfo.Item.team+" vient de s'inscrire au Rallye et a réglé ses frais d'inscription.<br>Son chef d'équipe est "+teamInfo.Item.leader+" ("+teamInfo.Item.leadermail+"). Le chef d'équipe a également été notifié par email.<br><br>Simon",
                        Charset: 'UTF-8'
                    }
                  }
                }
              };

              // Sending emails
              const sendTeam = await ses.sendEmail(teamEmail).promise();
              const sendAdmin = await ses.sendEmail(adminEmail).promise();
              
            default:
              console.log('Unhandled event type');
              break;
          }

        case 'acct_1Ldsfb2HPfCAPkeM': // Diane & Guillaume wedding
        case 'acct_1LGK8j2EVnc8AHFk': // Valérie & Christophe wedding
        default:
          // nothing to do with that account for this event. Breaking.
          break;
      }
    }

  } catch (err) {
    statusCode = 400;
    body = err.message;
  } finally {
    body = JSON.stringify(body);
  }

  return {
    statusCode,
    body,
    headers
  };
}


function getRawDataFromBody(isBase64Encoded, body) {
    return isBase64Encoded ? Buffer.from(body, 'base64').toString() : body;
}