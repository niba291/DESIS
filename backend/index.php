<?php

include_once "./src/utils/Dotenv.php";
include_once "./src/utils/Response.php";

(new Dotenv())->load();

if(!isset($_GET["action"])){
    Response::responseJson([
        "error"     => true,
        "response"  => "'action' not found"
    ]);
}

$action         = strtolower($_GET["action"]);
$method         = strtolower($_SERVER["REQUEST_METHOD"]);
$routes         = [
    "region"    => "./src/controller/Region.php",
    "comuna"    => "./src/controller/Comuna.php",
    "candidato" => "./src/controller/Candidato.php",
    "voto"      => "./src/controller/Voto.php"
];

if(!array_key_exists($action, $routes)){
    Response::responseJson([
        "error"     => true,
        "response"  => "'action' invalid"
    ], 401);
}

include_once $routes[$action];

switch($method){
    case "get": get(); break;
    case "post": post(json_decode(file_get_contents("php://input"), true)); break;
    default: 
        Response::responseJson([
            "error"     => true,
            "response"  => "'method' invalid"
        ], 401);
    break;
}