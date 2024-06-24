<?php 

/**
 * Clase ValidatorRut para validar el RUT chileno.
 */
class ValidatorRut {

    /**
     * Valida un RUT chileno.
     *
     * @param string $rut El RUT a validar.
     * @return bool True si el RUT es válido, False si no.
     */
    public function validatorRut($rut = "") : bool {
        
        if($rut === ""){
            return false;
        }

        $matches    = [];
        
        preg_match("/^[0-9]+[-|‐]{1}[0-9kK]{1}$/", $rut, $matches, PREG_OFFSET_CAPTURE);

        if(empty($matches)){
            return false;
        }

        $tmp        = explode("-", $rut);
        $rutAux     = $tmp[0];
        $dv         = strtolower($tmp[1]);
        return $this->validatorDv($rutAux) === $dv;
    }

    /**
     * Calcula y valida el dígito verificador de un RUT chileno.
     *
     * @param int|string $T Parte numérica del RUT.
     * @return string El dígito verificador calculado ('k' si es válido, o un dígito numérico).
     */
    private function validatorDv($T) : string{
        $T = intval($T);
        $M = 0;
        $S = 1;
        while ($T) {
            $S = ($S + $T % 10 * (9 - $M++ % 6)) % 11;
            $T = floor($T / 10);
        }
        return $S ? strval($S - 1) : "k";
    }
}