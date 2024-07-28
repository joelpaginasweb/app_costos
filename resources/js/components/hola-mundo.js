
class holaMundo extends HTMLElement {

  constructor () {
    super(); // definir variables 
    // console.log("hola mundo") //verificar que esta siendo llamado
    
    this.name;
    this.surname;
  }

    //pasar atributos
  static get observedAttributes(){
    //lista de atributos por observar
    return ['name', "surname"];

  }
  
  //recibe los atributos
  attributeChangedCallback(nameAtr, oldValue, newValue){
      switch(nameAtr){
        case "name":
          this.name = newValue;
        break;

        case "surname":
          this.surname = newValue;
        break;

      }
  }

  connectedCallback () {
    //comillas oblicuas para meter html Alt Gr + tecla llave }
    // imprime html
    this.innerHTML = `<div>
    <h3>native comp-hola mundo: ${this.name} ${this.surname}</h3>    
    </div>`; 
    this.style.color = "rgba(29, 38, 53, 0.7)";
    this.style.fontFamily = "sans-serif"
  }

  render() {
    return html`<p>Hellossssss, ${this.name}!</p>`;
  }
}

//api customElements define web component personalizado nombre html y clase
window.customElements.define("hola-mundo", holaMundo);// nombre del componente siempre con guion 


