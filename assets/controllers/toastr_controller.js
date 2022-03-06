import {Controller} from "@hotwired/stimulus";
import toastr from 'toastr';


//un controller doit impérativement etre enregistrer dans boostrap.js
export default class extends Controller{
    //cette mthode n'est appelée que si l'html
    //possède une div qui possede l'attribut data-controller='toastr'
    connect() {
        //la div qui a été utilisée pour appelée le controller


        //récupére l'attribut message de la div
        //let message = this.element.getAttribute('data-message');
        //let status = this.element.getAttribute('data-status');

        //forme raccourcie ene javaScript pour récupérer les attribut data-
         const {message , status} = this.element.dataset;


        toastr[status](message);
    }
}