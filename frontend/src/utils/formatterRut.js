export const formatterRut   = (rut) => {
    let value   = rut.replace(".","").replace("-","");
    let aux     = value.slice(0,-1);
    let dv      = value.slice(-1).toUpperCase();
    return value === "" ? "" : `${aux}-${dv}`;
};