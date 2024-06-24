<?php 

include_once "./src/utils/Databases.php";

/**
 * Class Candidato
 * 
 * Esta clase maneja las operaciones relacionadas con la tabla `candidato`.
 */
class Candidato {
    
    /**
     * @var string $table Nombre de la tabla en la base de datos.
     */
    private $table  = "candidato";

    /**
     * @var PDO|null $conn Conexión a la base de datos.
     */
    private $conn   = null;

    /**
     * Constructor de la clase.
     * 
     * Inicializa la conexión a la base de datos.
     */
    public function __construct(){
        $this->conn = (new Databases())->getConnection();
    }

    /**
     * Obtiene los registros de la tabla `candidato` filtrados por `comuna_id`.
     * 
     * @param string $comunaId ID de la comuna para filtrar los resultados.
     * @return array Devuelve un array de registros que coinciden con el `comuna_id`.
     */
    public function get(string $comunaId = "") : array {
        $query      = "SELECT * FROM $this->table WHERE comuna_id = :comuna_id";
        $stmt       = $this->conn->prepare($query);        
        $stmt->bindParam(":comuna_id", $comunaId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

}