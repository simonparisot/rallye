import React from "react";
import { NavLink } from "react-router-dom";
import YearEdition from "./YearEdition";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'

export const Editions = () => (
	<div>
		<h2>Les précédentes éditions</h2>
		
		<section>
			
			<YearEdition year="2020" theme="Le temps" url="https://2020.rallyehiver.fr" />
			<YearEdition year="2019" theme="Les jeux" url="https://2019.rallyehiver.fr" />
			<YearEdition year="2018" theme="Les romans" url="" />
			<YearEdition year="2017" theme="Les faits divers" url="" />
			<YearEdition year="2016" theme="Le luxe" url="https://2016.rallyehiver.fr" />
			<YearEdition year="2015" theme="Les dames" url="" />
			<YearEdition year="2014" theme="Les explorateurs" url="" />
			<YearEdition year="2013" theme="Les pierres" url="" />
			<YearEdition year="2012" theme="La musique" url="https://2012.rallyehiver.fr" />

		</section>
		
		<nav>
			<NavLink to="/"> <button> <FontAwesomeIcon icon="arrow-left" /> Retour</button> 			</NavLink>
		</nav>
    </div>
);

export default Editions;