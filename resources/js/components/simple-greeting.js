
import {html, css, LitElement} from 'lit';

export class SimpleGreeting extends LitElement {
  static styles = css`span { color: red }`;

  static properties = {
    name: {type: String},
  };

  constructor() {
    super();
    this.name = 'Somebody';
  }

  render() {
    return html`<span>Hello, ${this.name}!</span>`;
  }

}

customElements.define('simple-greeting', SimpleGreeting);