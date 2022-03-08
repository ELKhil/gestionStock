import {Controller} from "@hotwired/stimulus";

export default class extends Controller{

    connect(){
        const modal =  document.getElementById('my-modal');
        const confirmButton = document.getElementById('confirm-button');

        let href;

        modal.addEventListener('show.bs.modal', e =>{
            console.log(e.relatedTarget);
            href = e.relatedTarget.getAttribute('href');

        })

        confirmButton.addEventListener('click', e=>{
            window.location.href= href;
        })
    }
}