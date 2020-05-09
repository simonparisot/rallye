import React from "react";
import ReactDOM from "react-dom";
import Main from "./Main";
import ReactGA from 'react-ga';
ReactGA.initialize('UA-62904031-1');
ReactGA.pageview(window.location.pathname + window.location.search);
 
ReactDOM.render(
  <Main/>, 
  document.getElementById("root")
);