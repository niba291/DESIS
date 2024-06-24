<?php 

include_once "./src/utils/Databases.php";

/**
 * Class Region
 * 
 * Esta clase maneja las operaciones relacionadas con la tabla `region`.
 */
class Region {
    
    /**
     * @var string $table Nombre de la tabla en la base de datos.
     */
    private $table  = "region";

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
     * Obtiene todos los registros de la tabla `region`.
     * 
     * @return array Devuelve un array de todos los registros en la tabla `region`.
     */
    public function get() : array {
        $query      = "SELECT * FROM $this->table";
        $stmt       = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

}