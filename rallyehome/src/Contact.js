import React from "react";
import { NavLink } from "react-router-dom";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'

export const Contact = () => (
  <div>
    <h2>Nous contacter</h2>

    <section>
      <p>Travail en cours, soyez patients <span role="img" aria-label="">😌</span></p>
    </section>

    <nav>
      <NavLink to="/"> <button> <FontAwesomeIcon icon="arrow-left" /> Retour</button>      </NavLink>
    </nav>
  </div>
);

export default Contact;