import { validatorRut }                 from "../utils/validatorRut.js";
import { formatterRut }                 from "../utils/formatterRut.js";
import { validatorEmail }               from "../utils/validatorEmail.js";
import { validatorCharacterNumber }     from "../utils/validatorCharacterNumber.js";
import { setLabelError }                from "../utils/setLabelError.js";

export const validation     = (txtRut = undefined, txtAlias = undefined, txtEmail = undefined, cbxAbout = undefined) => {
    if(txtRut === undefined || txtAlias === undefined || txtEmail === undefined || cbxAbout === undefined){
        return;
    }

    txtAlias.addEventListener("input", (e) => {
        const isLength      = e.target.value.trim().length <= 5;
        isLength ? 
            setLabelError(e.target.id, isLength, "Cantidad de caracteres sea mayor a 5.") : 
            setLabelError(e.target.id, validatorCharacterNumber(e.target.value.trim()), "Solo debe contener letras y numero.");
    });

    txtEmail.addEventListener("input", (e) => {
        setLabelError(e.target.id, validatorEmail(e.target.value.trim()));
    });
    
    txtRut.addEventListener("input", (e) => {
        e.target.value      = formatterRut(e.target.value);
        setLabelError(e.target.id, !validatorRut(e.target.value.trim()));
    });

    cbxAbout.forEach((element) => {
        element.addEventListener("change", (e) => {
            setLabelError("#lblCbxAbout", document.querySelectorAll("[name=cbxAbout]:checked").length < 2);
        });
    });
};