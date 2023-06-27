<?php
class Modelo {
    private $servidor = "localhost";
    private $usuario = "root";
    private $password = "";
    private $basededatos = "crud_php";
    private $con;

    public function __construct() {
        $this->conectar();
    }

    private function conectar() {
        $this->con = mysqli_connect($this->servidor, $this->usuario, $this->password, $this->basededatos);
        if (mysqli_connect_errno()) {
            die("No se ha podido conectar al servidor de la base de datos: " . mysqli_connect_error());
        }
    }

    public function obtenerPasajeros() {
        $query = "SELECT * FROM table_pasajeros";
        $resultado = mysqli_query($this->con, $query);
        $pasajeros = array();

        while ($row = mysqli_fetch_assoc($resultado)) {
            $pasajero = array(
                'id' => $row['id'],
                'namefull' => $row['namefull'],
                'cedula' => $row['cedula'],
                'sexo' => $row['sexo'],
                'section' => $row['section'],
                'foto' => $row['foto'],
                'fechaRegistro' => $row['fechaRegistro']
            );
            $pasajeros[] = $pasajero;
        }

        return $pasajeros;
    }
}
?>
