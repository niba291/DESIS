<?php

include_once "./src/utils/Response.php";
include_once "./src/model/Region.php";

/**
 * Función para manejar la solicitud GET y obtener todos los registros de regiones.
 * 
 * Esta función utiliza la clase `Region` para obtener todos los registros de la tabla `region`
 * y luego envía estos registros como una respuesta JSON utilizando la clase `Response`.
 */
function get(){
    Response::responseJson([
        "error"     => false,
        "response"  => (new Region())->get()
    ]);
}