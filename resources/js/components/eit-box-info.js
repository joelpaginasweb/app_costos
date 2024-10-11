import { LitElement, html, css } from 'lit-element';

class EitBoxInfo  extends LitElement {

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
    this.message = "web component con Lit.dev"
  }

  render() {
    return html`      
      <span>-Lit Component</span>
      <br>
      <span>${this.message}</span>
    `;
  }
}

customElements.define('eit-box-info', EitBoxInfo);