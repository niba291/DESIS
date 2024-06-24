import { request }                      from "../utils/request.js";
import { setLabelError }                from "../utils/setLabelError.js";

const prefix            = `${window.location.origin}/desis/backend/`;
const action            = "?action=";

export const select     = (slRegion = undefined, slComuna = undefined, slCandidato = undefined) => {

    if(slRegion === undefined || slComuna === undefined || slCandidato === undefined){
        return;
    }

    getDataRegion(slRegion);

    slRegion.addEventListener("change", (e) => {
        setLabelError(e.target.id, parseInt(e.target.value) === 0);
        if(parseInt(e.target.value) === 0){
            slCandidato.setAttribute("disabled", "");
            slComuna.setAttribute("disabled", "");
            slCandidato.innerHTML = `<option value="0">---</option>`;
            slComuna.innerHTML = `<option value="0">---</option>`;
            return;
        }
        
        slComuna.removeAttribute("disabled");
        getDataComuna(slComuna, e.target.value);
    });
    
    slComuna.addEventListener("change", (e) => {
        setLabelError(e.target.id, parseInt(e.target.value) === 0);
        if(parseInt(e.target.value) === 0){
            slCandidato.setAttribute("disabled", "");
            slCandidato.innerHTML = `<option value="0">---</option>`;
            return;
        }

        slCandidato.removeAttribute("disabled");
        getDataCandidato(slCandidato, e.target.value);
    });

    slCandidato.addEventListener("change", (e) => {
        setLabelError(e.target.id, parseInt(e.target.value) === 0);
    });

};

const getDataRegion     = async (slRegion) => {
    const response      = await request(`${prefix}/${action}region`);
    let options         = `<option value="0">Selecione una región</option>`;
    if(response.error){
        alert("Error por favor contactese con el desarrollador");
        console.log(response.response);
        return;
    }
    
    for(let item of response.response){
        options         += `<option value="${item.region_id}">${item.name}</option>`;
    }

    slRegion.innerHTML = options;
};

const getDataComuna     = async (slComuna, idRegion) => {
    const response      = await request(`${prefix}/${action}comuna&regionId=${idRegion}`);
    let options         = `<option value="0">Selecione una comuna</option>`;
    if(response.error){
        alert("Error por favor contactese con el desarrollador");
        console.log(response.response);
        return;
    }
    
    for(let item of response.response){
        options         += `<option value="${item.comuna_id}">${item.name}</option>`;
    }

    slComuna.innerHTML = options;
};

const getDataCandidato  = async (slComuna, idComuna) => {
    console.log(idComuna);
    const response      = await request(`${prefix}/${action}candidato&comunaId=${idComuna}`);
    let options         = `<option value="0">Selecione una comuna</option>`;
    if(response.error){
        alert("Error por favor contactese con el desarrollador");
        console.log(response.response);
        return;
    }
    
    for(let item of response.response){
        options         += `<option value="${item.candidato_id}">${item.name}</option>`;
    }

    slComuna.innerHTML = options;
};