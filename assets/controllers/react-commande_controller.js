import {Controller} from "@hotwired/stimulus";
import ReactDOM from 'react-dom';
import React, {useEffect, useState} from "react";
import axios from "axios";

export default class extends Controller{
    connect() {
            const { id } = this.element.dataset;
            ReactDOM.render(<App id={id} />, this.element );
    }
}

const App = ( {id}) => {

    const [produitId , setProduitId] = React.useState('');
    const [quantity, setQuantity] = React.useState('');
    const [lignes, setLignes] = React.useState([]);
    const [choix, setChoix] = React.useState([]);

    React.useEffect(() =>{
        //le code ici ne sera éxécutée qu'une seule fois à l'initialisation du composant
        axios.get('http://127.0.0.1:8000/commandes/lines/' + id)
            .then(({ data }) => setLignes(data));
    },[]);

    const onClick =() =>{
        // envoyer vers API
        let fd = new FormData();
        fd.append('produitId', produitId);
        fd.append('quantity', quantity);
        axios.post('http://127.0.0.1:8000/commande/addLine/'+ id, fd)
            .then(({data}) => {
                //data corespond aux données envoyées par le serveur
                setLignes(data);
            });
    }

    const onInput = e => {
        let name = e.target.value;
        axios.get('http://127.0.0.1:8000/produit/search?name='  + name)
            .then(({data}) => setChoix(data));
    }


    return <div>
        <h4>Lignes de commande</h4>

        <div className={'row'}>
            <div className={'col-md-6'}>
                <label>Produit</label>
                <input className={'form-control'}
                       onChange ={e=> setProduitId(e.target.value)}
                       onInput = {onInput}
                       list ={'choix'}/>

                <datalist id={'choix'}>
                    {choix.map(c => <option key ={c.id} value={c.id}>
                        { c.nom }
                    </option> )}
                </datalist>

            </div>
            <div className={'col-md-6'}>
                <label>Quantité</label>
                <input className={'form-control'} onChange ={e=> setQuantity(e.target.value)}/>
            </div>
        </div>

        <button onClick={onClick} className={'btn btn-dark mt-2'}>Ajouter</button>
        <table className={"table"}>
            <thead>
                <tr>
                    <th >Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>SousTotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            {lignes.map(l => <tr key={l.id}>
                <td>{l.produitRef}</td>
                <td>{l.quantite}</td>
                <td>{l.prix}</td>
                <td>{l.prixTotal.toFixed(2)}</td>
                <td></td>
            </tr>)}
            </tbody>
        </table>
    </div>

}