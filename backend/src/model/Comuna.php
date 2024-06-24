<?php 

include_once "./src/utils/Databases.php";

/**
 * Class Comuna
 * 
 * Esta clase maneja las operaciones relacionadas con la tabla `comuna`.
 */
class Comuna {
    
    /**
     * @var string $table Nombre de la tabla en la base de datos.
     */
    private $table  = "comuna";
    
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
     * Obtiene los registros de la tabla `comuna` filtrados por `region_id`.
     * 
     * @param string $regionId ID de la región para filtrar los resultados.
     * @return array Devuelve un array de registros que coinciden con el `region_id`.
     */
    public function get(string $regionId = "") : array {
        $query      = "SELECT * FROM $this->table WHERE region_id = :region_id";
        $stmt       = $this->conn->prepare($query);        
        $stmt->bindParam(":region_id", $regionId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

}