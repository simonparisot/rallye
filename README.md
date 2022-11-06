# Rallye d'Hiver

Sites et apps du Rallye d'Hiver parisien : https://rallyehiver.fr

## Structure du repo

* 2012, 2016, 2019, ... : différentes version du site du rallye (il y a une nouvelle édition par an)

* admin : app pour les organisateurs, pour le suivi de l'avancement des équipes

* rallyehome : sites communs pour toutes les éditions, permettant notamment les inscriptions et paiements

TO DO: merge ces différents site en un pour permettre la gestion du rallye commune pour toutes les éditions

## Deux architectures et stacks différentes 

Les sites principaux (2012, 2016, 2019 et 2020) et le site admin sont les plus anciens. Ils sont en PHP / MariaDB.

Les sites dans rallye home sont plus simples et plus modernes. Ce sont des SPA (certains en React, certain vanilla) appuyés sur des fonctions lambda pour gérer l'inscription et le paiement (via Stripe).

## Infrastructure

Tout est sur AWS. 

Les sites principaux et admin sont sur une machine EC2 avec stack LAMP (séparation des éditions avec plusieurs virtual hosts).

Rallye Home s'appuie sur Lambda / S3 / DynamoDB.
