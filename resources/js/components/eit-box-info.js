import { LitElement, html, css } from 'lit-element';


class EitBoxInfo  extends LitElement {

  static get styles() {
    return css`
      :host {
        display: block;
      }
      p{
        font-size: 1.7rem;
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
    this.message = "hola a todos"
  }

  render() {
    return html`
      <p>Soy la info box</p>
      <div>${this.message}</div>

    `;
  }
}

customElements.define('eit-box-info', EitBoxInfo);