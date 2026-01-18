<?php
class Conexion{
    
    public function conectar()
    {
        $ccn = mysqli_connect("localhost","root","migzam10","bd_venta");
        return $ccn;
    }
    public function test_input($data) {
        $cnn = self::conectar();
        
        $data = mysqli_real_escape_string($cnn,$data);
        //trim — Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadena
        $data = trim($data);
        ///tripslashes — Quita las barras de un string con comillas escapadas
        $data = stripslashes($data);
        //
        $data = htmlspecialchars($data);
        return $data;
      }
    
}

?>