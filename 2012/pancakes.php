<?php

//Si vous avez trouvé cette page, bravo ! Vous avez gagné le gros lot ;)

// numéro		1						2							3										4						5						6								7										8									9								10														11					12								13														14							15										16								17					18										19							20						2A
//$eni = array(	"Visite amusée",		"Les Bottes de chef-lieu",	"Strasbourg 1792",						"Melodie internat.",	"Arts Florissants",		"Legende de Joseph",			"Enfants de Michael",					"Broken Tape",						"Dans un tridacne",				"BOF!",													"Besoin d'amour",	"Mode",							"Facile à jouez",										"Saga des 9",				"Cycles",								"La Cigale et la Fourmi",		"Orchestre",		"Ca gaze pour le grand cpt.",			"Armide",					"Tournée du patron",	"Mystère (TR)");
$mdp = array(	"louvre", 				"alagna", 					"cymbales", 							"pleyel", 				"olympia", 				"musikia", 						"romantique", 							"comique", 							"brassens", 					"villette",												"olympia", 			"musikia", 						"accordeon", 											"orchestre", 				"oasis", 								"varietes", 					"hautbois", 		"ellington",							"phaeton",					"pleyel",				"tino");
$quest = array(	"louvre278", 			"eustache317", 				"germain941", 							"pleyel911", 			"olympia643", 			"musikia345", 					"romantique545", 						"comique195", 						"brassens334", 					"villette672",											"olympia643", 		"musikia345", 					"villette672", 											"brassens334", 				"romantique545", 						"comique195", 					"louvre278", 		"germain941", 							"eustache317",				"pleyel911",			"tino658");	
$lieu = array(	"au Louvre", 			"à l'Eglise St-Eustache", 	"à l'Eglise Saint-Germain-des-Prés", 	"à la Salle Pleyel", 	"à l'Olympia", 			"au Magasin Megastore Musikia", "au Musée de la Vie Romantique",		"au Théâtre des Variétés", 			"au Parc Georges Brassens", 	"au Musée des Instruments de Musique de la Villette",	"à l'Olympia", 		"au Magasin Megastore Musikia", "au Musée des Instruments de Musique de la Villette",	"au Parc Georges Brassens",	"au Musée de la Vie Romantique", 		"au Théâtre des Variétés", 		"au Louvre", 		"à l'Eglise Saint-Germain-des-Prés",	"à l'Eglise St-Eustache",	"à la Salle Pleyel",	"au Square Tino Rossi");
$lieu2 = array(	"Louvre", 				"Eglise St-Eustache", 		"Eglise Saint-Germain-des-Pres", 		"Salle Pleyel", 		"Olympia", 				"Magasin Musikia", 				"Musee de la Vie Romantique",			"Theatre des Varietes", 			"Parc Georges Brassens", 		"Musee des Instruments de Musique",						"Olympia", 			"Magasin Musikia", 				"Musee des Instruments de Musique", 					"Parc Georges Brassens", 	"Musee de la Vie Romantique", 			"Theatre des Varietes", 		"Louvre", 			"Eglise Saint-Germain-des-Pres", 		"Eglise St-Eustache",		"Salle Pleyel",			"Square Tino Rossi");

$youpi = array(	
//		1
		"Bien joué ! Celle-ci n'était pas si difficile, n'est ce pas ?<br><br>",		

//		2
		"Bien joué, vous avancez ... à grand pas !<br><br>",		

//		3		
		"Une énigme conçue par un Brestois sur une Marseillaise écrite à Strasbourg par le compositeur de Lisle : presque les 4 coins de l'hexagone, comme disait l'autre ! Félicitation pour votre sagacité.<br/><br/>",

//		4
		"Félicitation pour la résolution de cette <i>Mélodie internationale</i> ! Les connaissances en théorie musicale que vous avez pu utiliser vous resserviront surement, si ce n'est déjà fait.<br><br>",
		
//		5
		"Bravo ! Vous avez su allier esprit de déduction et esprit de finesse et naviguer parmi les arts ... et les chiffres !<br><br>",
		
//		6
		"Félicitations, c'était probablement l'énigme avec le plus de tiroirs à la suite. Chacun des tiroirs n'étaient en fait pas très compliqués, mais ils nécessitaient une culture à cheval sur les XVIIIème, XIXème et XXème siècles réunis.<br><br>",

//		7
		"Compliments, nous voyons bien que votre équipe a su s'appuyer sur des générations plus jeunes.<br><br>",
		
//		8
		"Compliments. Vous avez su voir l'envers des choses et mettre à profit des connaissances musicales hétéroclites !<br><br>",
		
//		9
		"Bien joué ! Vous ne vous êtes pas laissés emporter par le tourbillon des possibilités pour retrouver le père de tous les indices ! Notez que cette énigme pouvait être résolue très (trop) simplement. N'oubliez pas d'indiquer sur votre dossier de réponse de quelle façon vous avez utilisé <b>le texte</b> de l'énigme pour la résoudre.<br><br>",

//		10
		"Félicitations, vous semblez combiner une bonne oreille et de vraies connaissances de cinéphiles dans l'équipe.<br><br>",
		
//		11
		"Bravo, Vous ne vous êtes pas laissés déstabilisés par la traduction littérale de ces tubes !<br><br>",
		
//		12
		"Bravo ! Une énigme pas si simple qui montre de solides connaissances en théorie musicale (ou une bonne utilisation de Wikipédia !).<br><br>",
		
//		13
		"Bravo ! On vous l'avait dit, c'était plutôt facile à jou<b>er</b> n'est ce pas ?<br><br>",

//		14
		"Une énigme en forme de soupape pour vous permettre de relacher la pression et de coincer la bulle ! Bien joué.<br><br>",		
		
//		15		
		"Chapeau bas, cette énigme n'était pas si simple ! En passant, votre lune en bélier indique de bonnes chances de succès pour ce Rallye ...<br><br>",		
		
//		16
		"Bravissimo ! Celle-là était difficile, non ? Enfin, si vous lisez ceci, vous avez fait le tour de la question, et pas que de la question !<br><br>",
		
//		17
		"Flûte ! Vous ne vous êtes pas arrêtés au club de danse où Luis Mariano aurait rencontré Edith Piaf ? Dans tout les cas, bravo !<br><br>",
		
//		18
		"Je vois que vous avez des lettres et de la perspicacité ... Bravo, ça gaze !<br><br>",
		
//		19
		"Enigme un peu morbide, excusez nous ! Quelle option avez-vous retenue : la visite au cimetière ou la recherche par internet ? Dans tout les cas, félicitation !<br><br>",
		
//		20
		"Well done ! Vous êtes de vrais chefs (d’orchestre, évidemment).<br><br>",
		
//		2A
		"Un questionnaire peut en cacher un autre, vous l'avez bien compris ! Très bonne perspicacité en tout cas.<br><br>");
?>
