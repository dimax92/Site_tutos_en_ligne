import React, {useState, useEffect} from "react";
import {useParams} from "react-router-dom";
import axios from "axios";
import Navigation from "../components/Navigation";

const Contenu = () => {
    const[titre, setTitre] = useState();
    const[contenu, setContenu] = useState([]);

    let { id } = useParams();

    function recevoirDonnees(id){
        axios.get("https://tutopy.com/backend/public/api/tutos/"+id)
        .then((result)=>{
            setTitre(result.data.titre);
            setContenu(JSON.parse(result.data.contenu));
        })
        .catch((error)=>{})
    }

    useEffect(()=>{
        recevoirDonnees(id);
    },[]);
    
    return (
        <div className="divContenu">
            <Navigation/>
            <h1>{titre}</h1>
            {contenu.map((response)=>{
                if(response.sous_titre){
                    return (<h2>{response.sous_titre}</h2>)
                }else{
                    return (<p>{response.paragraphe}</p>)
                }
            })}
        </div>
    )
}

export default Contenu;