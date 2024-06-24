export const validatorRut 	= (rut) => {
	const regExp 	= /^[0-9]+[-|‐]{1}[0-9kK]{1}$/;
	const dv 		= (T) => {
		let M=0,S=1;
		for(;T;T=Math.floor(T/10))
			S=(S+T%10*(9-M++%6))%11;
		return S ? S-1 : "k";
	};
	if (!regExp.test(rut)) return false;			
	let tmp 		= rut.split("-");
	let digv		= tmp[1]; 
	let rutAux 		= tmp[0];
	if (digv == "K") digv = "k";
	return dv(rutAux) == digv;
};