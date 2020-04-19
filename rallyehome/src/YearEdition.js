import React, { Component } from "react";

class YearEdition extends Component {
	render() {
		
		if (this.props.url === "") {

			return(
				<div class="year-edition">
					<img src={require('./res/rallye'+this.props.year+'.jpg')} alt="" />
					<div>
						<p>{this.props.year}<br/>
						{this.props.theme}</p>
					</div>
		        </div>
			);

		}else{

			return(
				<a class="year-edition" href={this.props.url} target="_blank" rel="noopener noreferrer">
					<img src={require('./res/rallye'+this.props.year+'.jpg')} alt="" />
					<div>
						<p>{this.props.year}<br/>
						{this.props.theme}</p>
					</div>
		        </a>
			);

		}
	}
}

export default YearEdition;