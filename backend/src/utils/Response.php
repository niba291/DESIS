<?php 

/**
 * Clase Response para manejar respuestas HTTP JSON.
 */
class Response {

    /**
     * Definición de códigos de estado y su descripción.
     */
    const CODE          = [
        200             => "200 OK",
        400             => "400 No found",
        401             => "401 Bad request"
    ];

    /**
     * Envía una respuesta JSON al cliente.
     *
     * @param array $data Datos para incluir en la respuesta JSON.
     * @param int $code Código de estado HTTP para la respuesta (por defecto 200).
     * @return void
     */
    static public function responseJson(array $data = [], int $code = 200) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: X-Requested-With");
        header("HTTP/1.1 " . Response::CODE[$code]);
        header("Content-Type: application/json; charset=utf-8");
        print_r(json_encode($data));
        exit;
    }
}