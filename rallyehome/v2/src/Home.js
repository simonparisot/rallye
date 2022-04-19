import React from "react";
import { NavLink } from "react-router-dom";

export const Home = () => (
	<div>
		<h2>Bienvenue !</h2>
		
		<section>
			<p>Chaque année depuis plus de 50 ans, le Rallye d’Hiver vous propose de découvrir un Paris pittoresque à travers le prisme d’une thématique particulière (précédemment la musique, les jeux, le luxe …).</p>
			<p>En pratique, des équipes de quelques personnes ont les trois mois d’hiver pour résoudre des énigmes qui les conduisent sur des lieux en rapport avec le thème du Rallye. Là, les équipes doivent répondre à un questionnaire qui guide leur découverte du lieu. C’est l’occasion de se cultiver en s’amusant, et d’occuper les longues soirées d’hiver et les weekends brumeux !</p>
			<p>Le Rallye démarre chaque année à la date du solstice d'hiver (autour du 21 décembre). N'hésitez pas à nous contacter dès maintenant pour être informé du lancement !</p>
		</section>
		
		<nav>
			<NavLink to="/editions"> 	<button>Éditions précédentes</button> 	</NavLink>
			<NavLink to="/contact"> 	<button>Nous contacter</button> 		</NavLink>
		</nav>
    </div>
);

export default Home;