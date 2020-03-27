# Rallye d'Hiver 2020 - Le temps

Sites et apps pour le rallye d'hiver 2020 des Meltings Potes, sur le thème du voyage dans le temps avec Haussmann.
C'était le premier rallye où le site a été mis à disposition d'une équipe organisatrice externe (où je n'étais pas), donc quelques changements structurels notamment pour éviter que je n'accède trop facilement aux réponses.
Également quelques changements liés au fonctionnement spécifique de leur rallye.


## Changelog pour cette édition 2020

* les parcours peuvent débloquer des énigmes (2 par parcours en l'occurence)

* les parcours donnent accès à des "mots indices"

* Grosses modifications sur le process de vérification de mot de passe, pour les deux points précédents

* les mots de passe des énigmes et parcours sont stockés hashés, pour m'éviter de les connaître 

* intégration de la partie admin en tant que virtual host supplémentaire


## Structure du repo

* admin : interface pour les organisateurs, pour le suivi de l'avancement des équipes

* inscriptions : site d'inscription au rallye et paiement, qui est réutilisé pour l'inscription au diner

* lambda functions : fonctions lambda utilisés pour inscriptions

* rallyehiver : site principal du rallye


## Deux architectures et stacks différentes 

Le site principal et le site admin sont les plus anciens. Ils sont en PHP en archi MVC.
Ils fonctionnement sur deux virtuals hosts différents sur la même machine EC2 avec une stack LAMP.

Le site d'inscription est plus simple et plus moderne (archi serverless). C'est une single page app appuyé sur des fonctions lambda pour gérer l'inscription et le paiement (via Stripe). Le stockage se fait dans une table dynamodb.

TO DO : passer le site principal et admin en serverless... il y a du taff !