import { request }                      from "./../utils/request.js";
import { setLabelError }                from "./../utils/setLabelError.js";
import { validatorRut }                 from "./../utils/validatorRut.js";
import { validatorEmail }               from "./../utils/validatorEmail.js";
import { validatorCharacterNumber }     from "./../utils/validatorCharacterNumber.js";
import { validation }                   from "./validation.js?v=0.0.6";
import { select }                       from "./select.js?v=0.0.4";

const frmVoto               = document.getElementById("frmVoto");
const txtName               = document.getElementById("txtName");
const txtRut                = document.getElementById("txtRut");
const txtAlias              = document.getElementById("txtAlias");
const txtEmail              = document.getElementById("txtEmail");
const slRegion              = document.getElementById("slRegion");
const slComuna              = document.getElementById("slComuna");
const slCandidato           = document.getElementById("slCandidato");
const cbxAbout              = document.getElementsByName("cbxAbout");

frmVoto.addEventListener("submit", async (e) => {
    e.preventDefault();
    
    if(txtRut === undefined || txtAlias === undefined || txtEmail === undefined || cbxAbout === undefined){
        return;
    }

    const prefix    = `${window.location.origin}/desis/backend/`;
    const action    = "?action=";
    const name      = txtName.value.trim();
    const rut       = txtRut.value.trim();
    const alias     = txtAlias.value.trim();
    const email     = txtEmail.value.trim();
    const region    = parseInt(slRegion.value);
    const comuna    = parseInt(slComuna.value);
    const candidato = parseInt(slCandidato.value);
    let about       = [];

    const valName       = name === "";
    const valRut        = !validatorRut(rut);
    const valAlias      = alias.length <= 5;
    const valAliasChr   = validatorCharacterNumber(alias);
    const valEmail      = validatorEmail(email);
    const valRegion     = region === 0;
    const valComuna     = comuna === 0;
    const valCandidato  = candidato === 0;
    const valAbout      = document.querySelectorAll("[name=cbxAbout]:checked").length < 2;

    setLabelError(txtName.id, valName, "No puede estar en blanco")
    setLabelError(txtRut.id, valRut);
    valAlias ? 
        setLabelError(txtAlias.id, valAlias, "Cantidad de caracteres sea mayor a 5."):
        setLabelError(txtAlias.id, valAliasChr, "Solo debe contener letras y numero.");
    setLabelError(txtEmail.id, valEmail);
    setLabelError(slRegion.id, valRegion);
    setLabelError(slComuna.id, valComuna);
    setLabelError(slCandidato.id, valCandidato);
    setLabelError("#lblCbxAbout", valAbout);

    if(
        valName ||
        valRut ||
        valAlias ||
        valAliasChr ||
        valEmail ||
        valRegion ||
        valComuna ||
        valCandidato ||
        valAbout
    ){
        return;
    }

    document.querySelectorAll("[name=cbxAbout]:checked").forEach((e) => {
        about       = [
            ...about,
            ...e.value
        ];
    });

    const data              = {
        "rut"               : rut, 
        "nombre_apellido"   : name, 
        "alias"             : alias, 
        "email"             : email, 
        "candidato"         : candidato, 
        "about"             : about
    }

    const response          = await request(`${prefix}/${action}voto`, {
        method              : "POST",
        body                : JSON.stringify(data)
    });

    if(response.error){
        alert(response.response);
        console.log(response.response);
        return;
    }

    alert("¡Se ha registrado su voto!");

});

validation(txtRut, txtAlias, txtEmail, cbxAbout);
select(slRegion, slComuna, slCandidato);