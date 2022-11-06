import React from "react";
import { NavLink } from "react-router-dom";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'

export const Contact = () => (
  <div>
    <h2>Nous contacter</h2>

    <section>
      <p>Pour avoir plus d'information sur le prochain rallye (qui débutera vers le 21 décembre), n'hésitez pas à nous contacter par email : </p>
      <span class="e-mail"></span>
      <p>Le Rallye d'Hiver n'est organisé que par des bénévoles, soyez sympa vis-à-vis de nos temps de réponse ;-) Mais n'hésitez pas à nous relancer si vous n'avez pas de réponses au bout de quelques jours !</p>
    </section>

    <nav>
      <NavLink to="/"> <button> <FontAwesomeIcon icon="arrow-left" /> Retour</button>      </NavLink>
    </nav>
  </div>
);

export default Contact;