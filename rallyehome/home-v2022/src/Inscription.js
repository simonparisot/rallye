import React, { Component } from "react";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { NavLink } from "react-router-dom";
 
class Inscription extends Component {
  render() {
    return (
      <div>
        <h2>Inscription</h2>
        
        <section>
          <p> Pour participer au Rallye d'Hiver 2020, formez une équipe (habituellement de 2 à 6 personnes), donnez lui un nom, désignez un chef d'équipe et réglez les frais d'inscription (26€ par équipe) par CB ou bien par chèque.</p>
          
          <form id="signup-form">
            
            <div class="guys">
              <input type="text" name="admin-name" id="admin-name" class="" placeholder="Prénom et nom du chef d'équipe" required />
              <input type="mail" name="admin-mail" id="admin-mail" class="mailinput" placeholder="Son adresse e-mail" required />
              <div id="addCo" onclick="ajouterCo();"> <img src="./res/addco.png" alt=""/> </div>
            </div>

            <div class="team">
              <input type="text" name="team-name" id="team-name" class="" placeholder="Nom de votre équipe" required />
              <input type="submit" value="S'inscrire" class="button" onclick="signup(); return false;" />
            </div>

          </form>

          <div id="form-error"></div>

          <p>Les frais d'inscription, modiques (26€ par équipe, quelque soit le nombre de participants), servent essentiellement à rembourser les frais informatiques et à acheter des lots pour récompenser toutes les équipes lors d'un grand diner de cloture en avril.</p>
        </section>

        <nav>
          <NavLink to="/"> <button> <FontAwesomeIcon icon="arrow-left" /> Retour</button>      </NavLink>
        </nav>

      </div>
    );
  }
}
 
export default Inscription;