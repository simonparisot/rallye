# Rallye d'Hiver

Sites et apps du Rallye d'Hiver parisien : https://rallyehiver.fr

## Structure du repo

* 2012, 2016, 2019, ... : différentes version du site du rallye (il y a une nouvelle édition par an)

* admin : app pour les organisateurs, pour le suivi de l'avancement des équipes

* rallyehome : site commun pour toutes les éditions, permettant notamment les inscriptions et paiement
  - v1 : obsolète, à migrer sur la v2
  - v2 : version à jour react+lambda, travail en cours


## Deux architectures et stacks différentes 

Les sites principaux (2012, 2016, 2019 et 2020) et le site admin sont les plus anciens. Ils sont en PHP / MariaDB.

Rallye home est plus simple et plus moderne (archi serverless). C'est une single page app en React appuyé sur des fonctions lambda pour gérer l'inscription et le paiement (via Stripe).

## Infrastructure

Tout est sur AWS. 

Les sites principaux et admin sont sur une machine EC2 avec stack LAMP (séparation des éditions avec plusieurs virtual hosts).

Rallye Home s'appuie sur Lambda / S3 / DynamoDB.
