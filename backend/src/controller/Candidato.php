<?php

include_once "./src/utils/Response.php";
include_once "./src/model/Candidato.php";

/**
 * Función para manejar la solicitud GET y obtener los candidatos por comuna.
 * 
 * Esta función verifica si el parámetro `comunaId` está presente en la solicitud GET.
 * Si el parámetro está presente, obtiene los candidatos correspondientes utilizando
 * la clase `Candidato` y devuelve la respuesta en formato JSON. Si el parámetro no
 * está presente, devuelve un mensaje de error en formato JSON.
 */
function get(){
    if(!isset($_GET["comunaId"])){
        Response::responseJson([
            "error"     => true,
            "response"  => "'comunaId' not found"
        ], 401);
    }

    Response::responseJson([
        "error"     => false,
        "response"  => (new Candidato())->get($_GET["comunaId"])
    ]);
}