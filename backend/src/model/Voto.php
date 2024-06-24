<?php 

include_once "./src/utils/Databases.php";

/**
 * Class Voto
 * 
 * Esta clase maneja las operaciones relacionadas con la tabla `voto`.
 */
class Voto {
    
    /**
     * @var string $table Nombre de la tabla en la base de datos.
     */
    private $table  = "voto";

    /**
     * @var int $id ID del último voto insertado.
     */
    private $id     = 0;

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
     * Obtiene el ID del último voto insertado.
     * 
     * @return int Devuelve el ID del último voto insertado.
     */
    public function getId() : int{
        return $this->id;
    }

    /**
     * Inserta un nuevo registro en la tabla `voto`.
     * 
     * @param string $rut RUT del votante.
     * @param string $nombreApellido Nombre y apellido del votante.
     * @param string $alias Alias del votante.
     * @param string $email Email del votante.
     * @param int $candidatoId ID del candidato votado.
     * @return bool Devuelve true si la inserción fue exitosa, de lo contrario false.
     */
    public function insert(string $rut = "", string $nombreApellido = "", string $alias = "", string $email = "", int $candidatoId = 0) : bool {
        $query          = "INSERT INTO $this->table (rut, nombre_apellido, alias, email, candidato_id) VALUES (:rut, :nombre_apellido, :alias, :email, :candidato_id)";
        $stmt           = $this->conn->prepare($query);
        $stmt->bindParam(":rut", $rut);
        $stmt->bindParam(":nombre_apellido", $nombreApellido);
        $stmt->bindParam(":alias", $alias);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":candidato_id", $candidatoId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $this->id   = $this->conn->lastInsertId();
            return true;
        }

        return true;
    }

}