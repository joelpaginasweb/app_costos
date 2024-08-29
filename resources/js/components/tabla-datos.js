import { LitElement, html, css } from 'lit-element';

class TablaDatos  extends LitElement {

  static properties = {
    conceptos: {type: Array}
  };

  static get styles() {
    return css`
      :host {
        display: block;
      }
      span{
        font-size: 1.2rem;
        color: blue;
      }
    `;
  }

  static get properties() {
    return {
    message: {type: String},
    };
  }

  constructor() {
    super();
    this.message = "b component con Lit.devwe"
  }

  render() {
    return html`
      <br>
      <span>-Lit Component</span>
      <br>
      <span>${this.message}</span>
      <ul>
      ${this.conceptos.map(concepto => html`
      <li>${concepto.id} - ${concepto.concepto}</li>
      ` )}
      </ul>
    `;
  }
}

customElements.define('tabla-datos', TablaDatos);