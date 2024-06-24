<?php

include_once "./src/utils/Response.php";
include_once "./src/model/Comuna.php";

/**
 * Función para manejar la solicitud GET y obtener las comunas por región.
 * 
 * Esta función verifica si el parámetro `regionId` está presente en la solicitud GET.
 * Si el parámetro está presente, obtiene las comunas correspondientes utilizando
 * la clase `Comuna` y devuelve la respuesta en formato JSON. Si el parámetro no
 * está presente, devuelve un mensaje de error en formato JSON.
 */
function get(){
    if(!isset($_GET["regionId"])){
        Response::responseJson([
            "error"     => true,
            "response"  => "'regionId' not found"
        ], 401);
    }

    Response::responseJson([
        "error"     => false,
        "response"  => (new Comuna())->get($_GET["regionId"])
    ]);
}