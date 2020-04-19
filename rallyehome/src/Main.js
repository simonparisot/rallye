import React from "react";
import { Route, NavLink, HashRouter } from "react-router-dom";
import Home from "./Home";
import Inscription from "./Inscription";
import Editions from "./Editions";
import Contact from "./Contact";
import "./index.css";
import { library } from '@fortawesome/fontawesome-svg-core'
import { faArrowLeft } from '@fortawesome/free-solid-svg-icons'

library.add(faArrowLeft)

export const Main = () => (
	<HashRouter>
		<div class="content">
			<NavLink to="/"> <h1>Rallye d'Hiver</h1> </NavLink>
			<Route exact path="/" component={Home}/>
			<Route path="/inscription" component={Inscription}/>
			<Route path="/editions" component={Editions}/>
			<Route path="/contact" component={Contact}/>
		</div>
    </HashRouter>
);

export default Main;