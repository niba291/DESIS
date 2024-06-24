<?php 

class Databases {

    private $conn;

    /**
     * Establece y devuelve una conexión PDO a la base de datos.
     *
     * @return PDO|false Retorna la conexión PDO si se establece correctamente, o false si hay un error.
     */
    public function getConnection() {
        $this->conn     = null;
        try {
            $this->conn = new PDO("mysql:host=" . $_ENV["HOST"] . ";port=" . $_ENV["PORT"] . ";dbname=" . $_ENV["DB_NAME"], $_ENV["USERNAME"], $_ENV["PASSWORD"]);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            return $exception->getMessage();
        }
        return $this->conn;
    }

    /**
     * Crea la base de datos si no existe y ejecuta un archivo SQL para migrar el esquema.
     *
     * @return void
     */
    public function migrate(){
        $this->conn = new PDO("mysql:host=" . $_ENV["HOST"] . ";port=" . $_ENV["PORT"], $_ENV["USERNAME"], $_ENV["PASSWORD"]);
        $dbname     = "`" . $_ENV["DB_NAME"] . "`";
        $this->conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
        $this->conn->query("use $dbname");
        $this->conn->exec(file_get_contents("./../SQL/desis.sql"));
    }

    /**
     * Cierra la conexión PDO establecida.
     *
     * @return void
     */
    public function closeConnection() {
        $this->conn = null;
    }
}