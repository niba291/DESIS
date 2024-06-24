<?php

/**
 * Clase Dotenv para cargar variables de entorno desde un archivo .env.
 */
class Dotenv {

    /**
     * @var string Ruta al archivo .env.
     */
    private $path;

    /**
     * Constructor de la clase Dotenv.
     *
     * @param string|null $path Ruta opcional al archivo .env. Si no se proporciona,
     *                          se buscará en la raíz del proyecto.
     * @throws Exception Si no se encuentra el archivo .env en la ruta especificada.
     */
    public function __construct($path = null) {

        if ($path === null) {
            $path = $this->getProjectRoot() . "/.env";
        }

        if (!file_exists($path)) {
            throw new Exception("El archivo .env no existe en la ruta especificada.");
        }
        $this->path = $path;
    }

    /**
     * Carga las variables de entorno desde el archivo .env.
     *
     * @throws Exception Si el archivo .env no es legible.
     */
    public function load() {
     
        if (!is_readable($this->path)) {
            throw new Exception("El archivo .env no es legible.");
        }

        $lines  = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), "#") === 0) {
                continue;
            }

            list($name, $value) = explode("=", $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv("$name=$value");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

    /**
     * Obtiene el valor de una variable de entorno.
     *
     * @param string $key La clave de la variable de entorno.
     * @return string|null El valor de la variable de entorno si existe, o null si no existe.
     */
    public function get($key) {
        if (array_key_exists($key, $_ENV)) {
            return $_ENV[$key];
        } elseif (array_key_exists($key, $_SERVER)) {
            return $_SERVER[$key];
        } else {
            return null;
        }
    }

    /**
     * Obtiene la ruta de la raíz del proyecto donde se encuentra el archivo .env.
     *
     * @return string La ruta de la raíz del proyecto.
     * @throws Exception Si no se encuentra el archivo .env en la raíz del proyecto.
     */
    private function getProjectRoot() {
        $currentDir = __DIR__;
        while (!file_exists($currentDir . "/.env") && $currentDir !== "/") {
            $currentDir = dirname($currentDir);
        }

        if ($currentDir === "/") {
            throw new Exception("No se encontró el archivo .env en la raíz del proyecto.");
        }

        return $currentDir;
    }
}