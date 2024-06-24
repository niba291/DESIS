<?php

include_once "./src/utils/Response.php";
include_once "./src/utils/ValidatorRut.php";
include_once "./src/model/Voto.php";
include_once "./src/model/AboutVoto.php";

/**
 * Función para manejar la solicitud POST y procesar la inserción de datos de votos y detalles de votos.
 * 
 * Esta función realiza varias validaciones en los datos recibidos antes de intentar insertarlos en la base de datos.
 * Devuelve una respuesta JSON indicando si la inserción fue exitosa o si ocurrió algún error.
 * 
 * @param array $data Datos recibidos en la solicitud POST.
 */
function post($data){

    $keys       = ["rut", "nombre_apellido", "alias", "email", "candidato", "about"];

    foreach($keys as $item){
        if(!array_key_exists($item, $data)){
            Response::responseJson([
                "error"         => true,
                "response"      => "'$item' not found"
            ], 401);
        }
    }

    $matchesAlias       = [];
    $matchesEmail       = [];
    $rut                = $data["rut"];
    $name               = $data["nombre_apellido"];
    $alias              = $data["alias"];
    $email              = $data["email"];
    $candidato          = intval($data["candidato"]);
    $about              = $data["about"];

    if(!(new ValidatorRut())->validatorRut($rut)){
        Response::responseJson([
            "error"         => true,
            "response"      => "'Rut' invalid"
        ], 401);
    }

    if($name === ""){
        Response::responseJson([
            "error"         => true,
            "response"      => "'nombre_apellido' invalid"
        ], 401);
    }

    preg_match("/^[a-zA-Z0-9]*$/", $alias, $matchesAlias, PREG_OFFSET_CAPTURE);
    
    if(strlen($alias) < 5 || empty($matchesAlias)){
        Response::responseJson([
            "error"         => true,
            "response"      => "'alias' invalid"
        ], 401);
    }

    preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email, $matchesEmail, PREG_OFFSET_CAPTURE);

    if(empty($matchesEmail)){
        Response::responseJson([
            "error"         => true,
            "response"      => "'email' invalid"
        ], 401);
    }
    
    if(!is_array($about)){
        Response::responseJson([
            "error"         => true,
            "response"      => "'about' is not array"
        ], 401);
    }

    $objVoto            = new Voto();
    $objAboutVoto       = new AboutVoto();

    try{
        if(!$objVoto->insert($rut, $name, $alias, $email, $candidato)){
            Response::responseJson([
                "error"         => true,
                "response"      => "Fail insert voto"
            ]);
        }
    }catch(PDOException $ex){
        if($ex->getCode() === "23000" && str_contains($ex->getMessage(), "rut")){
            Response::responseJson([
                "error"         => true,
                "response"      => "este 'Rut' ya esta registrado como votado"
            ]);
        }
        
        if($ex->getCode() === "23000" && str_contains($ex->getMessage(), "candidato_id")){
            Response::responseJson([
                "error"         => true,
                "response"      => "No se encuentra este candidato"
            ]);
        }
    }

    try{
        if(!$objAboutVoto->insert($about, $objVoto->getId())){
            Response::responseJson([
                "error"         => true,
                "response"      => "Fail insert about_voto"
            ]);
        }
    }catch(PDOException $ex){
        if($ex->getCode() === "23000" && str_contains($ex->getMessage(), "about_id")){
            Response::responseJson([
                "error"         => true,
                "response"      => "No se encuentra este medio"
            ]);
        }
    }

    Response::responseJson([
        "error"         => false,
        "response"      => "ok"
    ]);

}