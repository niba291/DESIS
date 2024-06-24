<?php 

include_once "./src/utils/Databases.php";

/**
 * Class AboutVoto
 * 
 * Esta clase maneja las operaciones de inserción en la tabla `about_voto`.
 */
class AboutVoto {
    
    /**
     * @var string $table Nombre de la tabla en la base de datos.
     */
    private $table  = "about_voto";

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
     * Inserta múltiples registros en la tabla `about_voto`.
     * 
     * @param array $aboutId Array de IDs que representan `about_id`.
     * @param int $votoId ID que representa `voto_id`.
     * @return bool Devuelve true si la inserción fue exitosa, de lo contrario false.
     */
    public function insert(array $aboutId = [], int $votoId = 0) : bool {

        if(empty($aboutId)){
            return false;
        }        

        $placeholders       = [];
        
        foreach ($aboutId as $index => $id) {
            $placeholders[] = "(:about_id_$index, :voto_id)";
        }

        $placeholdersString = implode(", ", $placeholders);

        // $query      = "INSERT INTO $this->table (about_id, voto_id) VALUES (:about_id, :voto_id)";
        $query      = "INSERT INTO $this->table (about_id, voto_id) VALUES $placeholdersString";
        $stmt       = $this->conn->prepare($query);
        // $stmt->bindParam(":about_id", $aboutId, PDO::PARAM_INT);
        
        foreach ($aboutId as $index => $id) {
            $stmt->bindValue(":about_id_$index", $id, PDO::PARAM_INT);
        }

        $stmt->bindParam(":voto_id", $votoId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}